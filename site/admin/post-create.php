<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;
use Blog\Utils;

if (session_id() == "") session_start();
$user = null;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = DB::getUserById($_SESSION['user_id']);
if (isset($_POST['blog_title'], $_POST['blog_text'], $_POST['blog_cat'], $_FILES['title_img'], $_POST['check_list']) &&
    !empty($_POST['blog_title']) && !empty($_POST['blog_text']) && !empty($_POST['blog_cat']) && !empty($_FILES['title_img']) && !empty($_POST['check_list'])) {
    $title = \Blog\Utils::filterInput($_POST['blog_title']);
    $blogText = $_POST['blog_text'];
    $blogCategoryID = \Blog\Utils::filterInput($_POST['blog_cat']);
    $authorID = \Blog\Utils::filterInput($_SESSION['user_id']);

    $valid_extensions = ["jpg", "jpeg", "png"];

    $titleImg = $_FILES['title_img'];
    $extension = pathinfo($titleImg['name'], PATHINFO_EXTENSION);

    if (!\Blog\Utils::contains($valid_extensions, $extension, count($valid_extensions)) || $titleImg['error'] != '0' || $titleImg['size'] == 0) {
        $message = "Invalid Cover Image";
    } else {
        $imageSavePath = "../images/" . time() . rand(0, 10000) . ".$extension";
        $conn = DB::conn();
        $blogID = -1;
        if (DB::addBlogPost($title, $blogText, $imageSavePath, $authorID, $blogCategoryID, $blogID)) {
            move_uploaded_file($titleImg['tmp_name'], $imageSavePath);

            $sql = "INSERT INTO blogs_has_tags(blogs_id, tags_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            foreach ($_POST['check_list'] as $check) {
                $tagID = (int)$check;
                if ($check == '0' || is_int($tagID)) {
                    $stmt->bind_param("ii", $blogID, $tagID);
                    $res = $stmt->execute();
                }
            }
            $stmt->close();
            header("Location: post-create.php?msg=blog-save-success");
        } else {
            header("Location: post-create.php?msg=blog-save-failed");
            $_SESSION['cause'] = "DB Connection Error";
            \Blog\MyLogger::dbg($conn->error);
        }
    }
} else if (isset($_POST['submit']))
    header("Location: post-create.php?msg=blog-save-failed");
$_SESSION['cause'] = "Incomplete Form Submitted";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/coliff/bootstrap-rfs/bootstrap-rfs.css">-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <!--Details instruction https://google.github.io/material-design-icons/#icon-font-for-the-web -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Open+Sans&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="css/font-awesome.css">-->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <title>Write Post</title>
</head>

<body>
<nav class="py-1 navbar navbar-expand-sm bg-dark navbar-dark shadow" style="z-index: 1000000;">
    <div class="navbar-brand mr-auto">
        <a href="../index.php" class="nav-link text-uppercase brand-font text-white font-weight-bolder">My Blog</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navContent">
        <div class="w-100 navbar-nav d-flex justify-content-sm-end align-items-end">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link text-white text-right active" type="button"
                   id="dropdownMenuButton"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img style="height: 40px;" class="p-0 w-auto rounded-circle mr-3"
                         src="<?php echo $user->profile_pic_path ?>" alt="profile picture">
                    <?php echo $user->name ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="profile.php">
                        <span class="material-icons mr-1">manage_accounts</span>
                        <span>Profile</span>
                    </a>
                    <a class="dropdown-item" href="logout.php">
                        <span class="material-icons mr-1">logout</span>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php if (isset($_GET['msg']) && strlen($_GET['msg']) > 0) {
    if ($_GET['msg'] === "blog-save-success") {
        echo "<div class='alert alert-success col-md-6 mx-auto mt-1' role='alert'>Blog Saved Successfully";
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>';
    } else if ($_GET['msg'] === "blog-save-failed") {
        echo "<div class='alert alert-warning col-md-6 mx-auto mt-1' role='alert'>Blog Save Failed.";
        if (isset($_SESSION['cause'])) {
            echo " " . $_SESSION['cause'];
            $_SESSION['cause'] = '';
            unset($_SESSION['cause']);
        }
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>';
    }
    unset($_GET['msg']);
} ?>
<div class="container-fluid">
    <div class="row mt-5 position-relative">
        <div class="col-3 col-md-2 p-0 m-0 pt-1 h-100 ml-md-3 rounded"
             style="background-color: #444a50; position: sticky; top: 1px;">
            <ul class="list-group p-0">
                <li class="px-2 list-group-item border-right-0 ">
                    <a href="index.php" class="text-light d-flex align-bottom">
                        <span class="material-icons mr-1">article</span>
                        <span class="d-none d-sm-inline">Blog Posts</span>
                    </a>
                </li>
                <li class="px-2 list-group-item border-right-0  active">
                    <a href="post-create.php" class="text-light d-flex align-bottom">
                        <span class="material-icons mr-1">edit</span>
                        <span class="d-none d-sm-inline">Write Post</span>
                    </a>
                </li>
                <li class="px-2 list-group-item border-right-0">
                    <a href="comments.php" class="text-light d-flex align-bottom">
                        <span class="material-icons mr-1">forum</span>
                        <span class="d-none d-sm-inline">Comments</span>
                    </a>
                </li>
                <?php if ($user->isAdmin) { ?>
                    <li class="px-2 list-group-item border-right-0">
                        <a href="users.php" class="text-light d-flex align-bottom">
                            <span class="material-icons mr-1">people</span>
                            <span class="d-none d-sm-inline">Users</span>
                        </a>
                    </li>
                    <li class="px-2 list-group-item border-right-0">
                        <a href="categories.php" class="text-light d-flex align-bottom">
                            <span class="material-icons mr-1">category</span>
                            <span class="d-none d-sm-inline">Categories</span>
                        </a>
                    </li>
                    <li class="px-2 list-group-item border-right-0">
                        <a href="tags.php" class="text-light d-flex align-bottom">
                            <span class="material-icons mr-1">tag</span>
                            <span class="d-none d-sm-inline">Tags</span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="px-2 list-group-item  border-right-0">
                        <a href="profile.php" class="text-light d-flex align-bottom">
                            <span class="material-icons mr-1">manage_accounts</span>
                            <span class="d-none d-sm-inline">Profile</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div><!--left panel-->
        <div class="col-7 col-md-8">
            <form class="col-10 col-md-8 mx-auto mb-3" method="post" action="post-create.php"
                  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="blogTitle">Blog Title</label>
                    <input name="blog_title" type="text" class="form-control" id="blogTitle"
                           placeholder="Blog Title"
                           autofocus required>
                </div>
                <div class="form-group">
                    <label for="blogText">Blog Text</label>
                    <textarea name="blog_text" class="form-control w-100" id="blogText" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label for="blogCategory">Blog Category</label>
                    <select name="blog_cat" class="form-control" id="blogCategory" required>
                        <option selected disabled value="">Select Blog Category</option>
                        <?php
                        $result = DB::conn()->query("SELECT * FROM categories;");
                        while (($row = $result->fetch_assoc())) {
                            $cat_id = $row['id'];
                            $catgr = $row['category_name'];
                            echo "<option class='nav-link text-uppercase' value='$cat_id'>$catgr</option>";
                        }
                        ?>
                    </select>
                </div>
                <!--<p class="mb-0">Tags (select at least one)</p>-->
                <div class="form-group">
                    <label for="tag_sel">Select Tags</label>
                    <select class="custom-select my-1 mx-0" id="tag_sel" name="check_list[]" multiple="multiple"
                            required></select>
                    <a id="addNewTags" target="_blank"
                       class="btn btn-sm btn-outline-secondary py-0 my-1 d-inline-flex align-items-center"
                       href="tags.php">
                        <span class="material-icons">add</span>
                        Add More Tags
                    </a>
                </div>
                <div class="form-group mt-3">
                    <label for="title-img">Cover Image</label>
                    <input type="file" class="form-control-file" name="title_img" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" id="submit_btn"
                        onclick="nicEditors.findEditor('blogText').saveContent();">Submit
                </button>
            </form>
        </div>
    </div>
</div>

<script src="../js/jquery-3.5.1.slim.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!--nicEditor-->
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        new nicEditor({fullPanel: true}).panelInstance('blogText');

        //select2 with dynamic tag load
        $('#tag_sel').select2({
            ajax: {
                type: 'GET',
                url: '<?php echo Utils::getBaseUrl() . "/admin/tags-json.php"?>',
                dataType: 'json'
            }
        });
    });
</script>
</body>
</html>
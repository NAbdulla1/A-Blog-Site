<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;
use Blog\MyLogger;
use Blog\Utils;

if (session_id() == "") session_start();
$user = null;
$msg = "not";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = DB::getUserById($_SESSION['user_id']);

$editBlg = null;
$editBlgId = null;
if (isset($_GET['id'])) {
    $editBlgId = $_GET['id'];
    $editBlg = DB::conn()->query("SELECT * FROM blogs where id = $editBlgId;");
    if ($editBlg) {
        $editBlg = $editBlg->fetch_assoc();
        if (!$user->isAdmin && $editBlg['author_id'] != $user->id) {
            $_SESSION['msgg'] = 'no_permission';
            header("Location: index.php");
            exit();
        }
    } else $msg = "no_id";
} else $msg = "no_id";

if (isset($_POST['blog_title'], $_POST['blog_text'], $_POST['blog_cat'], $_FILES['title_img'], $_POST['check_list']) &&
    !empty($_POST['blog_title']) && !empty($_POST['blog_text']) && !empty($_POST['blog_cat']) && !empty($_FILES['title_img']) && !empty($_POST['check_list'])) {
    $title = Utils::filterInput($_POST['blog_title']);
    $blogText = Utils::filterInput($_POST['blog_text']);
    $blogCategoryID = Utils::filterInput($_POST['blog_cat']);
    $authorID = Utils::filterInput($_SESSION['user_id']);

    $valid_extensions = ["jpg", "jpeg", "png"];

    $titleImg = $_FILES['title_img'];
    $extension = pathinfo($titleImg['name'], PATHINFO_EXTENSION);

    if (!Utils::contains($valid_extensions, $extension, count($valid_extensions)) || $titleImg['error'] != '0' || $titleImg['size'] == 0) {
        $message = "Invalid Cover Image";
    } else {
        $conn = DB::conn();
        $blogID = $editBlgId;
        $imageSavePath = $conn->query("SELECT title_img_path FROM blogs WHERE id = $blogID;")->fetch_assoc()['title_img_path'];
        if (pathinfo($imageSavePath, PATHINFO_EXTENSION) != $extension) {
            unlink($imageSavePath);
        }
        $imageSavePath = "../images/" . pathinfo($imageSavePath, PATHINFO_FILENAME) . "." . $extension;
        if (DB::updateBlogPost($title, $blogText, $imageSavePath, $blogCategoryID, $blogID)) {
            move_uploaded_file($titleImg['tmp_name'], $imageSavePath);

            //delete previous images
            $res = $conn->query("SELECT * FROM blog_images WHERE blog_id = $blogID;");
            while (($rr = $res->fetch_assoc())) {
                if (unlink($rr['path'])) $conn->query("DELETE FROM blog_images WHERE blog_id = $blogID");
            }

            //insert new images
            $otherImgOk = true;
            $sql = "INSERT INTO blog_images(path, blog_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            for ($img = 1; $img <= 3; $img++) {
                $otherImgName = "other_img$img";
                if (!isset($_FILES[$otherImgName])) {
                    continue;
                }

                $otherImg = $_FILES[$otherImgName];
                $extension = pathinfo($otherImg['name'], PATHINFO_EXTENSION);
                if (!Utils::contains($valid_extensions, $extension, count($valid_extensions)) || $otherImg['error'] != '0' || $otherImg['size'] == 0) {
                    MyLogger::dbg("Invalid image: $otherImgName");
                    continue;
                }
                $otherImageSavePath = "../images/" . time() . rand(0, 10000) . ".$extension";
                $stmt->bind_param("si", $otherImageSavePath, $blogID);
                if ($stmt->execute()) {
                    move_uploaded_file($otherImg['tmp_name'], $otherImageSavePath);
                } else {
                    $otherImgOk = false;
                }
            }
            $stmt->close();

            //delete previous tags
            $res = $conn->query("SELECT * FROM blogs_has_tags WHERE blogs_id = $blogID;");
            while (($rr = $res->fetch_assoc())) {
                $conn->query("DELETE FROM blogs_has_tags WHERE blogs_id = $blogID");
            }

            //insert new tags
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
            header("Location: post-edit.php?id=$editBlgId&msg=blog-update-success&allOk=$otherImgOk");
        } else {
            header("Location: post-edit.php?id=$editBlgId&msg=blog-update-failed");
            $_SESSION['cause'] = "DB Connection Error";
            MyLogger::dbg($conn->error);
        }
    }
} else if (isset($_POST['submit']))
    header("Location: post-create.php?id=$editBlgId&msg=blog-update-failed");
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
    <link rel="stylesheet" href="style.css">
    <title>Edit Post</title>
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
    if ($_GET['msg'] === "blog-update-success") {
        echo "<div class='alert alert-success col-md-6 mx-auto mt-1' role='alert'>Blog Updated Successfully";
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></div>';
    } else if ($_GET['msg'] === "blog-update-failed") {
        echo "<div class='alert alert-warning col-md-6 mx-auto mt-1' role='alert'>Blog Update Failed.";
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
}

if ($msg == "failed")
    echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">Edit Post Failed<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
else if ($msg == 'edited')
    echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Post edited successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
else if ($msg == "no_id")
    echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">No post to edit<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
?>

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
                <li class="px-2 list-group-item border-right-0 active">
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
            <form class="col-10 col-md-8 mx-auto mb-3" method="post"
                  action="post-edit.php<?php if ($editBlgId != null) echo "?id=$editBlgId" ?>"
                  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="blogTitle">Blog Title</label>
                    <input name="blog_title" type="text" class="form-control" id="blogTitle"
                           placeholder="Blog Title"
                           autofocus required value="<?php echo $editBlg['title_text']; ?>">
                </div>
                <div class="form-group">
                    <label for="blogText">Blog Text</label>
                    <textarea name="blog_text" class="form-control" id="blogText" rows="10"
                              required><?php echo htmlspecialchars($editBlg['blog_text']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="blogCategory">Blog Category</label>
                    <select name="blog_cat" class="form-control" id="blogCategory" required>
                        <option <?php $selected = empty($editBlg['category_id']);
                        echo($selected ? 'selected' : ''); ?> disabled value="">Select Blog
                            Category
                        </option>
                        <?php
                        $result = DB::conn()->query("SELECT * FROM categories;");
                        while (($row = $result->fetch_assoc())) {
                            $cat_id = $row['id'];
                            $catgr = $row['category_name'];
                            if ($editBlg['category_id'] == $cat_id)
                                echo "<option selected class='nav-link text-uppercase' value='$cat_id'>$catgr</option>";
                            else
                                echo "<option class='nav-link text-uppercase' value='$cat_id'>$catgr</option>";
                        }
                        ?>
                    </select>
                </div>
                <p class="mb-0">Tags (select at least one)</p>
                <div class="form-check">
                    <?php
                    $result = DB::conn()->query("SELECT * FROM tags;");
                    $tagIDs = DB::getBlogTagIDs($editBlgId);
                    while (($row = $result->fetch_assoc())) {
                        $tag_id = $row['id'];
                        $tag = $row['tag_name'];
                        $checked = Utils::contains($tagIDs, $tag_id, count($tagIDs)) ? 'checked' : '';
                        echo "<div class='form-check form-check-inline my-1'>
                                <input name='check_list[]' class='form-check-input' type='checkbox' id='inlineCheckbox$tag_id' value='$tag_id' $checked>
                                <label class='form-check-label  mr-3' for='inlineCheckbox$tag_id'>$tag</label>
                            </div>";
                    }
                    ?>
                    <a target="_blank" class="btn btn-sm btn-outline-secondary py-0 d-inline-flex align-items-center"
                       href="tags.php">
                        <span class="material-icons">add</span>
                        Add More Tags
                    </a>
                </div>
                <div class="form-group mt-3">
                    <label for="title-img">Cover Image</label>
                    <input type="file" class="form-control-file" name="title_img" required>
                </div>
                <?php
                for ($img = 1; $img <= 3; $img++) {
                    echo "
                    <div class='form-group'>
                        <label for='other-img$img' class='d-inline'>Other Image$img</label>
                        <input type='file' class='form-control-file' name='other_img$img' id='other-img$img'>
                    </div>";
                }
                ?>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="../js/jquery-3.5.1.slim.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
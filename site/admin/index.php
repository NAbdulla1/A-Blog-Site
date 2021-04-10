<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;
use Blog\Utils;

if (session_id() == "") session_start();
$user = null;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else $user = DB::getUserById($_SESSION['user_id']);


$query = "SELECT b.id, b.title_text, b.created_at, u.name, c.category_name FROM blogs b join users u on u.id = b.author_id join categories c on c.id = b.category_id";
$conj = "WHERE";
if ($user->isAdmin && isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $query .= " $conj u.id = " . $_GET['user_id'];
    $conj = "AND";
}
if (!$user->isAdmin) {
    $query .= " $conj u.id = " . $_SESSION['user_id'];
    $conj = "AND";
}

if (isset($_GET['blog_cat']) && !empty($_GET['blog_cat'])) {
    $query .= " $conj c.id = " . $_GET['blog_cat'];
    $conj = "AND";
}
if (isset($_GET['start_date'], $_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $start = Utils::getMysqlDate($_GET['start_date']);
    $end = Utils::getMysqlDate($_GET['end_date'], true);
    $query .= " $conj b.created_at BETWEEN '$start' AND '$end'";
}
$query .= " ORDER BY created_at desc;";
$blogs = DB::conn()->query($query);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Blogs</title>
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

<?php if (isset($_SESSION['msgg'])) {
    if ($_SESSION['msgg'] == "no_permission")
        echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">You have no permission to edit this post<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_SESSION['msgg'] == "no_id")
        echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">No Post is selected to Delete<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_SESSION['msgg'] == "success")
        echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Post deleted successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_SESSION['msgg'] == "failed")
        echo '<div class="alert alert-danger mx-auto col-md-6 mt-1" role="alert">Post can\'t be deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    $_SESSION['msgg'] = '';
    unset($_SESSION['msgg']);
} ?>

<div class="container-fluid">
    <div class="row mt-5 position-relative">
        <div class="col-3 col-md-2 p-0 m-0 pt-1 h-100 ml-md-3 rounded"
             style="background-color: #444a50; position: sticky; top: 1px;">
            <?php /*include __DIR__.'/left-panel.php'*/ ?>
            <ul class="list-group p-0">
                <li class="px-2 list-group-item border-right-0  active">
                    <a href="index.php" class="text-light d-flex align-bottom">
                        <span class="material-icons mr-1">article</span>
                        <span class="d-none d-sm-inline">Blog Posts</span>
                    </a>
                </li>
                <li class="px-2 list-group-item border-right-0 ">
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
        <div class="col-9 col-md-9">
            <div class=" px-3 mx-auto shadow">
                <h3 class="h3 text-center"><?php if (!$user->isAdmin) echo "Your " ?> Blog Posts</h3>
                <div class="d-flex justify-content-end">
                    <form class="form-inline" method="get" action="index.php">
                        <input data-toggle="tooltip" data-placement="top" title="Start Date" name="start_date"
                               class="form-control form-control-sm mr-2" type="date"
                            <?php if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
                                echo 'value="' . $_GET['start_date'] . '"';
                            } ?>/>
                        <input data-toggle="tooltip" data-placement="top" title="End Date" name="end_date"
                               class="form-control form-control-sm mr-2" type="date"
                            <?php if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
                                echo 'value="' . $_GET['end_date'] . '"';
                            } ?>/>
                        <?php if ($user->isAdmin) { ?>
                            <select name="user_id" class="form-control form-control-sm mr-2" id="blogCategory">
                                <option <?php echo(!isset($_GET['user_id']) ? 'selected' : '') ?> value="">All User
                                </option>
                                <?php
                                $uresult = DB::conn()->query("SELECT id, name FROM users;");
                                while (($urow = $uresult->fetch_assoc())) {
                                    $user_id = $urow['id'];
                                    $username = $urow['name'];
                                    if (isset($_GET['user_id']) && $_GET['user_id'] == $user_id)
                                        echo "<option selected class='nav-link text-uppercase' value='$user_id'>$username</option>";
                                    else
                                        echo "<option class='nav-link text-uppercase' value='$user_id'>$username</option>";
                                }
                                ?>
                            </select>
                        <?php } ?>
                        <select name="blog_cat" class="form-control form-control-sm mr-2" id="blogCategory">
                            <option <?php echo(!isset($_GET['blog_cat']) ? 'selected' : '') ?> value="">
                                All Categories
                            </option>
                            <?php
                            $result = DB::conn()->query("SELECT * FROM categories;");
                            while (($row = $result->fetch_assoc())) {
                                $cat_id = $row['id'];
                                $catgr = $row['category_name'];
                                if (isset($_GET['blog_cat']) && $_GET['blog_cat'] == $cat_id)
                                    echo "<option selected class='nav-link text-uppercase' value='$cat_id'>$catgr</option>";
                                else
                                    echo "<option class='nav-link text-uppercase' value='$cat_id'>$catgr</option>";
                            }
                            ?>
                        </select>
                        <button class="btn btn-sm btn-outline-info"><i class="fa fa-filter"></i></button>
                    </form>
                    <a href="index.php" class="ml-2 btn btn-sm btn-outline-info"><i class="fa fa-filter"></i>x</a>
                </div>
                <div class="table-responsive my-2">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Title</th>
                            <?php if ($user->isAdmin) {
                                echo '<th scope="col" class="text-center">Author Name</th>';
                            } ?>
                            <th scope="col" class="text-center">Category</th>
                            <th scope="col" class="text-center"><span class="fa fa-comments" data-toggle="tooltip"
                                                                      data-placement="left"
                                                                      title="Comments"></span>
                            </th>
                            <th scope="col" class="text-center"><span class="fa fa-heart" data-toggle="tooltip"
                                                                      data-placement="left"
                                                                      title="Likes"></span>
                            </th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while (($blg = $blogs->fetch_assoc())) {
                            $blgId = $blg['id'];
                            ?>
                            <tr>
                                <td scope="row"><?php echo Utils::titleCase($blg['title_text']); ?></td>
                                <?php if ($user->isAdmin) {
                                    echo '<td scope="col" class="text-center">' . $blg['name'] . '</td>';
                                } ?>
                                <td scope="row" class="text-center"><?php echo $blg['category_name']; ?></td>
                                <td scope="row" class="text-center">
                                    <a class="text-dark" href="comments.php?blog_id=<?php echo $blgId; ?>">
                                        <?php echo count(DB::getComments($blgId)) ?>
                                    </a>
                                </td>
                                <td scope="row" class="text-center"><?php echo DB::getLikeCount($blgId) ?></td>
                                <td scope="row" class="text-center">
                                    <a href="post-edit.php?<?php echo 'id=' . $blg['id']; ?>"
                                       class="btn btn-sm btn-outline-success">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    <a href="post-delete.php?<?php echo 'id=' . $blg['id']; ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Are you sure to delete this blog? It will also delete the images and comments associated to it.')">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-3.5.1.slim.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
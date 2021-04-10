<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;

if (session_id() == "") session_start();
$user = null;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user = DB::getUserById($_SESSION['user_id']);
if (!$user->isAdmin) {
    header("Location: index.php");
    exit();
}

$msg = "not";
if (isset($_POST['category-name']) && !empty(\Blog\Utils::filterInput($_POST['category-name']))) {
    if (DB::addCategory(\Blog\Utils::filterInput($_POST['category-name']))) $msg = "added";
    else $msg = "failed";
} else if (isset($_POST['submit'])) $msg = "failed";
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
    <title>Category</title>
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
<?php
if ($msg == "failed")
    echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">Add Category Failed<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
else if ($msg == 'added')
    echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Category added successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
?>
<?php
if (isset($_GET['delete'])) {
    if ($_GET['delete'] == "0")
        echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">Category Delete Failed<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_GET['delete'] == "1")
        echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Category deleted successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
}
?>
<div class="container-fluid">
    <div class="row mt-5 position-relative">
        <div class="col-3 col-md-2 p-0 m-0 pt-1 h-100 ml-md-3 rounded"
             style="background-color: #444a50; position: sticky; top: 1px;">
            <?php /*include __DIR__.'/left-panel.php'*/ ?>
            <ul class="list-group p-0">
                <li class="px-2 list-group-item border-right-0 ">
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
                    <li class="px-2 list-group-item border-right-0 active">
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
        <div class="col-7 col-md-8 row mx-auto">
            <div class="col-md-6 mx-auto shadow">
                <h3 class="h3 text-center">Categories</h3>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Category</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $categories = DB::conn()->query("SELECT * FROM categories ORDER BY id;");
                    while (($category = $categories->fetch_assoc())) {
                        ?>
                        <tr>
                            <td scope="row" class="text-center"><?php echo $category['id']; ?></td>
                            <td scope="row" class="text-center"><?php echo $category['category_name']; ?></td>
                            <td scope="row" class="text-center">
                                <a href="category-edit.php?id=<?php echo $category['id'] ?>"
                                   class="btn btn-sm btn-outline-primary material-icons">edit</a>
                                &nbsp;
                                <a href="category-delete.php?id=<?php echo $category['id'] ?>"
                                   class="btn btn-sm btn-outline-danger material-icons"
                                   onclick="return confirm('Are you sure to delete?')">delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table></div>
            </div>
            <div class="offset-md-1"></div>
            <div class="col-md-5 mx-auto shadow">
                <h3 class="h3 text-center">Add Category</h3>
                <form action="categories.php" method="post" class="mt-md-5">
                    <div class="form-group">
                        <label for="cat-name" class="sr-only">Category Name</label>
                        <input name="category-name" type="text" class="form-control" id="cat-name"
                               placeholder="Category" required>
                    </div>
                    <button type="submit" class="w-100 btn btn-primary d-flex align-items-center justify-content-center"
                            name="submit">
                        <span class="material-icons">add</span>
                        Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-3.5.1.slim.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
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

$valid_extensions = ["jpg", "jpeg", "png"];
$pic_update = "not";
if (isset($_FILES["profile_pic"])) {
    $profilePic = $_FILES["profile_pic"];
    $extension = pathinfo($profilePic['name'], PATHINFO_EXTENSION);
    if (Utils::contains($valid_extensions, $extension, count($valid_extensions)) && $profilePic['error'] == '0' && $profilePic['size'] > 0) {
        $oldPicPath = DB::getUserById($_SESSION['user_id'])->profile_pic_path;
        $picSavePath = "../images/" . time() . rand(0, 10000) . "." . $extension;
        if (DB::update_prof_pic($picSavePath, $_SESSION['user_id'])) {
            move_uploaded_file($profilePic['tmp_name'], $picSavePath);
            if (pathinfo($oldPicPath, PATHINFO_FILENAME) != 'dummy_pic')
                unlink($oldPicPath);//delete old picture
            $pic_update = "updated";
        } else
            $pic_update = "failed";
    }
}

$name_update = "not";
if (isset($_POST['name'])) {
    $name = Utils::filterInput($_POST['name']);
    if (strlen($name) > 0) {
        if (DB::update_name($name, $_SESSION['user_id'])) {
            $name_update = "updated";
        } else
            $name_update = "failed";
    }
}

$user = DB::getUserById($_SESSION['user_id']);
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
    <title>Profile</title>
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
if ($name_update == "failed")
    echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">Name update failed<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
else if ($name_update == 'updated')
    echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Name updated successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';

if ($pic_update == "failed")
    echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">Profile Picture update failed<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
else if ($pic_update == 'updated')
    echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Profile Picture updated successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                <li class="px-2 list-group-item  border-right-0">
                    <a href="change-password.php" class="text-light d-flex align-bottom">
                        <span class="material-icons mr-1">password</span>
                        <span class="d-none d-sm-inline">Change Password</span>
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
        <div class="col-7 col-md-8 mb-3">
            <form class=" col-10 col-md-6 mx-auto" method="post" action="profile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Name</label>
                    <input name="name" type="text" class="form-control" id="username"
                           value="<?php echo $user->name; ?>">
                </div>
                <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input readonly type="email" class="form-control" id="inputEmail4"
                           value="<?php echo $user->email ?>">
                </div>
                <div class="form-group">
                    <label for="prof_pic">Profile Picture</label>
                    <input type="file" class="form-control-file" id="prof_pic" name="profile_pic">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
            </form>
        </div>
    </div>
</div>

<script src="../js/jquery-3.5.1.slim.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
</body>
</html>
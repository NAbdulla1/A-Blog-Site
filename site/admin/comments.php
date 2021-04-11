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
$userId = $user->id;
$query = "SELECT c.id, c.comment_text, b.title_text, u.name, u.id as user_id FROM
    (SELECT id, title_text FROM blogs WHERE author_id = $userId) b
    JOIN comments c ON c.blog_id = b.id LEFT JOIN users u on c.user_id = u.id";
if ($user->isAdmin)
    $query = "SELECT c.id, c.comment_text, b.title_text, u.name, u.id as user_id FROM
    blogs b JOIN comments c ON c.blog_id = b.id left JOIN users u on c.user_id = u.id";

if (isset($_GET["my_comments"])) {
    $query = "SELECT c.id, c.comment_text, b.title_text, u.name, u.id as user_id FROM
        (SELECT * FROM comments WHERE user_id = $userId) c
        JOIN blogs b ON c.blog_id = b.id JOIN users u on c.user_id = u.id";
}

$conj = "WHERE";
if (isset($_GET['blog_id']) && !empty($_GET['blog_id'])) {
    $query .= " $conj b.id = " . $_GET['blog_id'];
    $conj = "AND";
}
$query .= " ORDER BY c.id desc;";
$comments = DB::conn()->query($query);
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
    <title>
        Comments
    </title>
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
        echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">You have no permission to edit this comment<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_SESSION['msgg'] == "no_id")
        echo '<div class="alert alert-warning mx-auto col-md-6 mt-1" role="alert">No Comment is selected to Delete<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_SESSION['msgg'] == "success")
        echo '<div class="alert alert-success mx-auto col-md-6 mt-1" role="alert">Comment deleted successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    else if ($_SESSION['msgg'] == "failed")
        echo '<div class="alert alert-danger mx-auto col-md-6 mt-1" role="alert">Comment can\'t be deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                <li class="px-2 list-group-item border-right-0 active">
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
        <div class="col-9 col-md-9 mx-auto">
            <div class=" px-3 mx-auto shadow ">
                <?php if (isset($_GET["my_comments"])) { ?>
                    <h3 class="h3 text-center">My Comments</h3>
                <?php } else { ?>
                    <h3 class="h3 text-center">Comments On <?php if (!$user->isAdmin) echo "My "; ?> Blog Posts</h3>
                <?php } ?>
                <div class="d-flex justify-content-end">
                    <a href="comments.php?my_comments" class="btn btn-sm btn-info">My Comments</a>
                </div>
                <div class="table-responsive my-2">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">Comment Text</th>
                            <th scope="col" class="text-center">Blog Title</th>
                            <th scope="col" class="text-center">Commenter</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while (($comment = $comments->fetch_assoc())) {
                            $commentId = $comment['id'];
                            ?>
                            <tr>
                                <td scope="row"><?php echo $commentId ?></td>
                                <td scope="row"><?php echo $comment['comment_text']; ?></td>
                                <td scope="row"><?php echo $comment['title_text']; ?></td>
                                <td scope="row" class="text-center"><?php echo empty($comment['name'])?"Unknown":$comment['name']; ?></td>
                                <td scope="row" class="text-center">
                                    <a href="comment-delete.php?<?php echo 'id=' . $comment['id']; ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Are you sure to delete this comment?')">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                    <?php if ($comment['user_id'] == $user->id) { ?>
                                        <a href="comment-edit.php?<?php echo 'id=' . $comment['id']; ?>"
                                           class="btn btn-sm btn-outline-success">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    <?php
                                    } ?>
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
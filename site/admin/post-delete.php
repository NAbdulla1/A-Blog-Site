<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;
use Blog\Utils;

if (session_id() == "") session_start();
$user = null;
$msg = "not";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = DB::getUserById($_SESSION['user_id']);

$selectedBlog = null;
$selectedBlogID = null;
if (isset($_GET['id'])) {
    $selectedBlogID = $_GET['id'];
    $selectedBlog = DB::conn()->query("SELECT * FROM blogs where id = $selectedBlogID;");
    if ($selectedBlog) {
        $selectedBlog = $selectedBlog->fetch_assoc();
        if (!$user->isAdmin && $selectedBlog['author_id'] != $user->id) {
            $_SESSION['msgg'] = 'no_permission';
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['msgg'] = 'no_id';
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['msgg'] = 'no_id';
    header("Location: index.php");
    exit();
}

$authorID = Utils::filterInput($_SESSION['user_id']);

$conn = DB::conn();
$blogID = $selectedBlogID;
$imageSavePath = $conn->query("SELECT title_img_path FROM blogs WHERE id = $blogID;")->fetch_assoc()['title_img_path'];

//delete images
unlink($imageSavePath);
$res = $conn->query("SELECT * FROM blog_images WHERE blog_id = $blogID;");
while (($rr = $res->fetch_assoc()))
    if (unlink($rr['path'])) $conn->query("DELETE FROM blog_images WHERE blog_id = $blogID");

if ($conn->query("DELETE FROM blogs WHERE id = $selectedBlogID")) {
    $_SESSION['msgg'] = 'success';
    header("Location: index.php");
    exit();
} else {
    $_SESSION['msgg'] = 'failed';
    header("Location: index.php");
    exit();
}
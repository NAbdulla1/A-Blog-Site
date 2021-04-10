<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;

if (session_id() == "") session_start();
$user = null;
$msg = "not";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = DB::getUserById($_SESSION['user_id']);

$selectedComment = null;
$selectedCommentID = null;
if (isset($_GET['id'])) {
    $selectedCommentID = $_GET['id'];
    $selectedComment = DB::conn()->query("SELECT * FROM comments where id = $selectedCommentID;");
    if ($selectedComment) {
        $selectedComment = $selectedComment->fetch_assoc();
        if (!$user->isAdmin && $selectedComment['user_id'] != $user->id && DB::getBlogAuthorId($selectedComment['blog_id']) != $user->id) {
            $_SESSION['msgg'] = 'no_permission';
            header("Location: comments.php");
            exit();
        }
    } else {
        $_SESSION['msgg'] = 'no_id';
        header("Location: comments.php");
        exit();
    }
} else {
    $_SESSION['msgg'] = 'no_id';
    header("Location: comments.php");
    exit();
}

$conn = DB::conn();

if ($conn->query("DELETE FROM comments WHERE id = $selectedCommentID")) {
    $_SESSION['msgg'] = 'success';
    header("Location: comments.php");
    exit();
} else {
    $_SESSION['msgg'] = 'failed';
    header("Location: comments.php");
    exit();
}
<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Blog\DB;

if (session_id() == "") session_start();
$user = null;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user = DB::getUserById($_SESSION['user_id']);

$blogId = null;
$response = [];
if (isset($_GET['blog_id'])) {
    $blogId = $_GET['blog_id'];
    $like = DB::conn()->query("SELECT * FROM likes WHERE blog_id = $blogId AND user_id = $user->id;");
    $liked = false;
    if ($like->num_rows > 0) {
        DB::conn()->query("DELETE FROM likes WHERE blog_id = $blogId AND user_id = $user->id;");
        $liked = false;
    } else {
        DB::conn()->query("INSERT INTO likes VALUES ($blogId, $user->id);");
        $liked = true;
    }
    $response = [
        "likeCount" => DB::getLikeCount($blogId),
        "liked" => $liked
    ];
}
header("Content-Type: application/json");
echo json_encode($response);
//\Blog\MyLogger::dbg(json_encode($response));
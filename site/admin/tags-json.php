<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;

if (session_id() == "") session_start();
$user = null;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$blogSpecified = isset($_GET['blog_id']) && !empty($_GET['blog_id']);
$tagsOfBlog = [];
if ($blogSpecified) {
    $tagsOfBlog = DB::getBlogTagIDs($_GET['blog_id']);
}

$tags = null;
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = "SELECT * FROM tags WHERE tag_name LIKE ?";
    $q = $_GET['q'] . "%";
    $stmt = DB::conn()->prepare($query);
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $tags = $stmt->get_result();
}

$response = [];
$len = count($tagsOfBlog);
while ($tags && ($tag = $tags->fetch_assoc())) {
    if ($blogSpecified)
        $tag['selected'] = \Blog\Utils::contains($tagsOfBlog, $tag['id'], $len);
    $tag['text'] = $tag['tag_name'];
    unset($tag['tag_name']);
    array_push($response, $tag);
}

header("Content-Type: application/json");
$response = [
    "results" => $response
];
echo json_encode($response);
<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Blog\DB;

if (session_id() == "") session_start();
$user = null;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$tags = DB::conn()->query("SELECT * FROM tags ORDER BY tag_name DESC");
$response = [];
while($tag = $tags->fetch_assoc()){
    array_push($response, $tag);
}
header("Content-Type: application/json");
echo json_encode($response);
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

$etag = null;
$etagId = null;
if (isset($_GET['id'])) {
    $etagId = $_GET['id'];
    $etag = DB::conn()->query("DELETE FROM tags where id = $etagId;");
    if ($etag) {
        header("Location: tags.php?delete=1");
    } else header("Location: tags.php?delete=0");
} else header("Location: tags.php?delete=0");
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
    $etag = DB::getUserById($etagId);
    if ($etag && DB::setAdminStatus($etagId, !$etag->isAdmin)) {
        header("Location: users.php");
    } else header("Location: users.php");
} else header("Location: users.php");
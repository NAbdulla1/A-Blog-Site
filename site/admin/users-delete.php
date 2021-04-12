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

$duser = null;
$duserId = null;
if (isset($_GET['id'])) {
    $duserId = $_GET['id'];
    $delUser = DB::getUserById($duserId);
    if (pathinfo($delUser->profile_pic_path, PATHINFO_FILENAME) != 'dummy_pic')
        unlink($delUser->profile_pic_path);
    $duser = DB::conn()->query("DELETE FROM users where id = $duserId;");
    if ($duser) {
        header("Location: users.php?delete=1");
    } else header("Location: users.php?delete=0");
} else header("Location: users.php?delete=0");
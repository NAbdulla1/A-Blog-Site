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

$ecategory = null;
$ecategoryId = null;
if (isset($_GET['id'])) {
    $ecategoryId = $_GET['id'];
    $ecategory = DB::conn()->query("DELETE FROM categories where id = $ecategoryId;");
    if ($ecategory) {
        header("Location: categories.php?delete=1");
    } else{
        header("Location: categories.php?delete=0");
    }
} else
    header("Location: categories.php?delete=0");
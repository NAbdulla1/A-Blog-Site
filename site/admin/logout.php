<?php
if (session_id() == "") session_start();
unset($_SESSION["user_id"]);
unset($_SESSION);
session_destroy();
header("Location:login.php");
<?php

use Blog\DB;
use Blog\Utils;

if (session_id() == "") session_start();
if (isset($_SESSION['user_id'])) {
    if (isset($_GET['next'])) {
        $next = $_GET['next'];
        $header = "Location:$next";
        header($header);
    } else header("Location:index.php");
    exit();
}

$message = "";
if (isset($_POST['email'], $_POST['password'])) {
    $email = Utils::filterInput($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $password = $_POST['password'];
        if (DB::isEmailPasswordCorrect($email, $password)) {
            $user = DB::getUserByEmail($email);
            $_SESSION['user_id'] = $user->id;
            if (isset($_GET['next'])) {
                $next = $_GET['next'];
                header("Location:$next");
            } else header("Location:index.php");
        } else $message = "Invalid Email or Password";
    } else $message = "Malformed Email Address";
} else if (isset($_POST['submit'])) $message = "Incomplete Form";
?>

<html lang="en">

<head>
    <title>Blog Login</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
</head>

<body>
<div class="container-sm">
    <?php if (isset($_SESSION['msg'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            ?>
        </div>
        <?php
    } ?>
    <?php if (strlen($message) > 0) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message;
            $message = "";
            ?>
        </div>
        <?php
    } ?>
    <form class="form-signin" action="login.php<?php echo(isset($_GET['next']) ? "?next=" . $_GET['next'] : "") ?>"
          method="post">
        <p class="h4 mb-3 font-weight-bolder text-uppercase text-center"
           style="font-family: Inconsolata, serif; color: black;">Awesome Blog</p>
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required
               autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
        <!--<a class="btn btn-lg btn-outline-info btn-block" href="signup.php">Sign Up</a>-->
    </form>
</div>
</body>
</html>

<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Blog\DB;
use Blog\Utils;

if (session_id() == "") session_start();
$user = null;
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function logIn($next = "")
{
    if (!isLoggedIn()) {
        if (empty($next))
            header("Location: login.php");
        else header("Location: login.php?next=$next");
        exit();
    } else $GLOBALS['user'] = DB::getUserById($_SESSION['user_id']);
}

if (isLoggedIn()) $user = DB::getUserById($_SESSION['user_id']);


$query = "SELECT b.id, b.title_text, b.blog_text, b.title_img_path, b.created_at, b.author_id, u.name, c.category_name FROM blogs b join users u on u.id = b.author_id join categories c on c.id = b.category_id";

$conj = "WHERE";

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $query .= " $conj u.id = " . $_GET['user_id'];
    $conj = "AND";
}

if (isset($_GET['cat_id']) && !empty($_GET['cat_id'])) {
    $query .= " $conj c.id = " . $_GET['cat_id'];
    $conj = "AND";
}

$query .= " ORDER BY created_at desc;";
$blogs = DB::conn()->query($query);
$numBlogs = $blogs->num_rows;
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/coliff/bootstrap-rfs/bootstrap-rfs.css">-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <!--Details instruction https://google.github.io/material-design-icons/#icon-font-for-the-web -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Open+Sans&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="css/font-awesome.css">-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div style="background-color: black;">
    <!--top bar-->
    <div class="main-content-area">
        <div class="container">
            <div class="row justify-content-between py-2">
                <div class="col-sm-6 d-none d-sm-inline text-nowrap overflow-hidden">
                    <a class="mr-2" href="#"><i class="fa fa-facebook text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-twitter text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-pinterest-p text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-vk text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-google-plus text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-behance text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-dribbble text-white-50"></i></a>
                    <a class="mr-2" href="#"><i class="fa fa-instagram text-white-50"></i></a>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <?php if (isLoggedIn()) { ?>
                        <a class="mr-2  text-white-50 text-uppercase" href="logout.php">
                            <i class="fa fa-user-circle text-white-50 text-uppercase mr-1"></i>Log out
                            (<?php echo $user->name ?>)</a>
                    <?php } else { ?>
                        <a class="mr-2  text-white-50 text-uppercase" href="login.php?next=index.php">
                            <i class="fa fa-user-circle text-white-50 text-uppercase mr-1"></i>Log in</a>
                    <?php } ?>
                    <span class="mr-2 text-white-50 big-font">|</span>
                    <form class="form-inline mt-n1">
                        <label for="lang-s"><i class="fa fa-globe text-white-50"></i></label>
                        <select id="lang-s" class="custom-select-sm bg-transparent border-0 text-white-50">
                            <option value="eng" selected class="text-dark">ENG</option>
                            <option value="ben" class="text-dark">BEN</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="title-and-menu-area">
    <div class="position-relative" style="top: 0;">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php $rand3 = DB::get3RandomPost();
                for ($i = 0; $i < count($rand3); $i++) {
                    $post = $rand3[$i]; ?>
                    <div class="carousel-item <?php if ($i == 0) echo 'active' ?>">
                        <img alt="title background" src="<?php echo Utils::topLevelImage($post['title_img_path']); ?>"
                             class="title-area-img">
                        <div class="row position-absolute justify-content-center"
                             style="top: 0; width: 100%; bottom: 0;">
                            <div class="col-md-8 d-flex flex-column align-items-center position-absolute justify-content-end"
                                 style="bottom: 0; top: 0;">
                                <span class="text-white-50 text-uppercase text-center mt-3">
                                    <?php echo DB::getCategoryById($post['category_id']); ?>
                                </span>
                                <div class="row">
                                    <span class="main-title text-white text-uppercase text-center col-10 col-md-9 mx-auto">
                                        <?php echo $post['title_text'] ?>
                                    </span>
                                </div>
                                <a href="single-post.php?id=<?php echo $post['id'] ?>"
                                   class="btn btn-primary text-uppercase text-white px-md-4 py-md-2 rounded-pill px-sm-2 py-sm-1 small-font">Read
                                    More</a>
                                <img src="<?php echo DB::getUserProfilePicPath($post['author_id']); ?>"
                                     alt="author avatar"
                                     style="margin-top: 3vw; width: 50px; height: auto"/>
                                <span class="text-white small-font font-weight-bold">
                                    <?php echo DB::getUserById($post['author_id'])->name ?>
                                </span>
                                <div class="extra-small-font"><span class="text-white-50 mr-3">
                                        <?php echo date("F j, Y", Utils::getTime($post['created_at'])); ?>
                                        </span>
                                    <span
                                            class="text-white text-white-50"><?php echo date("H:i", Utils::getTime($post['created_at'])); ?></span>
                                </div>
                                <div style="margin-top: 2vw; margin-bottom: 2vw;">
                                    <a href="single-post.php?id=<?php echo $post['id']; ?>#comment-section"
                                       class="text-white-50 mr-3 extra-small-font"> <span
                                                class="material-icons extra-small-font">forum</span> Comments
                                        (<?php echo count(DB::getComments($post['id'])); ?>)</a>
                                    <a class="text-white-50 extra-small-font"> <span
                                                class="material-icons extra-small-font">favorite_border</span>
                                        Likes (<?php echo DB::getLikeCount($post['id']) ?>)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div><!--title area-->

        <div class="main-content-area position-absolute" style="top: 0; left: 0; right: 0;">

            <nav class="navbar navbar-expand-xl bg-transparent navbar-dark text-uppercase" style="z-index: 1000000;">
                <div class="navbar-brand mr-auto">
                    <a href="#" class="nav-link text-uppercase brand-font text-white font-weight-bolder">My Blog</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navContent">
                    <div class="w-100 navbar-nav d-flex justify-content-sm-end align-items-end">
                        <a href="index.php" class="nav-link text-white text-right
                            <?php if (!isset($_GET['cat_id'])) echo 'active'; ?>">
                            Home
                        </a>

                        <?php $categories = DB::conn()->query("SELECT * FROM categories;");
                        $limit = 0;
                        while ($limit < 5 && $cat = $categories->fetch_assoc()) { ?>
                            <a href="index.php?cat_id=<?php echo $cat['id'] ?>"
                               class="ml-1 nav-link text-white text-right
                           <?php if (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat['id']) echo 'active'; ?>"
                               type="button">
                                <?php echo $cat['category_name']; ?>
                            </a>
                            <?php
                            $limit++;
                        }
                        if (isLoggedIn()) { ?>
                            <a href="admin/index.php" class="ml-1 nav-link text-white text-right material-icons"
                               data-toggle="tooltip" data-placement="bottom" title="Admin Area">
                                admin_panel_settings
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </nav>
        </div><!--Main Menu-->
    </div>
</div><!--Main Menu and Title-->
<?php
if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
    if ($_SESSION['msg'] == 'no_id') {
        ?>
        <div class="alert alert-danger alert-dismissible fade show text-center col-md-6 mx-auto m-4" role="alert">
            No Blog Post Found To be Displayed.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        unset($_SESSION['msg']);
        $_SESSION['msg'] = '';
    }
}
?>
<div class="mt-3 position-relative">
    <div class="bg-white d-none d-md-block position-absolute" style="width: 11%; right: 0; top: 0; bottom: 0;"></div>
    <!--right white area-->
    <div class="main-content-area row">
        <div class="col-md-8"><!--left column-->
            <div class="articles mr-md-1 ml-md-n3">
                <?php $cblg = $blogs->fetch_assoc();
                if ($cblg != null) {
                    ?>
                    <div class="card mb-4 bg-white">
                        <div class="position-relative"><!--image and the content overlaying on the image-->
                            <img src="<?php echo Utils::topLevelImage($cblg['title_img_path']) ?>" alt="alt"
                                 class="card-img-top card-img">
                            <!--<a href="#"><span class="text-white place-center material-icons"
                                              style="font-size: 48px">play_circle_outline</span></a>-->
                            <div class="row position-absolute align-items-baseline on-image-text">
                            <span class="text-uppercase mr-auto text-white col-md-6">
                                <?php echo $cblg['category_name']; ?>
                            </span>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a href="single-post.php?id=<?php echo $cblg['id']; ?>#comment-section">
                                        <span class="material-icons extra-small-font text-white ">forum</span>
                                        <span class="mr-4 text-white extra-small-font">&nbsp
                                    <?php echo count(DB::getComments($cblg['id']));
                                    $cbid = $cblg['id']; ?></span>
                                    </a>
                                    <a>
                                    <span id="like_icon_overlay_<?php echo $cbid ?>"
                                          class="material-icons extra-small-font text-white">
                                        <?php
                                        echo (isLoggedIn() && DB::conn()->query("SELECT * FROM likes WHERE user_id=$user->id AND blog_id=$cbid")->num_rows > 0)
                                            ? 'favorite' : 'favorite_border';
                                        ?>
                                    </span>
                                        <span class="text-white extra-small-font"
                                              id="like_count_<?php echo $cbid; ?>">&nbsp; <?php echo(DB::getLikeCount($cblg['id'])); ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom mb-2">
                            <a href='single-post.php<?php echo "?id=$cbid" ?>'><span
                                        class="text-dark big-font font-weight-bold one-line-text"><?php echo($cblg['title_text']); ?></span></a>
                            <span class="open-sans-font two-line-text"><?php echo $cblg['blog_text'] ?></span>
                        </div>
                        <?php $author = DB::getUserById($cblg['author_id']) ?>
                        <div class="media px-3 pb-2">
                            <img src="<?php echo Utils::topLevelImage($author->profile_pic_path) ?>"
                                 class="mr-3 rounded-circle" alt="alt"
                                 style="max-width: 60px">
                            <div class="media-body">
                                <span class="mt-0 small-font"><?php echo Utils::titleCase($author->name) ?></span>
                                <br>
                                <span class="extra-small-font text-muted">
                                <?php echo date("F j, Y", Utils::getTime($cblg['created_at'])); ?>&nbsp;&nbsp;<?php echo date("H:i", Utils::getTime($cblg['created_at'])); ?>
                            </span>
                            </div>
                            <div class="dropdown my-auto">
                                <a class="dropdown-toggle nav-link text-dark text-right mx-0 px-0" type="button"
                                   id="article1-option"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="article1-option">
                                    <?php if (isLoggedIn()) { ?>
                                        <a id="like_icon_dropdown_<?php echo $cbid; ?>"
                                           class="dropdown-item material-icons"
                                           href="#">
                                            <?php
                                            echo (isLoggedIn() && DB::conn()->query("SELECT * FROM likes WHERE user_id=$user->id AND blog_id=$cbid")->num_rows > 0)
                                                ? 'favorite' : 'favorite_border';
                                            ?>
                                        </a>
                                        <a class="dropdown-item material-icons" href="#">comment</a>
                                        <a class="dropdown-item material-icons" href="#">share</a>
                                    <?php } else { ?>
                                        <a class="dropdown-item" href="login.php?next=index.php">Please Login</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else {
                    ?>
                    <div class="h1 mb-4 bg-white text-warning text-center" style="height: 400px; padding: 100px;">
                        "No Posts"
                    </div>
                <?php } ?>
                <?php
                $page = 1;
                if (isset($_GET['page']) && !empty($_GET['page']))
                    $page = max(1, (int)$_GET['page']);
                if ($cblg != null)
                    $cblg = $blogs->fetch_assoc();
                for ($pp = 1; $pp <= $page && $cblg; $pp++) {
                    ?>
                    <!--horizontal two-->
                    <?php
                    if ($page != 1 && $pp == $page) {
                        echo "<a id='more_posts'></a>";
                    }
                    for ($hor = 0; $hor < 2 && $cblg != null; $hor++, $cblg = $blogs->fetch_assoc()) {
                        $author = DB::getUserById($cblg['author_id']); ?>
                        <div class="card mb-4 bg-white d-flex flex-md-row rounded flex-wrap">
                            <div class="card-img-top col-12 col-md-6 col-lg-5 no-gutters p-0">
                                <!--image and the content overlaying on the image-->
                                <div class="position-relative ml-0">
                                    <img src="<?php echo Utils::topLevelImage($cblg['title_img_path']) ?>" alt="alt"
                                         class="img-fluid card-img-top"
                                         style="object-fit: cover">
                                    <!--<a href="#"> <span class="text-white place-center material-icons"
                                                       style="font-size: 48px">play_circle_outline</span></a>-->
                                    <div class="row position-absolute align-items-baseline on-image-text">
                                        <span class="text-uppercase mr-auto text-white">
                                            <?php echo $cblg['category_name'] ?>
                                        </span>
                                        <div class="d-flex justify-content-end">
                                            <a href="single-post.php?id=<?php echo $cblg['id']; ?>#comment-section">
                                                <span class="material-icons extra-small-font text-white ">forum</span>
                                                <span class="mr-4 text-white extra-small-font">
                                                    <?php echo count(DB::getComments($cblg['id']));
                                                    $cbid = $cblg['id']; ?>
                                                </span>
                                            </a>
                                            <a>
                                                <span id="like_icon_overlay_<?php echo $cbid ?>"
                                                      class="material-icons extra-small-font text-white">
                                                    <?php
                                                    echo (isLoggedIn() && DB::conn()->query("SELECT * FROM likes WHERE user_id=$user->id AND blog_id=$cbid")->num_rows > 0)
                                                        ? 'favorite' : 'favorite_border';
                                                    ?>
                                                </span>
                                                <span class="text-white extra-small-font"
                                                      id="like_count_<?php echo $cbid; ?>">&nbsp; <?php echo(DB::getLikeCount($cblg['id'])); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-7">
                                <div class="border-bottom py-2">
                                    <a href='single-post.php<?php echo "?id=$cbid" ?>'><span
                                                class="text-dark big-font font-weight-bold one-line-text"><?php echo($cblg['title_text']); ?></span>
                                    </a>
                                    <span class="two-line-text open-sans-font small-font"><?php echo $cblg['blog_text'] ?></span>
                                </div>
                                <div class="media mt-2">
                                    <img src="<?php echo Utils::topLevelImage($author->profile_pic_path) ?>"
                                         class="mr-3 rounded-circle" alt="alt"
                                         style="max-width: 40px">
                                    <div class="media-body">
                                        <span class="mt-0 small-font mb-0"><?php echo ucwords($author->name) ?></span>
                                        <br>
                                        <span class="extra-small-font text-muted">
                                            <?php echo date("F j, Y", Utils::getTime($cblg['created_at'])); ?>&nbsp;&nbsp;<?php echo date("H:i", Utils::getTime($cblg['created_at'])); ?>
                                        </span>
                                    </div>
                                    <div class="dropdown my-auto">
                                        <a class="dropdown-toggle nav-link text-dark text-right mx-0 px-0" type="button"
                                           id="article1-option"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="article1-option">
                                            <?php if (isLoggedIn()) { ?>
                                                <a id="like_icon_dropdown_<?php echo $cbid; ?>"
                                                   class="dropdown-item material-icons"
                                                   href="#">
                                                    <?php
                                                    echo (isLoggedIn() && DB::conn()->query("SELECT * FROM likes WHERE user_id=$user->id AND blog_id=$cbid")->num_rows > 0)
                                                        ? 'favorite' : 'favorite_border';
                                                    ?>
                                                </a>
                                                <a class="dropdown-item material-icons" href="#">comment</a>
                                                <a class="dropdown-item material-icons" href="#">share</a>
                                            <?php } else { ?>
                                                <a class="dropdown-item" href="login.php?next=index.php">Please
                                                    Login</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } ?>

                    <?php
                    if ($cblg != null) {
                        ?>
                        <!--vertical two-->
                        <div class="row">
                            <?php for ($ver = 0; $ver < 2 && $cblg != null; $ver++, $cblg = $blogs->fetch_assoc()) {
                                $author = DB::getUserById($cblg['author_id']);
                                $cbid = $cblg['id']; ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card mb-2 bg-white">
                                        <div class="position-relative">
                                            <!--image and the content overlaying on the image-->
                                            <img src="<?php echo Utils::topLevelImage($cblg['title_img_path']) ?>"
                                                 alt="alt"
                                                 class="card-img-top card-img fixed-height-img-2">
                                            <div class="row position-absolute align-items-baseline on-image-text">
                                                <span class="text-uppercase mr-auto text-white col-md-6">
                                                    <?php echo $cblg['category_name'] ?>
                                                </span>
                                                <div class="col-md-6 d-flex justify-content-end align-items-end">
                                                    <a href="single-post.php?id=<?php echo $cblg['id']; ?>#comment-section"
                                                       class="px-0 text-nowrap">
                                                        <span class="material-icons extra-small-font text-white ">forum</span>
                                                        <span class="mr-4 text-white extra-small-font">&nbsp; <?php echo count(DB::getComments($cbid)) ?></span>
                                                    </a>
                                                    <a class="px-0 text-nowrap">
                                                        <span id="like_icon_overlay_<?php echo $cbid ?>"
                                                              class="material-icons extra-small-font text-white">
                                                    <?php
                                                    echo (isLoggedIn() && DB::conn()->query("SELECT * FROM likes WHERE user_id=$user->id AND blog_id=$cbid")->num_rows > 0)
                                                        ? 'favorite' : 'favorite_border';
                                                    ?>
                                                </span>
                                                        <span class="text-white extra-small-font"
                                                              id="like_count_<?php echo $cbid; ?>">&nbsp; <?php echo(DB::getLikeCount($cblg['id'])); ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-bottom mb-2">
                                            <a href='single-post.php<?php echo "?id=$cbid" ?>'> <span
                                                        class="text-dark big-font font-weight-bold one-line-text"><?php echo $cblg['title_text'] ?></span></a>
                                            <span class="four-line-text"><?php echo $cblg['blog_text']; ?></span>
                                        </div>
                                        <div class="media px-3 pb-2">
                                            <img src="<?php echo Utils::topLevelImage($author->profile_pic_path) ?>"
                                                 class="mr-3 rounded-circle" alt="alt"
                                                 style="max-width: 60px">
                                            <div class="media-body">
                                                <span class="mt-0 small-font"><?php echo Utils::titleCase($author->name) ?></span>
                                                <br>
                                                <span class="extra-small-font text-muted">
                                <?php echo date("F j, Y", Utils::getTime($cblg['created_at'])); ?>&nbsp;&nbsp;<?php echo date("H:i", Utils::getTime($cblg['created_at'])); ?>
                            </span>
                                            </div>
                                            <div class="dropdown my-auto">
                                                <a class="dropdown-toggle nav-link text-dark text-right mx-0 px-0"
                                                   type="button"
                                                   id="article1-option"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="article1-option">
                                                    <?php if (isLoggedIn()) { ?>
                                                        <a id="like_icon_dropdown_<?php echo $cbid; ?>"
                                                           class="dropdown-item material-icons"
                                                           href="#">
                                                            <?php
                                                            echo (isLoggedIn() && DB::conn()->query("SELECT * FROM likes WHERE user_id=$user->id AND blog_id=$cbid")->num_rows > 0)
                                                                ? 'favorite' : 'favorite_border';
                                                            ?>
                                                        </a>
                                                        <a class="dropdown-item material-icons" href="#">comment</a>
                                                        <a class="dropdown-item material-icons" href="#">share</a>
                                                    <?php } else { ?>
                                                        <a class="dropdown-item" href="login.php?next=index.php">Please
                                                            Login</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } ?>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php
                $prevQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
                if ($prevQuery == null) $prevQuery = "";
                $pos = strpos($prevQuery, "page=");
                if ($pos === 0 || !empty($pos)) {
                    $newQuer = substr($prevQuery, 0, $pos);
                    $pos += 5;
                    while ($pos < strlen($prevQuery) && (is_numeric($prevQuery[$pos]) || $prevQuery[$pos] == '&')) {
                        $pos++;
                    }
                    if ($pos < strlen($prevQuery))
                        $newQuer .= substr($prevQuery, $pos);
                    $prevQuery = $newQuer;
                }

                if (strlen($prevQuery) != 0 && $prevQuery[strlen($prevQuery) - 1] != '&') {
                    $prevQuery .= "&";
                }
                $page++;
                $prevQuery .= "page=$page";
                ?>
                <div class="my-4 text-right">
                    <?php if ($cblg != null) { ?>
                        <a href="index.php?<?php echo $prevQuery . "#more_posts" ?>"
                           class="text-primary text-decoration-none row justify-content-end align-items-center mr-3">
                            <span class="mr-2">More</span>
                            <span class="material-icons text-primary rounded-circle bg-white shadow p-1">arrow_forward</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div><!--articles area-->

        <div class="right-side-bar col-md-4 bg-white rounded">
            <div>
                <form class="form-inline m-3 position-relative">
                    <label class="sr-only" for="search-box-top-right"></label>
                    <input id="search-box-top-right" type="text" class="form-control rounded-pill w-100"
                           style="background-color: #f5f5f5" placeholder="Search">
                    <button class=" border-0 bg-transparent">
                    <span class="place-right rounded-circle material-icons text-light p-1"
                          style="background-color: deeppink;">search</span>
                    </button>
                </form><!--search box-->
                <ul class="list-group px-3 border-0 mb-3">
                    <li class="list-group-item border-top-0 border-left-0 border-right-0 pl-0 pb-1"
                        style="border-bottom: 1px blue solid; color: rgb(63, 81, 181);">
                        <span class="big-font font-weight-bold">Categories</span>
                    </li>
                    <?php $categories = DB::conn()->query("SELECT c.id, c.category_name, count(*) count FROM categories c join blogs b on c.id = b.category_id GROUP BY c.category_name ORDER BY count desc ");
                    $catUsed = [];
                    while ($cat = $categories->fetch_assoc()) {
                        array_push($catUsed, $cat['id']); ?>
                        <li class="py-2 list-group-item border-left-0 border-right-0 border-bottom">
                            <div class="row justify-content-between open-sans-font small-font">
                                <div><a href="index.php?cat_id=<?php echo $cat['id'] ?>"
                                        class="text-dark"><?php echo $cat['category_name'] ?></a></div>
                                <div class="font-weight-bold"><?php echo $cat['count'] ?></div>
                            </div>
                        </li>
                        <?php
                    }
                    $categories = DB::conn()->query("SELECT * FROM categories");
                    $llen = count($catUsed);
                    while ($cat = $categories->fetch_assoc()) {
                        if (Utils::contains($catUsed, $cat['id'], $llen)) continue;
                        else {
                            ?>
                            <li class="py-2 list-group-item border-left-0 border-right-0 border-bottom">
                                <div class="row justify-content-between open-sans-font small-font">
                                    <div><a href="index.php?cat_id=<?php echo $cat['id'] ?>"
                                            class="text-dark"><?php echo $cat['category_name'] ?></a></div>
                                    <div class="font-weight-bold">0</div>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul><!--categories-->
                <ul class="list-group px-3 border-0 mb-3">
                    <li class="pb-1 list-group-item border-top-0 border-left-0 border-right-0 font-weight-bolder pl-0"
                        style="border-bottom: 1px blue solid; color: rgb(63, 81, 181);">
                        <span class="big-font">Subscribe</span>
                    </li>
                    <li class="py-2 list-group-item border-left-0 border-right-0 border-bottom-0 px-0">
                        <form>
                            <div class="form-group open-sans-font">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" placeholder="Tan Doe">
                            </div>
                            <div class="form-group open-sans-font">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" placeholder="Email Address">
                            </div>
                            <button class="btn btn-primary w-100 text-uppercase font-weight-bold big-font"
                                    style="background-color: rgb(63, 81, 181);">Subscribe
                            </button>
                        </form>
                    </li>
                    <li class="px-0 pb-0 list-group-item border-0 open-sans-font">
                        <p style="border-bottom: 1px solid black; line-height: .1em; text-align: center"><span
                                    style="background-color: white;" class="px-1">or</span></p>
                    </li>
                    <li class="px-3 pt-0 pb-1 list-group-item border-0">
                        <div class="row justify-content-around">
                            <a href="#" class="mr-1 col p-0">
                                <img src="images/facebook.png" class="w-100 rounded-circle" alt="logo">
                            </a>
                            <a href="#" class="mr-1 col p-0">
                                <img src="images/twitter.png" class="w-100 rounded-circle" alt="logo">
                            </a>
                            <a href="#" class="mr-1 col p-0">
                                <img src="images/pinterest.png" class="w-100 rounded-circle" alt="logo">
                            </a>
                            <a href="#" class="mr-1 col p-0">
                                <img src="images/tumbl.png" class="w-100 rounded-circle" alt="logo">
                            </a>
                            <a href="#" class="mr-1 col p-0">
                                <img src="images/dribble.svg" class="w-100 rounded-circle" alt="logo">
                            </a>
                            <a href="#" class="col p-0">
                                <img src="images/vk..png" class="w-100 rounded-circle" alt="logo">
                            </a>
                        </div>
                    </li>
                </ul><!--news letter and social-->
                <ul class="list-group px-3 border-0 mb-3">
                    <li class="pb-1 list-group-item border-top-0 border-left-0 border-right-0 font-weight-bolder pl-0"
                        style="border-bottom: 1px blue solid; color: rgb(63, 81, 181);">
                        <span class="big-font font-weight-bold">TAB POST WIDGET</span>
                    </li>
                    <li class="py-2 list-group-item border-0 px-0">
                        <div class="btn-group w-100" role="group" aria-label="button group">
                            <button id="recent-post-tab" type="button" class="btn btn-primary text-uppercase px-0 w-50"
                                    style="background-color: rgb(63, 81, 181);">
                                Recent Post
                            </button>
                            <button id="popular-post-tab" type="button"
                                    class="btn btn-outline-secondary bg-white text-uppercase px-0 w-50"
                                    style="color: rgb(63, 81, 181);">
                                Popular Post
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item border-0">
                        <ul class="list-group" id="recent-posts">
                            <?php
                            $quer = "SELECT b.id, b.title_text, b.title_img_path, b.created_at, c.category_name FROM blogs b join users u on u.id = b.author_id join categories c on c.id = b.category_id ORDER BY created_at desc LIMIT 3";
                            $recent = DB::conn()->query($quer);
                            while ($res = $recent->fetch_assoc()) {
                                ?>
                                <li class="pb-1 pt-2 list-group-item border-top-0 border-left-0 border-right-0 px-0">
                                    <div class="mb-2 bg-white d-flex ">
                                        <div class="position-relative ml-0 col-4 p-0">
                                            <img src="<?php echo Utils::topLevelImage($res['title_img_path']) ?>"
                                                 alt="alt" class="card-img-top card-img ml-0">
                                        </div>
                                        <div class="col-8 flex-column">
                                            <div class="px-3 row"><span
                                                        class="mr-auto text-muted extra-small-font"><?php echo date("F j, Y", Utils::getTime($res['created_at'])); ?></span>
                                                <a href="single-post.php?id=<?php echo $res['id']; ?>#comment-section"
                                                   class="material-icons extra-small-font">forum</a>
                                                <span class="extra-small-font"> &nbsp <?php echo count(DB::getComments($res['id'])) ?></span>
                                            </div>
                                            <div class="p-0 font-weight-bold small-font two-line-text"><a
                                                        href="single-post.php?id=<?php echo $res['id'] ?>"
                                                        class="text-dark">
                                                    <?php echo $res['title_text']; ?>
                                                </a></div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <ul class="list-group d-none" id="popular-posts">
                            <?php
                            $quer = "SELECT blog_id as id, title_text, title_img_path, created_at, count(*) comment_count FROM blogs b join comments c on b.id = c.blog_id GROUP BY b.id ORDER BY comment_count desc LIMIT 3;";
                            $recent = DB::conn()->query($quer);
                            while ($res = $recent->fetch_assoc()) {
                                ?>
                                <li class="pb-1 pt-2 list-group-item border-top-0 border-left-0 border-right-0 px-0">
                                    <div class="mb-2 bg-white d-flex ">
                                        <div class="position-relative ml-0 col-4 p-0">
                                            <img src="<?php echo Utils::topLevelImage($res['title_img_path']) ?>"
                                                 alt="alt" class="card-img-top card-img ml-0">
                                        </div>
                                        <div class="col-8 flex-column">
                                            <div class="px-3 row"><span
                                                        class="mr-auto text-muted extra-small-font"><?php echo date("F j, Y", Utils::getTime($res['created_at'])); ?></span>
                                                <a href="single-post.php?id=<?php echo $res['id']; ?>#comment-section"
                                                   class="material-icons extra-small-font">forum</a>
                                                <span class="extra-small-font"> &nbsp <?php echo count(DB::getComments($res['id'])) ?></span>
                                            </div>
                                            <div class="p-0 font-weight-bold small-font two-line-text"><a
                                                        href="single-post.php?id=<?php echo $res['id'] ?>"
                                                        class="text-dark">
                                                    <?php echo $res['title_text']; ?>
                                                </a></div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul><!--tab post-->
                <ul class="list-group px-3 border-0 mb-3">
                    <li class="pb-1 list-group-item border-top-0 border-left-0 border-right-0 font-weight-bolder pl-0"
                        style="border-bottom: 1px blue solid; color: rgb(63, 81, 181);">
                        <span class="big-font font-weight-bold">TAGS</span>
                    </li>
                    <li class="py-2 list-group-item border-0">
                        <div class="row flex-wrap open-sans-font small-font">
                            <?php
                            $tags = DB::conn()->query("SELECT * FROM tags;");
                            while ($tag = $tags->fetch_assoc()) {
                                ?>
                                <a class="btn-sm text-dark mr-2 my-1 font-weight-bold" style="background-color: #f5f5f5"
                                   href="#"><?php echo $tag['tag_name'] ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </li>
                </ul><!--tags-->
            </div>
        </div><!--right-sidebar-->
    </div><!--content area-->
</div><!--content area wrapper-->

<footer style="background-image: url('images/bottom_bg.png'); width: 100%;">
    <div class="container-fluid px-0 no-gutters">
        <div class="row w-100 px-0 no-gutters">
            <img src="images/insta1.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta2.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta3.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta4.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta5.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta6.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta7.jpg" style="width: 12.5%" alt="alt">
            <img src="images/insta8.jpg" style="width: 12.5%" alt="alt">
        </div>
    </div>
    <div class="py-5" style="background-color: rgba(0, 0, 0, .9)">
        <form class="form-inline main-content-area row justify-content-center align-items-baseline"
              style="left: 0; right: 0;">
            <label for="email2" class="mr-3 text-light" style="font-size: 1.5rem; font-weight: 900;">Subscribe to our
                newsletter</label>
            <input id="email2" type="email" class="form-control rounded-pill mr-3" placeholder="Email Address">
            <button class="btn btn-primary rounded-pill text-uppercase px-4">Subscribe</button>
        </form>
    </div><!--newsletter-->

    <div class="bg-dark">
        <div class="main-content-area py-4 row">
            <div class="col-lg-6 row">
                <div class="col-sm-6 mb-2">
                    <p class="text-white text-uppercase font-weight-bold big-font">Pages Widget</p>
                    <ul class="list-group small-font open-sans-font">
                        <li class="py-1 list-group-item mb-1 bg-transparent border-secondary rounded border-top px-0 pt-0">
                            <ul class="list-group">
                                <li class="py-1 list-group-item bg-transparent border-right-0 border-left-0 border-top-0 border-bottom-0 border-secondary expandable-page-item">
                                    <div class="row justify-content-between">
                                        <span class="pl-2 text-light text-uppercase">HOME</span>
                                        <a href="#"
                                           class="text-light material-icons text-decoration-none stretched-link">add</a>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 bg-transparent border-right-0 border-left-0 border-bottom-0 d-none">
                                    <ul class="list-group">
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Photography</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Web Design</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Pholpsophy</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Graphic Design</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="py-1 list-group-item mb-1 bg-transparent border-secondary rounded border-top px-0 pt-0">
                            <ul class="list-group">
                                <li class="py-1 list-group-item bg-transparent border-right-0 border-left-0 border-top-0 border-bottom-0 border-secondary expandable-page-item">
                                    <div class="row justify-content-between">
                                        <span class="pl-2 text-light text-uppercase">Pages</span>
                                        <a href="#"
                                           class="text-light material-icons text-decoration-none stretched-link">add</a>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 bg-transparent border-right-0 border-left-0 border-bottom-0 d-none">
                                    <ul class="list-group">
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Service</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">FAQ</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">About</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="py-1 list-group-item mb-1 bg-transparent border-secondary rounded border-top px-0 pt-0">
                            <ul class="list-group">
                                <li class="py-1 list-group-item bg-transparent border-right-0 border-left-0 border-top-0 border-bottom-0 border-secondary expandable-page-item">
                                    <div class="row justify-content-between">
                                        <span class="pl-2 text-light text-uppercase">Portfolio</span>
                                        <a href="#"
                                           class="text-light material-icons text-decoration-none stretched-link">add</a>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 bg-transparent border-right-0 border-left-0 border-bottom-0 d-none">
                                    <ul class="list-group">
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">MySite</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Github</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Gitlab</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="py-1 list-group-item mb-1 bg-transparent border-secondary rounded border-top px-0 pt-0">
                            <ul class="list-group">
                                <li class="py-1 list-group-item bg-transparent border-right-0 border-left-0 border-top-0 border-bottom-0 border-secondary expandable-page-item">
                                    <div class="row justify-content-between">
                                        <span class="pl-2 text-light text-uppercase">BLOG</span>
                                        <a href="#"
                                           class="text-light material-icons text-decoration-none stretched-link">add</a>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 bg-transparent border-right-0 border-left-0 border-bottom-0 d-none">
                                    <ul class="list-group">
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Lifestyle</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Inspiration</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Trip</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Food</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="py-1 list-group-item mb-1 bg-transparent border-secondary rounded border-top px-0 pt-0">
                            <ul class="list-group">
                                <li class="py-1 list-group-item bg-transparent border-right-0 border-left-0 border-top-0 border-bottom-0 border-secondary expandable-page-item">
                                    <div class="row justify-content-between">
                                        <span class="pl-2 text-light text-uppercase">SHOP</span>
                                        <a href="#"
                                           class="text-light material-icons text-decoration-none stretched-link">add</a>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 bg-transparent border-right-0 border-left-0 border-bottom-0 d-none">
                                    <ul class="list-group">
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Service</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">Locations</a>
                                        </li>
                                        <li class="py-1 list-group-item bg-transparent border-0 text-secondary">
                                            <a href="#" class="text-decoration-none text-secondary">About</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!--page widget-->
                <div class="col-sm-6">
                    <p class="text-white text-uppercase font-weight-bold big-font">Twitter Widget</p>
                    <div class="border-bottom border-secondary mb-2 py-2 open-sans-font" style="font-size: .75rem">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid" src="images/twitter.png" alt="twitter logo">
                            </div>
                            <div class="col-9 text-light pl-0">
                                @PASCO, Duis commodo elit sed nisi molesite
                            </div>
                        </div>
                        <div class="text-light">
                            2 hours ago <i class="fa fa-long-arrow-right"></i> <a href="#"
                                                                                  class="text-light"><u>Reply</u> </a><a
                                    href="#" class="text-light"><u>Retweet</u> </a><a href="#" class="text-light"><u>Favorite</u>
                            </a>
                        </div>
                    </div>
                    <div class="border-bottom border-secondary mb-2 py-2 open-sans-font" style="font-size: .75rem">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid" src="images/twitter.png" alt="twitter logo">
                            </div>
                            <div class="col-9 text-light pl-0">
                                @PASCO, Duis commodo elit sed nisi molesite
                            </div>
                        </div>
                        <div class="text-light">
                            2 hours ago <i class="fa fa-long-arrow-right"></i> <a href="#"
                                                                                  class="text-light"><u>Reply</u> </a><a
                                    href="#" class="text-light"><u>Retweet</u> </a><a href="#" class="text-light"><u>Favorite</u>
                            </a>
                        </div>
                    </div>
                    <div class="mb-2 py-2 open-sans-font" style="font-size: .75rem">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid" src="images/twitter.png" alt="twitter logo">
                            </div>
                            <div class="col-9 text-light pl-0">
                                @PASCO, Duis commodo elit sed nisi molesite
                            </div>
                        </div>
                        <div class="text-light">
                            2 hours ago <i class="fa fa-long-arrow-right"></i> <a href="#"
                                                                                  class="text-light"><u>Reply</u> </a><a
                                    href="#" class="text-light"><u>Retweet</u> </a><a href="#" class="text-light"><u>Favorite</u>
                            </a>
                        </div>
                    </div>

                    <p class="mt-4 text-white text-uppercase font-weight-bold big-font">Social Widget</p>
                    <div class="row justify-content-around px-2">
                        <a href="#" class="mr-1 col p-1">
                            <img src="images/facebook.png" class="w-100 rounded-circle" alt="logo">
                        </a>
                        <a href="#" class="mr-1 col p-1">
                            <img src="images/twitter.png" class="w-100 rounded-circle" alt="logo">
                        </a>
                        <a href="#" class="mr-1 col p-1">
                            <img src="images/pinterest.png" class="w-100 rounded-circle" alt="logo">
                        </a>
                        <a href="#" class="mr-1 col p-1">
                            <img src="images/tumbl.png" class="w-100 rounded-circle" alt="logo">
                        </a>
                        <a href="#" class="mr-1 col p-1">
                            <img src="images/dribble.svg" class="w-100 rounded-circle" alt="logo">
                        </a>
                        <a href="#" class="col p-1">
                            <img src="images/vk..png" class="w-100 rounded-circle" alt="logo">
                        </a>
                    </div>
                </div><!--twitter widget and social widget-->
            </div>
            <div class="col-lg-6 row">
                <div class="col-sm-6 mt-3 mt-md-0">
                    <p class="text-white text-uppercase font-weight-bold big-font">Flikr Widget</p>
                    <div class="row justify-content-around no-gutters">
                        <div class="col"><img src="images/fli1.jpg" class="img-fluid p-1" alt="alt"></div>
                        <div class="col"><img src="images/fli2.jpg" class="img-fluid p-1" alt="alt"></div>
                        <div class="col"><img src="images/fli3.jpg" class="img-fluid p-1" alt="alt"></div>
                    </div>
                    <div class="row justify-content-around no-gutters">
                        <div class="col"><img src="images/fli4.jpg" class="img-fluid p-1" alt="alt"></div>
                        <div class="col"><img src="images/fli5.jpg" class="img-fluid p-1" alt="alt"></div>
                        <div class="col"><img src="images/fli6.jpg" class="img-fluid p-1" alt="alt"></div>
                    </div>
                    <div class="row justify-content-around no-gutters">
                        <div class="col"><img src="images/fli7.jpg" class="img-fluid p-1" alt="alt"></div>
                        <div class="col"><img src="images/fli8.jpg" class="img-fluid p-1" alt="alt"></div>
                        <div class="col"><img src="images/fli9.jpg" class="img-fluid p-1" alt="alt"></div>
                    </div>
                </div><!--flikr widget-->
                <div class="col-sm-6 mt-3 mt-md-0">
                    <p class="text-white text-uppercase font-weight-bold big-font">News Letter</p>
                    <form>
                        <label for="name3" class="sr-only">Name</label>
                        <input id="name3" type="text" class="mb-2 form-control bg-transparent border-secondary"
                               placeholder="Name">
                        <label for="email3" class="sr-only">Email</label>
                        <input id="email3" type="text" class="mb-2 form-control bg-transparent border-secondary"
                               placeholder="Email Address">
                        <label for="msg3" class="sr-only">Message</label>
                        <textarea id="msg3" type="text" class="mb-2 form-control bg-transparent border-secondary"
                                  placeholder="Message"></textarea>
                        <button type="button" class="btn btn-primary text-uppercase w-100 border-0 font-weight-bold"
                                style="background-color: #303030">Subscribe
                        </button>
                    </form>
                </div><!--news letter-->
            </div>
        </div>
    </div><!--widgets-->

    <div style="background-color: #303030" class="py-3">
        <div class="main-content-area row align-items-baseline" style="font-size: .8rem">
            <div class="col-md row mr-auto">
                <a class="text-uppercase text-light mr-3" href="#">Home</a>
                <a class="text-uppercase text-light mr-3" href="#">Portfolio</a>
                <a class="text-uppercase text-light mr-3" href="#">Blog</a>
                <a class="text-uppercase text-light mr-3" href="#">Pages</a>
                <a class="text-uppercase text-light mr-3" href="#">Shop</a>
                <a class="text-uppercase text-light mr-3" href="#">Components</a>
                <a class="text-uppercase text-light mr-auto" href="#">Features</a>
            </div>
            <form class="form-inline mr-3 position-relative bg-transparent">
                <input type="text" class="form-control rounded-pill w-100 border-secondary bg-transparent"
                       style="background-color: #f5f5f5"
                       placeholder="Search">
                <button class="rounded-pill border-0 place-right bg-transparent material-icons text-secondary">
                    search
                </button>
            </form>
            <form class="form-inline mt-n1">
                <label for="lang-s2"><i class="fa fa-globe text-white-50"></i></label>
                <select id="lang-s2" class="custom-select-sm bg-transparent border-0 text-white-50">
                    <option value="eng" selected class="text-dark">ENG</option>
                    <option value="ben" class="text-dark">BEN</option>
                </select>
            </form>
        </div>
    </div>
</footer>

<script src="js/jquery-3.5.1.slim.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        //like count
        <?php
        $blogsa = DB::conn()->query($query);
        while ($blg = $blogsa->fetch_assoc()) {
        $dropdownLike = "#like_icon_dropdown_" . $blg['id'];
        $overlayLike = "#like_icon_overlay_" . $blg['id'];
        $countLike = "#like_count_" . $blg['id'];
        ?>
        $('<?php echo $dropdownLike?>').click(function (event) {
            event.preventDefault();
            $url = "<?php echo Utils::getBaseUrl();?>/toggle_like.php?blog_id=<?php echo $blg['id']?>";
            jQuery.get($url, function (response, status) {
                if (status === 'success') {
                    $('<?php echo $overlayLike?>')[0].textContent = response.liked ? 'favorite' : 'favorite_border';
                    $('<?php echo $dropdownLike?>')[0].textContent = response.liked ? 'favorite' : 'favorite_border';
                    $('<?php echo $countLike?>')[0].textContent = response.likeCount;
                }
            });
        });
        <?php
        }
        ?>

        //post tab functionality
        let recentTab = $('#recent-post-tab');
        let popularTab = $('#popular-post-tab');
        let rps = $('#recent-posts');
        let pps = $('#popular-posts');

        recentTab.click(function () {
            if (rps.hasClass('d-none')) {
                pps.addClass('d-none');
                rps.removeClass('d-none');

                recentTab.removeClass('btn-outline-secondary bg-white text-primary');
                recentTab.addClass('btn-primary text-white');

                popularTab.removeClass('btn-primary');
                popularTab.addClass('btn-outline-secondary bg-white text-primary');
            }

        });
        popularTab.click(function () {
            if (pps.hasClass('d-none')) {
                rps.addClass('d-none');
                pps.removeClass('d-none');

                popularTab.removeClass('btn-outline-secondary bg-white text-primary');
                popularTab.addClass('btn-primary text-white');

                recentTab.removeClass('btn-primary');
                recentTab.addClass('btn-outline-secondary bg-white text-primary');
            }
        });

        //page widget area
        let expandables = $('.expandable-page-item a');
        let expandableCount = expandables.length;
        expandables.click(function (event) {
            expandables = $('.expandable-page-item a');
            if (event.target.innerHTML === 'add') {
                for (let i = 0; i < expandableCount; i++) {
                    if (expandables[i].innerHTML === 'remove') {
                        expandables[i].innerHTML = 'add';
                        expandables[i].parentElement.parentElement.classList.add('border-bottom-0');
                        let sibling = $('.expandable-page-item + li');
                        let slen = sibling.length;
                        for (let j = 0; j < slen; j++) {
                            sibling.addClass('d-none');
                        }
                    }
                }
                event.target.innerHTML = 'remove';
                event.target.parentElement.parentElement.classList.remove('border-bottom-0');
                event.target.parentElement.parentElement.nextElementSibling.classList.remove('d-none');
            } else {
                event.target.innerHTML = 'add';
                event.target.parentElement.parentElement.classList.add('border-bottom-0');
                event.target.parentElement.parentElement.nextElementSibling.classList.add('d-none');
            }
            event.preventDefault();
        });
    });
</script>
</body>

</html>
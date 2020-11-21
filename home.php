<?php
require_once __DIR__ . '/app/inc/server.php';
require_once __DIR__ . '/app/classes/Data.php';
if (!isset($_SESSION['user'])) {
    header('location: /');
    exit;
}
$posts = new Data('posts');
$loadPosts = $posts->read();
if (isset($_GET['find_text']) && !empty($_GET['find_text'])) {
    $matchesString = [];
    foreach ($loadPosts as $index => $item) {
        if (preg_match("(" . $_GET['find_text'] . ")", $item['comment']) || preg_match("(" . $_GET['find_text'] . ")", $item['username'])) {
            $matchesString[] = $item;
        }
    }
    $loadPosts = $matchesString;
}
if (isset($_GET['find_date']) && !empty($_GET['find_date'])) {
    $matchesDate = [];
    foreach ($loadPosts as $index => $item) {
        if (preg_match("/\b" . $_GET['find_date'] . "\b/i", $item['date'])) {
            $matchesDate[] = $item;
        }
    }
    $loadPosts = $matchesDate;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/assets/partials/assets-css.php'; ?>
    <title>POSTS - Application</title>
</head>

<body>
    <div class="wrapper fadeInDown">
        <div class="container">
            <div class="row ">
                <div class="col-12 text-center">
                    <h2>Message posting view</h2>
                </div>
            </div>
            <div class="row">
                <nav class="navbar navbar-light bg-light">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" value="<?php echo (isset($_GET['find_text']) ? $_GET['find_text'] : '') ?>" name="find_text" type="search" placeholder="Search" aria-label="Search">
                        <input class="form-control mr-sm-1" value="<?php echo (isset($_GET['find_date']) ? $_GET['find_date'] : '') ?>" name="find_date" type="search" placeholder="YYYY-MM-DD" pattern="\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])*" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </nav>
            </div>
            <?php if ($loadPosts) { ?>
                <div class="row">
                    <div class="list-group w-100">
                        <?php foreach ($loadPosts as $post) { ?>
                            <div class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <small><?php echo $post['date']; ?></small>
                                </div>
                                <p class="mb-1"><?php echo $post['comment']; ?></p>
                                <small>by <?php echo $post['username']; ?></small>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="formContent">
                <form action="app/new_comment.php" autocomplete="off" method="POST">
                    <label for="new_comment"></label>
                    <textarea placeholder="New comment..." class="form-control" name="new_comment" id="new_comment"></textarea>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <div id="formFooter">
                <!-- <a class="underlineHover" href="#">Forgot Password?</a> -->
                <a class="underlineHover" href="exit.php">Exit</a>
            </div>

        </div>
    </div>
</body>
<?php include __DIR__ . '/assets/partials/assets-js.php'; ?>
</html>
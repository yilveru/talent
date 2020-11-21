<?php
require_once __DIR__ . '/app/inc/server.php';
if(isset($_SESSION['user'])){
    header('location:/home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/assets/partials/assets-css.php'; ?>
    <title>Application</title>
</head>

<body>
    <div class="wrapper fadeInDown">
        <div class="container">
            <div class="row ">
                <div class="col-12 text-center">
                    <h2>Login</h2>
                </div>
            </div>
            <div class="formContent">
                <form action="app/login.php" autocomplete="off" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php
                    //check if user have errors
                    if (isset($_SESSION['validatorError']) && $_SESSION['validatorError']) { ?>
                        <div class="invalid-feedback" style="display: block;">
                            <?php
                            //print all errors to user
                            foreach ($_SESSION['validatorError'] as $index => $errors) {
                                echo ucfirst($index) . '<br>';
                                foreach ($errors as $error) {
                                    echo '- ' . $error . '<br>';
                                }
                            } ?>
                        </div>
                    <?php } ?>
                </form>
            </div>

            <div id="formFooter">
                <!-- <a class="underlineHover" href="#">Forgot Password?</a> -->
                <a class="underlineHover" href="create_account.php">Create account</a>
            </div>

        </div>
    </div>
</body>
<?php include __DIR__ . '/assets/partials/assets-js.php'; ?>

</html>
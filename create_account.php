<?php
require_once __DIR__ . '/app/inc/server.php';
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
                <div class="col-12 text-center"><h2>Create account</h2></div>
            </div>
            <div class="formContent">
                <form action="app/create_account.php" autocomplete="off" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp">
                        <small id="usernameHelp" class="form-text text-muted">Username must contain at least 2 numbers and 4 letters.</small>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" class="form-control" id="phone" aria-describedby="phoneHelp">
                        <small id="phoneHelp" class="form-text text-muted">The phone must contain only numbers.</small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">The mail must contain only numbers and letters.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp">
                        <small id="passwordHelp" class="form-text text-muted">Password must contain at least one capital letter and one hyphen.</small>
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
        </div>
    </div>
</body>
<?php include __DIR__ . '/assets/partials/assets-js.php'; ?>
<?php
//check if user have errors
if (isset($_SESSION['validatorError']) && $_SESSION['validatorError']) { ?>
    <script>
        <?php
        //set value to all fields
        foreach ($_SESSION['validatorData'] as $index => $data) { ?>
            document.getElementById("<?php echo $index; ?>").value = "<?php echo $data; ?>";
        <?php
        } ?>
    </script>


<?php }
?>

</html>
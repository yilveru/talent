<?php
require_once __DIR__ . '/inc/server.php';
require_once __DIR__ . '/classes/Validator.php';
require_once __DIR__ . '/classes/Data.php';
require_once __DIR__ . '/classes/Utils.php';
$utils = new Utils();
foreach ($_POST as $data) {
    $utils->cleanInput($data);
}
$data = ['username', 'phone', 'email', 'password'];
$rules = [
    'username' => ['required'],
    'password' => ['required'],
];
$validator = new Validator();
$validator->validate($_POST, $rules);
if ($validator->error()) {
    //return data with error messages
    $_SESSION['validatorError'] = $validator->error();
    /**
     * do not return password data, is senssible, but to the test is valid 
     * unset($_POST['password']);
     */
    header('location: /');
    exit;
} else {
    $data = new Data('users');
    $contents = $data->read();
    if ($contents) {
        foreach ($contents as $content) {
            foreach ($content as $index => $data) {
                if ($index == 'username') {
                    if ($_POST['username'] == $data) {
                        $_SESSION['user'] = $content;
                        unset($_SESSION['validatorError']);
                        unset($_SESSION['validatorData']);
                        header('location: /home.php');
                        exit;
                    }
                }
            }
        }
    }
    $_SESSION['validatorError'] = ['user' => [' does not exists']];
    header('location: /');
    exit;
}

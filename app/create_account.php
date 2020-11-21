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
    'username' => ['required', 'minLen' => 6, 'username'],
    'phone' => ['required', 'minLen' => 10, 'numeric'],
    'email' => ['required', 'minLen' => 8, 'email'],
    'password' => ['required', 'minLen' => 6, 'password'],
];
$_SESSION['validatorData'] = $_POST;
$validator = new Validator();
$validator->validate($_POST, $rules);
if ($validator->error()) {
    //return data with error messages
    $_SESSION['validatorError'] = $validator->error();
    /**
     * do not return password data, is senssible, but to the test is valid 
     * unset($_POST['password']);
     */
    header('location: /create_account.php');
    exit;
} else {
    $dataToSave = [
        'username' => $_POST['username'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    $data = new Data('users');
    //load info from file json
    $contents = $data->read();
    if ($contents) {
        foreach ($contents as $content) {
            foreach ($content as $index => $value) {
                if ($index == 'username') {
                    //compare if users alredy exists into data
                    if ($dataToSave['username'] == $value) {
                        $_SESSION['validatorError'] = ['username' => ['User alredy exists']];
                        header('location: /create_account.php');
                        exit;
                    }
                }
            }
        }
        //merge data file with new data
        array_unshift($contents, $dataToSave);
    } else {
        //save the firsts data
        $contents = [$dataToSave];
    }
    $data->save($contents);
    // clean all data validations
    unset($_SESSION['validatorError']);
    unset($_SESSION['validatorData']);
    header('location: /');
    exit;
}

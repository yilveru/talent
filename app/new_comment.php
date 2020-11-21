<?php
require_once __DIR__ . '/inc/server.php';
require_once __DIR__ . '/classes/Validator.php';
require_once __DIR__ . '/classes/Data.php';
require_once __DIR__ . '/classes/Utils.php';
if (!isset($_SESSION['user'])) {
    header('location:/');
    exit;
}
$utils = new Utils();
foreach ($_POST as $data) {
    $utils->cleanInput($data);
}

$data = ['new_comment'];
$rules = [
    'new_comment' => ['required'],
];
$validator = new Validator();
$validator->validate($_POST, $rules);
if ($validator->error()) {
    //return data with error messages
    $_SESSION['validatorError'] = $validator->error();
    header('location: /home.php');
    exit;
} else {
    $dataToSave = [
        'username' => $_SESSION['user']['username'],
        'date' => date('Y-m-d H:i:s'),
        'comment' => $_POST['new_comment'],
    ];
    $data = new Data('posts');
    $contents = $data->read();
    if ($contents) {
        //merge data file with new data
        array_unshift($contents, $dataToSave);
    } else {
        $contents = [$dataToSave];
    }
    $data->save($contents);
    header('location: /home.php');
    exit;
}

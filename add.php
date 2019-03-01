<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$title = ['name' => 'Добавить лот'];
$form_data = $_POST;
$data_files = $_FILES;
$errors = [];

foreach ($form_data as $key => $value) {
    if (empty($value)) {
        array_push($errors, $key);
    }
}

if(empty($form_data)) {
    $form_data = [
        'lot-name' => '',
        'category' => '',
        'message' => '',
        'lot-rate' => '',
        'lot-step' => '',
        'lot-date' => ''
    ];
}

if(empty($_FILES) or $_FILES['image-lot']['error'] === 0) {
    foreach($_FILES as $key) {
        if($key['type'] !== 'image/jpeg' or $key['type'] !== 'image/jpg' or $key['type'] !== 'image/png') {
            array_push($errors, 'image-lot');
        }
    }
}

if (empty($errors)) {
    $content = include_template('_add_lot.php', ['categories' => render_categories($con), 'form_data' => $form_data]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filename = uniqid(). '.jpg';
        $_FILES['image-lot'];

        move_uploaded_file($_FILES['image-lot']['tmp_name'], 'img/' . $filename);
        $form_data += ['image_url' => 'img/' . $filename];
        $form_data +=['user_id' => $_SESSION['user']['id']];

        header('location: /lot.php?lot_id=' . add_lot($con, $form_data));
        die();
    };


} else {

    $content = include_template('_add_lot.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
}

if(empty($_SESSION['user'])) {

    $text_error = http_response_code(403);
    $text_error = http_response_code();

    $content = include_template('404.php', ['categories' => render_categories($con), 'text_error' => 'Ошибка сервера: ' . $text_error . '! Только авторизованные пользователи могут просматривать эту страницу =)']);
}

$layout_add_lot = include_template('layout_lot.php', ['content' => $content, 'categories' => render_categories($con), 'lot' => $title]);

print($layout_add_lot);

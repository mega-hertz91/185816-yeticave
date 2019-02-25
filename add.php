<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$title = ['name' => 'Добавить лот'];
$form_data = $_POST;
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

if (empty($errors)) {
    $content = include_template('_add_lot.php', ['categories' => render_categories($con), 'form_data' => $form_data]);

    if ($_SERVER['REQUEST_METHOD'] = 'POST') {
        $filename = uniqid(). '.jpg';
        if($_FILES['image-lot']) {
            move_uploaded_file($_FILES['image-lot']['tmp_name'], 'img/' . $filename);

            $form_data += ['image_url' => 'img/' . $filename];
        }

        add_lot($con, $form_data);
    };
} else {
    $content = include_template('_add_lot.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
}

$layout_add_lot = include_template('layout_lot.php', ['content' => $content, 'categories' => render_categories($con), 'lot' => $title]);

print($layout_add_lot);
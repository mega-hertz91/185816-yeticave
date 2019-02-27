<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$form_data = $_POST;
$errors = [];

foreach ($form_data as $key => $value) {
    if (empty($value)) {
        array_push($errors, $key);
    }
}

if(empty($form_data)) {
    $form_data = [
        'email' => '',
        'password' => '',
        'name' => '',
        'message' => ''
    ];

};

if(empty($errors)) {
    $page_content = include_template('_sing-up.php', ['lots' => have_lots_by_category($con), 'categories' => render_categories($con), 'form_data' => $form_data]);
} else {
    $page_content = include_template('_sing-up.php', ['lots' => have_lots_by_category($con), 'categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
}


$layout_content = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => ['name' => 'Регистрация']]);

print ($layout_content);

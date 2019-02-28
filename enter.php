<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$form_data = $_POST;
$errors = [];

foreach ($form_data as $key => $value) {
  if(empty($value)) {
      array_push($errors, $key);
  }
};

if(empty($_POST)) {
    $form_data = [
        'email' => '',
        'password' => '',
    ];
}

if(empty($errors)) {
    $page_content = include_template('_enter.php', ['categories' => render_categories($con), 'form_data' => $form_data]);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty(check_email($con, $form_data['email']))) {
            array_push($errors, 'email');
            $text_error = 'Неверный email';

            $page_content = include_template('_enter.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors, 'text_error' => $text_error]);
            print ('error');
        } else {
            print ('success');
        }
    }

} else {
    $page_content = include_template('_enter.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
}


$layout_content = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => ['name' => 'Вход на сайт']]);

print ($layout_content);
print_r($errors);

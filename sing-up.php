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

if(empty($_FILES) or $_FILES['avatar']['error'] === 0) {
    foreach($_FILES as $key) {
        if($key['type'] !== 'image/jpeg' or $key['type'] !== 'image/jpg' or $key['type'] !== 'image/png') {
            array_push($errors, 'avatar');
        }
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
    $page_content = include_template('_sing-up.php', ['categories' => render_categories($con), 'form_data' => $form_data]);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(empty(check_email($con, $form_data['email']))) {

            if($_FILES['avatar']['error'] > 0) {
                $form_data += ['image_url' => 'img/default-avatar.jpeg'];
            } else {
                $filename = uniqid(). '.jpeg';
                $user_img = $_FILES['avatar'];
                move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/' . $filename);
                $form_data += ['image_url' => 'img/' . $filename];

            }

            if (add_user($con, $form_data) === true) {
                header('Location: /enter.php');
                exit();

            } else {
                $page_content = include_template('404.php', ['text_error' => 'Произошла ошибка при регистрации, попробуйте еще раз']);
            }
        } else {
           // print('error');
            array_push($errors, 'email', 'Пользователь с таким email уже зарегистрирован');
            $page_content = include_template('_sing-up.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
        }
    }

} else {
    $page_content = include_template('_sing-up.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
}


$layout_content = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => ['name' => 'Регистрация']]);

print ($layout_content);
print_r($errors);
<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$form_data = $_POST;
$errors = [];

if(empty($form_data)) {
    $form_data = [
        'email' => '',
        'password' => '',
        'name' => '',
        'message' => ''
    ];
};

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputs = [
        'email' => '',
        'password' => '',
        'name' => '',
        'message' => ''
    ];

    foreach ($inputs as $key => $value) {
        $check = array_key_exists($key, $_POST);

        if ($check == false) {
            array_push($errors, $key);
            $form_data += [$key => ''];
        }
    }

    if(empty($errors)) {

        foreach ($form_data as $key => $value) {
            if (empty($value)) {
                array_push($errors, $key);
            }
        }

        if(isset($_FILES['avatar']['error'])) {
            if($_FILES['avatar']['error'] === 0) {
                if ($_FILES['avatar']['type'] !== 'image/jpeg' && $_FILES['avatar']['type'] !== 'image/jpg' && $_FILES['avatar']['type'] !== 'image/png' ) {
                    array_push($errors, 'image-lot');
                }
            }
        };

        if(isset($_POST['email'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
                $errors = ['email'];
            }
        }


        if (empty($errors)) {
            if (empty(check_email($con, $form_data['email']))) {

                if ($_FILES['avatar']['error'] > 0) {
                    $form_data += ['image_url' => 'img/default-avatar.jpeg'];
                } else {
                    $filename = uniqid() . '.jpeg';
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
                array_push($errors, 'email', 'Пользователь с таким email уже зарегистрирован');
                $page_content = include_template('_sing-up.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
            }
        }
    }

     else {

        $page_content = include_template('_sing-up.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
    }
} else {

    $page_content = include_template('_sing-up.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);
}


$layout_content = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => ['name' => 'Регистрация']]);

print ($layout_content);

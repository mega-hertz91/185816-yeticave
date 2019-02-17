<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

/* Основное управление сайтом*/
if($main_config['enable']) {
    $page_content = include_template('main.php', ['lots' => $lots, 'category' => $categories]);
} else {
    $page_content = include_template('off.php', ['text_error' => 'Сайт находится на техническом обслуживании!']);
}

/*Подключение к БД */
$con = mysqli_connect($sql_config['db_host'], $sql_config['db_user'], $sql_config['db_password'], $sql_config['db_name']);

mysqli_set_charset($con, 'utf8');

if($con === false) {
    $page_content = include_template('off.php', ['text_error' => 'Ошибка подключения к базе данных ' . mysqli_connect_error()]);
}



$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => $main_config['sitename'], 'category' => $categories, 'is_auth' => $is_auth, 'user_name' => $user_name]);

print($layout_content);



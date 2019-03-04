<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');


/*Подключение к БД */

mysqli_set_charset($con, 'utf8');

if($con === false) {
    $page_content = include_template('off.php', ['text_error' => 'Ошибка подключения к базе данных ' . mysqli_connect_error()]);
} elseif ($main_config['enable'] == false) {
    $page_content = include_template('off.php', ['text_error' => 'Сайт находится на техническом обслуживании!']);
} else {

    if(render_lots($con) === null or render_categories($con) === null) {
        $page_content = include_template('off.php', ['text_error' => 'Произошла ошибка чтения данных']);
    } else {
        $page_content = include_template('main.php', ['lots' => render_lots($con), 'categories' => render_categories($con)]);
    }
}

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => $main_config['sitename'], 'categories' => render_categories($con), 'is_auth' => $is_auth, 'user_name' => $user_name]);

print($layout_content);
print_r(render_lots($con));

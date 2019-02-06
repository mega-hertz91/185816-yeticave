<?php
require_once ('inc/config.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

if($main_config['enable']) {
    $page_content = include_template('main.php', ['lots' => $lots, 'category' => $categories]);
} else {
    $page_content = include_template('off.php', ['text_error' => 'Сайт находится на техническом обслуживании!']);
}

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => $main_config['sitename'], 'category' => $categories, 'is_auth' => $is_auth, 'user_name' => $user_name]);

print($layout_content);



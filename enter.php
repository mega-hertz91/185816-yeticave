<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$form_data = [];
$errors = [];

$page_content = include_template('_enter.php', ['categories' => render_categories($con), 'form_data' => $form_data, 'errors' => $errors]);

$layout_content = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => ['name' => 'Вход на сайт']]);

print ($layout_content);

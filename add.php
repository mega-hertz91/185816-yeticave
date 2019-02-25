<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$title = ['name' => 'Добавить лот'];
$form_data = $_POST;

$content = include_template('_add_lot.php', ['categories' => render_categories($con), 'form_data' => $form_data]);

$layout_add_lot = include_template('layout_lot.php', ['content' => $content, 'categories' => render_categories($con), 'lot' => $title]);

print($layout_add_lot);

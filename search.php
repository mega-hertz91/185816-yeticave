<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$form_data = $_GET['search'];

$content = include_template('_search.php', ['lots' => get_search($con, $form_data), 'request_name' => $form_data]);

$layout_search = include_template('layout_lot.php', ['content' => $content, 'categories' => render_categories($con), 'lot' => ['name' => 'Поиск']]);

print($layout_search);

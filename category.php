<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

$id = $_GET['category_id'];

$page_content = include_template('_lots_by_category.php', ['lots' => have_lots_by_category($con), 'categories' => render_categories($con), 'id' => $id]);

$layout_content_category = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => have_lot($con)]);

print($layout_content_category);

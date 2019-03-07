<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$id = $_GET['category_id'];

if (check_id($con, 'categories', $id) === false) {
    $page_content = include_template('404.php', ['text_error' => 'Такой категории не существует в базе данных']);
    $layout_content_category = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con)]);
} else {
    $page_content = include_template('_lots_by_category.php', ['lots' => have_lots_by_category($con), 'categories' => render_categories($con), 'id' => $id]);
    $layout_content_category = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lots' => have_lot($con), 'lot' => ['name' => render_categories($con)[$id - 1]['name']]]);
}

print($layout_content_category);

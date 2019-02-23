<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

$id = $_GET['lot_id'];

if ($id > count_record($con, 'lots') or $id == 'none') {
    $content_lot = include_template('404.php', [ 'text_error' => 'Извините, такого лота не найдено или не существует!']);
    $layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con)]);
} else {
    $content_lot = include_template('_lot.php', [ 'lot' => have_lot($con), 'bet' => have_bet($con)]);
    $layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con), 'lot' => have_lot($con)]);
}

print($layout_content_lot);

print($title);
<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

$layout_content_category = include_template('layout_lot.php', ['content' => '','categories' => render_categories($con), 'lot' => have_lot($con)]);

print($layout_content_category);

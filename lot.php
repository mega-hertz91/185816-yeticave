<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

$content_lot = include_template('_lot.php', []);

$layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con)]);

print($layout_content_lot);
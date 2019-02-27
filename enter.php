<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$layout_content = include_template('layout_lot.php', ['content' => '','categories' => render_categories($con), 'lot' => ['name' => 'Вход на сайт']]);

print ($layout_content);

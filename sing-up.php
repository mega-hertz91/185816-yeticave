<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');

$page_content = include_template('_singup.php', ['lots' => have_lots_by_category($con), 'categories' => render_categories($con)]);
$layout_content = include_template('layout_lot.php', ['content' => $page_content,'categories' => render_categories($con), 'lot' => ['name' => 'Регистрация']]);

print ($layout_content);

<?php
require_once ('inc/config.php');
require_once ('inc/sql.php');
require_once ('inc/function.php');
require_once ('inc/data.php');

$id = $_GET['lot_id'];
$errors = [];
$user_bet = $_POST;

foreach ($user_bet as $key => $value) {
    if(empty($value)) {
        array_push($errors, $key);
    }
};

if(empty($_POST)) {
    $user_bet = [
        'cost' => '',
    ];
}

if (check_id($con, 'lots', $id) === false or $id == 'error') {
    $content_lot = include_template('404.php', [ 'text_error' => 'Извините, такого лота не найдено или не существует!']);
    $layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con), 'lot' => ['name' => '404']]);

} elseif($errors) {

    $content_lot = include_template('_lot.php', [ 'lot' => have_lot($con), 'bet' => have_bet($con), 'bets' => render_bets($con), 'user_bet' => $user_bet, 'errors' => $errors]);

} else {

    $content_lot = include_template('_lot.php', [ 'lot' => have_lot($con), 'bet' => have_bet($con), 'bets' => render_bets($con), 'user_bet' => $user_bet]);
}

$layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con), 'lot' => have_lot($con)]);

print($layout_content_lot);
print_r($errors);

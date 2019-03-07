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

if(isset($_SESSION['user'])) {
    $master_lot_id = check_user_by_lot($con, $_SESSION['user']['id'], have_lot($con)['user_id']);
    $count_bets_by_user = count(check_count_bets($con, $_SESSION['user']['id'], have_lot($con)['id']));
}

if (isset($user_bet['cost'])) {
    if (is_int(intval($user_bet['cost']))) {
        $errors = [];
    } else {
        $errors = ['cost'];
    }
}

if (isset($user_bet['cost'])) {
    $min_price = intval(have_bet($con)['current_price']) + intval(have_lot($con)['step_bet']);

    if (intval($user_bet['cost']) < $min_price) {
        $errors = ['cost'];
    }

}

if (check_id($con, 'lots', $id) === false or $id == 'error') {
    $content_lot = include_template('404.php', [ 'text_error' => 'Извините, такого лота не найдено или не существует!']);
    $layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con), 'lot' => ['name' => '404']]);

} elseif($errors) {
    $content_lot = include_template('_lot.php', [ 'lot' => have_lot($con), 'bet' => have_bet($con), 'bets' => render_bets($con), 'user_bet' => $user_bet, 'errors' => $errors, 'master_id' => $master_lot_id, 'count_bets' => $count_bets_by_user]);

} else {
    $user_bet += [
        'user_id'=> $_SESSION['user']['id'],
        'lot_id' => $_GET['lot_id'],
    ];

    if(make_user_bet($con, $user_bet) == false) {
        $content_lot = include_template('404.php', [ 'text_error' => 'Извините, что-то пошло не так, попробуйте снова!']);
    } else {
        $content_lot = include_template('_lot.php', [ 'lot' => have_lot($con), 'bet' => have_bet($con), 'bets' => render_bets($con), 'user_bet' => $user_bet, 'con' => $con, 'master_id' => $master_lot_id]);
    }
}

$layout_content_lot = include_template('layout_lot.php', ['content' => $content_lot,'categories' => render_categories($con), 'lot' => have_lot($con)]);

print($layout_content_lot);

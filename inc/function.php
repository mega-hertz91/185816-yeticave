<?php
function around_price($price) {
    $elem = ceil($price);

    if ($elem > 1000) {
        $elem = number_format($price, 0 , ', ', ' ');
    }

    return $elem . ' ₽';
};

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function get_time_left ($final_date, $start_date) {
     $final_date = date_create($final_date);
     $start_date = date_create($start_date);

    $date_result = date_diff( $final_date, $start_date);
    $date_count = date_interval_format($date_result, '%H:%I');

    return $date_count;
}

/*Отрисовка списка лотов*/

function render_lots ($db_params) {
    $sql = 'SELECT l.id, l.name, l.image, c.name AS category, l.start_price  FROM lots l
            JOIN categories c
            ON l.id = c.id
            ORDER BY l.id
            LIMIT 9';

    $result = mysqli_query($db_params, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lots;
}

/*Отрисовка списка категорий*/

function render_categories ($db_params) {
    $sql = 'SELECT * FROM categories
            ORDER BY id';

    $result = mysqli_query($db_params, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}

/*Отрисовка одного лота*/

function have_lot ($db_params) {
   // $id = $_GET['lot_id'];

    if (isset($_GET['lot_id'])) {
        $id = intval($_GET['lot_id']);
    } else {
        $id = 'none';
    }

    $sql = 'SELECT l.id, l.name, l.description, c.name AS category, l.image, l.start_price, l.start_date, l.step_bet, l.finish_date FROM lots l
            JOIN categories c
            ON c.id = l.category_id
            WHERE l.id = ' . $id;
    $result = mysqli_query($db_params, $sql);
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lot[0];
};

/*Получение количества записей*/

function count_record ($db_params, $table) {
    $sql = 'SELECT COUNT(*) from ' . $table ;
    $result = mysqli_query($db_params, $sql);
    $count = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $count[0]['COUNT(*)'];
}
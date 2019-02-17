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

function render_lots ($db_param) {
    $sql = 'SELECT l.id, l.name, l.image, c.name AS category, l.start_price  FROM lots l
            JOIN categories c
            ON l.id = c.id
            ORDER BY l.id';

    $result = mysqli_query($db_param, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lots;
}

function render_categories ($db_param) {
    $sql = 'SELECT * FROM categories
            ORDER BY id';

    $result = mysqli_query($db_param, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}

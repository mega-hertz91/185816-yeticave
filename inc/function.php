<?php

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

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
    if (isset($_GET['lot_id'])) {
        $id = intval($_GET['lot_id']);
    } else {
        $id = '1';
    }

    $sql = 'SELECT l.id, l.name, l.description, c.name AS category, l.image, l.start_price, l.start_date, l.step_bet, l.finish_date FROM lots l
            JOIN categories c
            ON c.id = l.category_id
            WHERE l.id = ' . $id;
    $result = mysqli_query($db_params, $sql);
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lot[0];
};

/*Загрузка лотов по категории*/

function have_lots_by_category ($db_params) {
    if (isset($_GET['category_id'])) {
        $id = intval($_GET['category_id']);
    } else {
        $id = '1';
    }

    $sql = 'SELECT l.id, l.name, l.description, c.name AS category, l.image, l.start_price, l.start_date, l.step_bet, l.finish_date FROM lots l
            JOIN categories c
            ON c.id = l.category_id
            WHERE category_id =' . $id;
    $result = mysqli_query($db_params, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lots;
};

/*Возвращает текущую цену лота*/

function have_bet ($db_params) {
    if (isset($_GET['lot_id'])) {
        $id = intval($_GET['lot_id']);
    } else {
        $id = '1';
    }

    $sql = 'SELECT lot_id, MAX(price_bet) AS current_price from bets
            WHERE lot_id = ' . $id .'
            GROUP BY lot_id';
    $result = mysqli_query($db_params, $sql);
    $bet = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(!$bet) {
        $bet = [['current_price' => false]];
    }

    return $bet[0];
};

/*Проверка на наличие существующего ID*/

function check_id ($db_params, $table, $id) {
    $check = false;

    $sql = 'SELECT id FROM ' . $table;
    $result = mysqli_query($db_params, $sql);
    $lots_id = mysqli_fetch_all($result, MYSQLI_ASSOC);

   foreach ($lots_id as $key) {
      if($key['id'] === $id) {
          $check = true;
      }
    };

    return $check;
}

/*Проверяет ошибки при заполнении формы */


function check_input ($errors, $input) {
    $check = false;

    foreach ($errors as $key) {
        if ($key === $input) {
            $check = true;
        }
    }

    return $check;
};

/*Получает id категории*/

function get_id_category ($categories, $get_id) {
    $id_category = '';
    foreach ($categories as $key) {
        if ($key['name'] === $get_id) {
            $id_category = $key['id'];
        }
    }

    return $id_category;
}

/*Проверяет есть ли такой email в БД*/

function check_email ($db_params, $email) {
    $email = mysqli_real_escape_string($db_params, $email);
    $sql = "SELECT * FROM users
                WHERE email = '$email'";
    $result = mysqli_query($db_params, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result;
}

/*Проверяет пароль юзера*/

function check_password ($db_params, $email, $password) {
    $form_password = strval($password);

    $email = mysqli_real_escape_string($db_params, $email);
    $sql = "SELECT * FROM users
            WHERE email ='$email'";
    $user = mysqli_query($db_params, $sql);
    $user = mysqli_fetch_all($user, MYSQLI_ASSOC);

    $password = password_verify($form_password, $user[0]['password']);

    if($password === false) {
        $result = false;
    } else {
        $result = $user;
    };

    return $result;
}

/*Добавление лота в БД*/

function add_lot ($db_params, $form_data) {
    $sql = 'INSERT INTO lots (name, description, image, category_id, user_id, start_price, step_bet, finish_date)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($db_params, $sql, [$form_data['lot-name'], $form_data['message'], $form_data['image_url'], get_id_category(render_categories($db_params), $form_data['category']), $form_data['user_id'], $form_data['lot-rate'], $form_data['lot-step'], $form_data['lot-date']]);
    $result = mysqli_stmt_execute($stmt);

    if(!$result) {
        $result = 'error';
    } else {
        $result = mysqli_insert_id($db_params);
    }

    return $result;
};

/*Добавление юзера в БД*/

function add_user ($db_params, $form_data) {
    $check = true;

    $form_data['password']  = password_hash($form_data['password'], PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (nikname, email, password, contact, avatar)
            VALUES (?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($db_params, $sql,[$form_data['name'], $form_data['email'], $form_data['password'], $form_data['message'], $form_data['image_url']]);
    $result = mysqli_stmt_execute($stmt);

    if(!$result) {
        $check = false;
    }

    return $check;
};

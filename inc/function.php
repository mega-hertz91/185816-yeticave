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
};

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
};

function get_time_left ($final_date, $start_date) {
    $final_date = date_create($final_date);
    $start_date = date_create($start_date);

    $date_result = date_diff( $final_date, $start_date);
    $date_count = date_interval_format($date_result, '%H:%I');

    return $date_count;
};

/*Отрисовка списка лотов*/

function render_lots ($db_params) {
    $sql = 'SELECT l.id, l.name, l.image, c.name AS category, l.start_price, l.finish_date  FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            WHERE finish_date > NOW()
            ORDER BY l.id
            LIMIT 9';

    $result = mysqli_query($db_params, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lots;
};

/*Отрисовка списка категорий*/

function render_categories ($db_params) {
    $sql = 'SELECT * FROM categories
            ORDER BY id';

    $result = mysqli_query($db_params, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
};

/*Отрисовка одного лота*/

function have_lot ($db_params) {

    if (isset($_GET['lot_id'])) {
        $id = intval($_GET['lot_id']);
    } else {
        $id = '1';
    }

    $sql = 'SELECT l.id, l.name, l.description, c.name AS category, l.image, l.start_price, l.start_date, l.step_bet, l.finish_date, l.user_id FROM lots l
            JOIN categories c
            ON c.id = l.category_id
            WHERE l.id = ' . $id;
    $result = mysqli_query($db_params, $sql);
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if($lot == false) {
        $lot[0] = false;
    }

    return $lot[0];
};

/*Загрузка лотов по категории*/

function have_lots_by_category ($db_params) {
    $id = '';

    if (isset($_GET['category_id'])) {
        $id = intval($_GET['category_id']);
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
    $id = '';

    if (isset($_GET['lot_id'])) {
        $id = intval($_GET['lot_id']);
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

/*Отрисовывает ставки*/

function render_bets ($db_param) {
    if (isset($_GET['lot_id'])) {
        $id = intval($_GET['lot_id']);
    }

    $sql = "SELECT b.id, b.price_bet, u.nikname, b.lot_id, b.date_bet  FROM bets b
            JOIN users u
            ON user_id = u.id
            WHERE lot_id =" . $id;
    $result = mysqli_query($db_param, $sql);
    $bets = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $bets;
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
};

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

/*Задает имена полям ошибок*/

function get_errors_name ($errors) {
    $name = [
        'lot-name' => 'Название лота',
        'message' => 'Описание лота',
        'lot-rate' => 'Начальная цена',
        'lot-step' => 'Шаг ставки',
        'email' => 'Электронная почта',
        'password' => 'Пароль',
        'name' => 'Имя',
        'image-lot' => 'Изображение лота'
    ];

    $name_errors = [];

    foreach ($name as $key => $value) {
        foreach ($errors as $key1) {
            if($key1 == $key) {
                $name_errors[] = $value;
            }
        }
    }

    return $name_errors;
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
};

/*Проверяет есть ли такой email в БД*/

function check_email ($db_params, $email) {
    $email = mysqli_real_escape_string($db_params, $email);
    $sql = "SELECT * FROM users
                WHERE email = '$email'";
    $result = mysqli_query($db_params, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result;
};

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
};

/*Добавление лота в БД*/

function add_lot ($db_params, $form_data) {

    foreach ($form_data as $key => $value) {
        $form_data[$key] = strip_tags($value);
    }

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

    foreach ($form_data as $key => $value) {
        $form_data[$key] = strip_tags($value);
    }

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

/*Добавляет ставку*/

function make_user_bet ($db_params, $user_bet) {
    $sql = 'INSERT INTO bets (price_bet, user_id, lot_id)
            VALUES (?, ?, ?)';
    $stmt = db_get_prepare_stmt($db_params, $sql, [$user_bet['cost'], $user_bet['user_id'], $user_bet['lot_id']]);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        $result = false;
    } else {
        $result = true;
    }

    return $result;
};

/*Осуществляет логический поиск по словоформе*/

function get_search ($db_params, $form_data) {
    $form_data = mysqli_real_escape_string($db_params, $form_data);

    $sql = "SELECT l.id, l.name, l.description, l.image, l.start_price, c.name AS category, l.finish_date FROM lots l
            JOIN categories c
            ON l.category_id = c.id
            WHERE MATCH(l.name, l.description) AGAINST ('$form_data *' IN BOOLEAN MODE);";
    $result = mysqli_query($db_params, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(!$lots) {
        $lots = false;
    }

    return $lots;
};


/*Возвращает количество прошедшего времени с текущей точки*/

function have_date_last ($date) {
    $one_day = strtotime('5 march 2019') - strtotime('4 march 2019');
    $current_date = strtotime('now');
    $date = strtotime($date);
    $result = $current_date - $date;

    if($result > $one_day) {
        $result = date("j дней", $result);
    } elseif ($result > 3600) {
        $result = date("G часов", $result);
    } else {
        $result = date("i минут", $result);
    }



    return $result;
};

/*Возвращяет время до окночания торгов*/

function have_date_left ($date) {
    $one_day = strtotime('5 march 2019') - strtotime('4 march 2019');
    $current_date = strtotime('now');
    $date = strtotime($date);
    $result = $date - $current_date;

    if ($date < $current_date) {
        $result = false;
    } else {
        if($result > $one_day) {
            $result = date("j дней", $result);
        } elseif ($result > 3600) {
            $result = date("G:i", $result);
        } else {
            $result = date("i минут", $result);
        }
    }

    return $result;
};

/*Проверят дату не позже одного дня от данной отметки*/

function check_now_date ($check_date) {
    $check = true;

    $check_date = strtotime($check_date);
    $one_date = strtotime('5 march 2019') - strtotime('4 march 2019');
    $date_now = strtotime('now');
    $abs_date = $one_date + $date_now;

    if ($check_date < $abs_date) {
        $check = false;
    }

    return $check;
};

/*Проверят юзера лота*/

function check_user_by_lot ($db_params, $user_id_session, $user_lot_id) {
    $check = false;

    $sql = "SELECT user_id FROM lots
            WHERE user_id =" . $user_id_session;

    $result = mysqli_query($db_params, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if($user_id_session === $user_lot_id) {
        $check = true;
    } elseif (!$result) {
        $check = false;
    }

    return $check;
};

/*Проверяет количество ставок*/

function check_count_bets ($db_params, $user_id_session, $lot_id) {

    $sql = "SELECT user_id FROM bets
            WHERE lot_id = '{$lot_id}' and user_id =" . $user_id_session;

    $result = mysqli_query($db_params, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result;
};

/*Проверяет содержимое полей при отправке*/

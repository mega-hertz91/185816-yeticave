<?php

$sql_config = [
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_password' => '',
    'db_name' => 'yeticave'
];

$con = mysqli_connect($sql_config['db_host'], $sql_config['db_user'], $sql_config['db_password'], $sql_config['db_name']);

mysqli_set_charset($con, 'utf8');

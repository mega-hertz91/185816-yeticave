<?php
require_once ('inc/config.php');

unset($_SESSION['user']);
session_destroy();
sleep(3);
header('Location: /index.php');

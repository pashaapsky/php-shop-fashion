<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';

use function dataBase\updateOrderStatus as updateOrderStatus;
use function dataBase\setConnectToDB as setConnectToDB;

if (!empty($_POST)) {
    if (isset($_POST['orderID']) && isset($_POST['orderStatus'])) {
        updateOrderStatus(setConnectToDB(), $_POST['orderID'], $_POST['orderStatus']);
        echo 'Успех';
    } else {
        echo 'error';
    }
}
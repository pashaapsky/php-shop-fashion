<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';

use function dataBase\validationOrderFields as validationOrderFields;
use function dataBase\getUsersFromDB as getUsersFromDB;
use function dataBase\setConnectToDB as setConnectToDB;
use function dataBase\getProductFromDB as getProductFromDB;
use function dataBase\createOrder as createOrder;
use function dataBase\checkUserInDB as checkUserInDB;
use function dataBase\createNewUser as createNewUser;


if (!empty($_POST)) {
    $validate = validationOrderFields($_POST);

    if ($validate === 'Success Validation Fields') {
        $user = checkUserInDB(getUsersFromDB(setConnectToDB()), $_POST);
        $selectedProduct = getProductFromDB(setConnectToDB(), $_POST);

        if ($user) {
            if (createOrder(setConnectToDB(), $user['id'], $selectedProduct, $_POST)) {
                echo 'Заказ создан';
            } else {
                echo 'Не удалось создать заказ';
            }
        } else {
            $createdUserID = createNewUser(setConnectToDB(), $_POST);

            if ($createdUserID) {
                if (createOrder(setConnectToDB(), $createdUserID, $selectedProduct, $_POST)) {
                    echo 'Заказ создан';
                } else {
                    echo 'Не удалось создать заказ';
                };
            } else {
                echo 'Не удалось создать нового пользователя';
            }
        }
    } else {
        echo $validate;
    }
}


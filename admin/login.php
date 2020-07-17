<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';

use function dataBase\setConnectToDB as setConnectToDB;
use function dataBase\getUsersFromDB as getUsersFromDB;
use function dataBase\checkUserInDB as checkUserInDB;
use function dataBase\getUserGroup as getUserGroup;

if(!empty($_POST["email"])) {
    $users = getUsersFromDB(setConnectToDB());
    $currentUser = checkUserInDB($users, $_POST);

    if ($currentUser && password_verify($_POST['password'], $currentUser['password'])) {
        $userGroups = getUserGroup(setConnectToDB(), $currentUser);

        $grants = '';

        foreach ($userGroups as $group) {
            if ($group['name'] === 'Администратор') {
                setcookie('login', $_POST["email"], time() + (3600 * 24 * 30), '/');
                setcookie('grants', 'admin', time() + (3600 * 24 * 30), '/');
                $grants = 'admin';
                break;
            } elseif($group['name'] === 'Оператор') {
                setcookie('login', $_POST["email"], time() + (3600 * 24 * 30), '/');
                setcookie('grants', 'operator', time() + (3600 * 24 * 30), '/');
                $grants = 'operator';
                break;
            }
        }

        echo $grants ? 'Успех' : 'Пользователь не имеет достаточно прав';
    } else {
        echo 'Пользователь не найден, либо введеные данные не верны';
    }
} else {
    echo 'Не все поля заполнены';
}
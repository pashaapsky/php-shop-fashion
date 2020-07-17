<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
use function dataBase\loadNewProductToDB as loadNewProductToDB;
use function dataBase\validateNewProduct as validateNewProduct;


if (!empty($_FILES) && !empty($_POST)) {
    $validate = validateNewProduct($_POST);
    if ($validate) {
        loadNewProductToDB();
    } else {
        echo $validate;
    }
} else {
    echo 'Не все поля заполнены';
}
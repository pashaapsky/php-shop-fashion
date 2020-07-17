<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
use function dataBase\setConnectToDB as setConnectToDB;

if(!empty($_POST) && isset($_POST['del_product_id'])) {
    $connect = setConnectToDB();

    $delProductId = $connect->real_escape_string($_POST['del_product_id']);

    $result = mysqli_query($connect,
        "select orders.id from orders where product_id = $delProductId");

    if ($result) {
        $orders = [];

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($orders, $row['id']);
        }

        if (count($orders) > 0) {
            $response = '';

            foreach ($orders as $order) {
                $response .= $order . ', ';
            }

            $response = substr($response, 0, strlen($response) - 2);

            echo 'Невозможно удалить продукт, продукт содержиться в заказах с id №: ' . $response . PHP_EOL;
            die();
        } else {
            $result = mysqli_query($connect,
                "select photo from products where id='$delProductId'");

            $delProductPhoto = mysqli_fetch_assoc($result)['photo'];

            $result = mysqli_query($connect,
                "delete from categoty_product where product_id='$delProductId'");

            $result = mysqli_query($connect,
                "delete from products where id='$delProductId'");

            $photoPath = $_SERVER['DOCUMENT_ROOT'] . '/src/img/products/' . $delProductPhoto;

            $connect->close();

            try {
                unlink($photoPath);
                echo 'Продукт успешно удален';
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else {
        echo 'Нет соединения с БД';
    }
}
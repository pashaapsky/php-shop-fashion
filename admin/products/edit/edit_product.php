<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
use function dataBase\getProductSrcById as getProductSrcById;
use function dataBase\setConnectToDB as setConnectToDB;
use function dataBase\loadEditedProductFileToDB as loadEditedProductFileToDB;

if (!empty($_POST)) {
    $productID = $_POST['productID'];
    $productSrcOld = getProductSrcById(setConnectToDB(), $productID);

    $name = $_POST['product-name'];
    $productPrice = $_POST['product-price'];
    $categoryNew = $_POST['category'];
    $_POST['new'] === 'on' ? $new = 1 : $new = 0;
    $_POST['sale'] === 'on' ? $sale = 1 : $sale = 0;

    $errors = '';
    $successFlag = true;

    $connect = setConnectToDB();

    //category?
    $categoryOld = [];
    $result = mysqli_query($connect, "select c.name from categoty_product cp join category c on cp.category_id = c.id where cp.product_id ='$productID'");
    if (!$result) {
        $catFlag = false;
        $errors .= 'Ошибка получения категории из БД';
        die($errors);
    }

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($categoryOld, $row['name']);
    }
    sort($categoryOld);
    sort($categoryNew);

    if ($categoryNew !== $categoryOld) {
        //del
        $result = mysqli_query($connect, "delete from categoty_product where product_id = '$productID'");
        if (!$result) {
            $successFlag = false;
            $errors .= 'Ошибка удаления старых категорий продукта из БД';
            die($errors);
        }
        //add
        foreach ($categoryNew as $cat) {
            $result = mysqli_query($connect, "insert into categoty_product (product_id, category_id) values ('$productID', (select id from category where name='$cat'))");
            if (!$result) {
                $successFlag = false;
                $errors .= 'Ошибка добавления новых категорий продукта в БД';
                die($errors);
            }
        }
    }

    //validation POST
    if (is_int(intval($productPrice))) {
        $result = mysqli_query($connect, "update products set name='$name', price='$productPrice', new='$new', sale='$sale' where id='$productID'");
        if (!$result) {
            $successFlag = false;
            $errors .= 'Ошибка обновления информации о продукте в БД';
            die($errors);
        }
    } else {
        $successFlag = false;
        $errors .= 'Цена должна быть числом';
        die($errors);
    }

    //photo
    if (($productSrcOld['photo'] !== $_POST['productSrc']) && isset($_POST['productSrc'])) {
        $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/src/img/products/';
        $images = scandir($imgPath);

        if (in_array($productSrcOld['photo'], $images)) {
            $targetPath = $imgPath . $productSrcOld['photo'];
            unlink($targetPath);
            $result = loadEditedProductFileToDB($targetPath);
            if ($result !== 'Файл успешно добавлен') {
                $successFlag = false;
                $errors .= $result;
            }
        } else {
            $successFlag = false;
            $errors .= 'Ошибка удаления старой фотографии продукта';
            die($errors);
        }
    }

    if ($successFlag) {
        echo 'Файл успешно изменен';
    } else {
        echo $errors;
    }
}
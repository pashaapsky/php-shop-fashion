<?php
use function dataBase\setConnectToDB as setConnectToDB;

if (!empty($_GET) && isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = '';
}

$connect = setConnectToDB();
$result = mysqli_query($connect, "select COUNT(*) from products");
$countProducts = mysqli_fetch_row($result);

$totalPages = ceil(intval($countProducts[0]) / $countItemsOnPage);

$page = intval($page);

if (empty($page) or $page < 0) {
    $page = 1;
}
if ($page > $totalPages) {
    $page = $totalPages;
}

$start = ($page - 1) * $countItemsOnPage;
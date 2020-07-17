<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name('session_id');
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/logout.php';

use function dataBase\setConnectToDB as setConnectToDB;
use function dataBase\getCategoriesFromDB as getCategoriesFromDB;
use function dataBase\getNavMenu as getNavMenu;

$categories = getCategoriesFromDB(setConnectToDB());
$currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$correctUrlFlag = false;

if ($currentUrl === '/' || $currentUrl === '/index.php') {
    $correctUrlFlag = true;
}

if (explode('/', $currentUrl)[1] === 'admin' || explode('/', $currentUrl)[1] === 'delivery') {
    $correctUrlFlag = true;
}

foreach ($categories as $category) {
    if ($category['url'] === $currentUrl) {
        $correctUrlFlag = true;
        break;
    }
}

if ($correctUrlFlag === false) {
    header("Location: /404.php");
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Fashion</title>

    <base href="/">

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="/src/fonts/opensans-400-normal.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="/src/fonts/roboto-400-normal.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="/src/fonts/roboto-700-normal.woff2" as="font" crossorigin="anonymous">

    <link rel="icon" href="/src/img/favicon.png">
    <link rel="stylesheet" href="/src/css/style.min.css">

    <script
        defer
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script defer src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script defer src="/src/js/scripts.js"></script>
    <script defer src="/src/js/ajax.js"></script>
</head>
<body>
<header class="page-header">
    <a class="page-header__logo" href="/">
        <img src="/src/img/logo.svg" alt="Fashion">
    </a>

    <nav class="page-header__menu">
        <?php getNavMenu(); ?>
    </nav>
</header>
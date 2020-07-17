<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
use function dataBase\getCategoriesInfo as getCategoriesInfo;
use function dataBase\setConnectToDB as setConnectToDB;

$categories = getCategoriesInfo(setConnectToDB());

foreach ($categories as $cat) {
    if (in_array($cat, $editProduct['category'])) : ?>
        <option selected value=<?= $cat ?>><?= $cat ?></option>
    <?php else : ?>
        <option value=<?= $cat ?>><?= $cat ?></option>
    <?php endif; }
?>
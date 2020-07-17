<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
use function dataBase\getCategoriesInfo as getCategoriesInfo;
use function dataBase\setConnectToDB as setConnectToDB;

$categories = getCategoriesInfo(setConnectToDB());

foreach ($categories as $cat) : ?>
        <option value=<?= $cat ?>><?= $cat ?></option>
<?php endforeach; ?>


<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/dataBase/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/helpers.php';

use function dataBase\setConnectToDB as setConnectToDB;
use function dataBase\getProductsWithFilters as getProductsWithFilters;
use function helpers\getModelsCount as getModelsCount;

$countItemsOnPage = 6;

include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/pagination.php';

$result = getProductsWithFilters(setConnectToDB(), $_GET, $start, $countItemsOnPage);
$productsWithFilters = $result['productsWithFilters'];
$products = $result['products'];

$pages = ceil(intval($result['productsWithFilters']) / $countItemsOnPage);
?>

<section class="shop__sorting">
    <div class="shop__sorting-item custom-form__select-wrapper">
        <select class="custom-form__select js-orderByCat" name="category">
            <option class="custom-form__option" hidden="">Сортировка</option>

<!--            <option class="custom-form__option" value="price" --><?php //if (isset($_GET['how']) && ($_GET['how'] === 'price' || $_GET['how'] === 'aprice' || $_GET['how'] === 'dprice')) : ?><!--selected--><?// endif; ?><!-->По цене</option>-->

            <?php if(isset($_GET['how']) && ($_GET['how'] === 'price' || $_GET['how'] === 'aprice' || $_GET['how'] === 'dprice')) : ?>
                <option class="custom-form__option" value="price" selected>По цене</option>
            <? else : ?>
                <option class="custom-form__option" value="price">По цене</option>
            <? endif; ?>

<!--            <option class="custom-form__option" value="name" --><?php //if(isset($_GET['how']) && ($_GET['how'] === 'name' || $_GET['how'] === 'aname' || $_GET['how'] === 'dname')) : ?><!--selected--><?// endif; ?><!-->По названию</option>-->

            <?php if(isset($_GET['how']) && ($_GET['how'] === 'name' || $_GET['how'] === 'aname' || $_GET['how'] === 'dname')) : ?>
                <option class="custom-form__option" value="name" selected>По названию</option>
            <? else : ?>
                <option class="custom-form__option" value="name">По названию</option>
            <? endif; ?>
        </select>
    </div>

    <div class="shop__sorting-item custom-form__select-wrapper">
        <select class="custom-form__select js-sortedBy" name="prices">
            <option class="custom-form__option" hidden="">Порядок</option>

            <?php if(isset($_GET['how']) && ($_GET['how'] === 'aprice' || $_GET['how'] === 'aname')) : ?>
                <option class="custom-form__option" value="ASC" selected>По возрастанию</option>
            <? else : ?>
                <option class="custom-form__option" value="ASC">По возрастанию</option>
            <? endif; ?>

            <?php if(isset($_GET['how']) && ($_GET['how'] === 'dprice' || $_GET['how'] === 'dname')) : ?>
                <option class="custom-form__option" value="DESC" selected>По убыванию</option>
            <? else : ?>
                <option class="custom-form__option" value="DESC">По убыванию</option>
            <? endif; ?>
        </select>
    </div>

    <p class="shop__sorting-res">Найдено <span class="res-sort"><?= getModelsCount($productsWithFilters) ?></p>
</section>

<section class="shop__list" id="js-shop-list">
    <?php foreach ($products as $item) : ?>
        <article class="shop__item product" tabindex="0">
            <div class="product__image">
                <img src="<?= '/src/img/products/' . $item['photo'] ?>" alt="product-name">
            </div>

            <p class="product__name"><?= $item['name'] ?></p>

            <span class="product__price"><?= $item['price'] . ' руб.'?></span>
        </article>
    <?php endforeach; ?>
</section>

<ul class="shop__paginator paginator" id="js-shop-paginator">
    <?php if ($pages > 0) {
        foreach (range(1, $pages) as $page) : ?>
            <li>
                <a class="paginator__item paginator__item--shop" href=""><?= $page ?></a>
            </li>
        <? endforeach;
    }?>
</ul>

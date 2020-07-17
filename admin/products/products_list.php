<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/products/del_product.php';

$countItemsOnPage = 10;
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/pagination.php';

use function dataBase\getProductsInfo as getProductsInfo;
use function dataBase\setConnectToDB as setConnectToDB;

$products = getProductsInfo(setConnectToDB(), $start, $countItemsOnPage);

foreach ($products as $product) : ?>
    <li class="product-item page-products__item">
        <b class="product-item__name"><?= $product['name'] ?></b>

        <span class="product-item__field"><?= $product['id'] ?></span>

        <span class="product-item__field"><?= $product['price'] ?> руб.</span>

        <span class="product-item__field">
              <?php
              $catStr = '';
              foreach ($product['category'] as $pc) {
                  $catStr .= $pc . ', ';
              }

              echo $catStr = substr($catStr, 0, strrpos($catStr, ','));
              ?>
          </span>

        <span class="product-item__field">
              <?php
              if($product['new'] === '1') {
                  echo 'Да';
              } else echo 'Нет';
              ?>
          </span>

        <a href="/admin/products/edit/" class="product-item__edit js-edit-product-btn" aria-label="Редактировать"></a>

        <button class="product-item__delete js-product-delete-btn"></button>
    </li>
<?php endforeach; ?>




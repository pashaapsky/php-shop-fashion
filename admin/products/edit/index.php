<?php
if (!isset($_COOKIE['grants']) || $_COOKIE['grants'] != 'admin') {
    header('Location: /');
}
use function dataBase\getProductsInfo as getProductsInfo;
use function dataBase\setConnectToDB as setConnectToDB;
?>
<?php if (!empty($_GET) && isset($_GET['edit_product_id'])) :?>
<?php
      include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/header.php';
      $allProducts = getProductsInfo(setConnectToDB(), 0, 0);
      foreach ($allProducts as $product) {
          if ($product['id'] === $_GET['edit_product_id']) {
              $editProduct = $product;
              break;
          }
      }
?>
<main class="page-add">
    <h1 class="h h--1">Изменение товара</h1>

    <form class="custom-form" id="js-edit-product-form" action="" method="post">
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>

            <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
                <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= $editProduct['name'] ?>" required>
            </label>

            <label for="product-price" class="custom-form__input-wrapper">
                <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= $editProduct['price'] ?>" required>
            </label>
        </fieldset>

        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>

            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <input type="file" name="product-photo" id="product-photo" hidden="" required>
                    <label for="product-photo">Добавить фотографию</label>
                </li>
                <li class="add-list__item add-list__item--active">
                    <img src="/src/img/products/<?= $editProduct['photo'] ?>" alt="Изображение товара">
                </li>
            </ul>
        </fieldset>

        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>

            <div class="page-add__select">

                <select name="category[]" class="custom-form__select" multiple="multiple" required>
                    <option hidden="">Название раздела</option>
                    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/products/edit/edit_product_categories.php'; ?>
                </select>
            </div>

            <?php if ($editProduct['new'] === '1') :?>
                <input checked type="checkbox" name="new" id="new" class="custom-form__checkbox">
            <?php else : ?>
                <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
            <?php endif; ?>
            <label for="new" class="custom-form__checkbox-label">Новинка</label>

            <?php if ($editProduct['sale'] === '1') :?>
                <input checked type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
            <?php else : ?>
                <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
            <?php endif; ?>
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>

        <button class="button" id="js-edit-product-btn" type="submit">Изменить товар</button>
    </form>

    <section class="shop-page__popup-end page-add__popup-end" id="js-popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно изменен</h2>
        </div>
    </section>
</main>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/footer.php' ?>
<?php endif; ?>

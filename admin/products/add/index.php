<?php
if (!isset($_COOKIE['grants']) || $_COOKIE['grants'] != 'admin') {
    header('Location: /');
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/header.php' ?>

<main class="page-add">
    <?php if (!empty($_POST) && isset($_POST['edit_product_id'])) : ?>
        <h1 class="h h--1">Изменение товара</h1>
    <?php else : ?>
        <h1 class="h h--1">Добавление товара</h1>
    <?php endif; ?>

  <form class="custom-form" id="js-add-product-form" action="" method="post">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>

      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" required>

        <p class="custom-form__input-label">
          Название товара
        </p>
      </label>

      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" required>

        <p class="custom-form__input-label">
          Цена товара
        </p>
      </label>
    </fieldset>

    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>

      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="" required>
          <label for="product-photo">Добавить фотографию</label>
        </li>
      </ul>
    </fieldset>

    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>

      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple" required>
          <option hidden="">Название раздела</option>
          <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/products/add/categories.php'; ?>
        </select>
      </div>

      <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
      <label for="new" class="custom-form__checkbox-label">Новинка</label>

      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>

    <button class="button" id="js-add-product-btn" type="submit">Добавить товар</button>
  </form>

  <section class="shop-page__popup-end page-add__popup-end" id="js-popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
    </div>
  </section>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/footer.php' ?>

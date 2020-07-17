<?php
if (!isset($_COOKIE['grants']) || $_COOKIE['grants'] != 'admin') {
    header('Location: /');
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/header.php' ?>

<main class="page-products">
  <h1 class="h h--1">Товары</h1>

  <a class="page-products__button button" href="/admin/products/add/">Добавить товар</a>

  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>

    <span class="page-products__header-field">ID</span>

    <span class="page-products__header-field">Цена</span>

    <span class="page-products__header-field">Категория</span>

    <span class="page-products__header-field">Новинка</span>
  </div>

  <ul class="page-products__list" id="js-products-list">
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/products/products_list.php' ?>
  </ul>

  <ul class="shop__paginator paginator ">
      <?php
      foreach (range(1, $totalPages) as $page) : ?>
          <li>
              <a class="paginator__item paginator__item--page-products" href=""><?= $page ?></a>
          </li>
      <? endforeach; ?>
  </ul>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/footer.php' ?>

<?php
use function dataBase\getCategoryMenu as getCategoryMenu;
?>
<main class="shop-page">
  <header class="intro">
    <div class="intro__wrapper">
      <h1 class=" intro__title">COATS</h1>

      <p class="intro__info">Collection 2020</p>
    </div>
  </header>

  <section class="shop container">
    <section class="shop__filter filter">
      <form class="filter__form form" id="shop-form" action="" method="get">
        <div class="filter__wrapper">
          <b class="filter__title">Категории</b>

          <ul class="filter__list">
              <?php getCategoryMenu($categories) ?>
          </ul>
        </div>

        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>

          <div class="filter__range range">
            <span class="range__info">Цена</span>

            <div class="range__line" aria-label="Range Line"></div>

            <div class="range__res">
               <span class="range__res-item min-price js-min-price"> <?php if (isset($_GET['minprice'])) :?> <?= $_GET['minprice'] ?> <? else :?> 0 руб. <? endif; ?></span>

               <span class="range__res-item max-price js-max-price"> <?php if (isset($_GET['maxprice'])) :?> <?= $_GET['maxprice'] ?> <? else :?> 32000 руб. <? endif; ?></span>
            </div>
          </div>
        </div>

        <fieldset class="custom-form__group">
            <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?php if(isset($_GET['new']) && $_GET['new'] === 'on') : ?>checked <? endif;?>>
            <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>

            <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?php if (isset($_GET['sale']) && $_GET['sale'] === 'on') : ?>checked <? endif;?>>
            <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
        </fieldset>

        <button class="button" id="add-filters-btn" type="submit" style="width: 100%">Применить</button>
      </form>
    </section> <!-- shop__filter -->

     <div class="shop__wrapper js-shop-sorting">
         <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/shop-wrapper.php' ?>
  </section>  <!-- shop -->

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/order.php' ?>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/order-success.php' ?>
</main>
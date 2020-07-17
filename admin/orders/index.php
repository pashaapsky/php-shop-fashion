<?php
if (!isset($_COOKIE['grants']) ) {
    header('Location: /');
}
?>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/header.php';

use function dataBase\getOrdersList as getOrdersList;
use function dataBase\setConnectToDB as setConnectToDB;
use function dataBase\getUserFromOrder as getUserFromOrder;
?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>

  <ul class="page-order__list">
    <?php
        $orders = getOrdersList(setConnectToDB());
        foreach ($orders as $order) : ?>
        <?php $user = getUserFromOrder($order) ?>
        <li class="order-item page-order__item">
            <div class="order-item__wrapper">
                <div class="order-item__group order-item__group--id">
                    <span class="order-item__title">Номер заказа</span>

                    <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
                </div>

                <div class="order-item__group">
                    <span class="order-item__title">Сумма заказа</span><?= $order['price'] . ' руб.'?>
                </div>

                <button class="order-item__toggle"></button>
            </div>

            <div class="order-item__wrapper">
                <div class="order-item__group order-item__group--margin">
                    <span class="order-item__title">Заказчик</span>

                    <span class="order-item__info"><?= $user['surname'] . ' ' . $user['name'] . ' ' . $user['thirdName'] ?></span>
                </div>

                <div class="order-item__group">
                    <span class="order-item__title">Номер телефона</span>

                    <span class="order-item__info"><?= $user['phone'] ?></span>
                </div>

                <div class="order-item__group">
                    <span class="order-item__title">Способ доставки</span>

                    <span class="order-item__info"><?= $order['delivery'] ?></span>
                </div>

                <div class="order-item__group">
                    <span class="order-item__title">Способ оплаты</span>

                    <span class="order-item__info"><?= $order['payment'] ?></span>
                </div>

                <div class="order-item__group order-item__group--status">
                    <span class="order-item__title">Статус заказа</span>

                    <?php if ($order['status'] === 'Не обработан') : ?>
                        <span class="order-item__info order-item__info--no"><?= $order['status'] ?></span>
                    <?php else : ?>
                        <span class="order-item__info order-item__info--yes"><?= $order['status'] ?></span>
                    <?php endif; ?>
                    <button class="order-item__btn js-order-item-btn">Изменить</button>
                </div>
            </div>

            <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Адрес доставки</span>
                    <?php if ($order['delivery'] === 'Самовывоз') :?>
                        <span class="order-item__info">г. Москва, ул. Тверская, д.4</span>
                    <?php else : ?>
                        <span class="order-item__info"><?= 'г. ' . $order['city'] . ', ул. ' . $order['street'] . ', дом. ' . $order['home'] . ', кв. ' . $order['aprt']?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Комментарий к заказу</span>

                    <span class="order-item__info"><?= $order['comment'] ?></span>
                </div>
            </div>
        </li>
    <? endforeach; ?>
  </ul>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/footer.php' ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/header.php' ?>

<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>

  <form class="custom-form" id="js-auth-form" action="" method="post">
    <input type="email" class="custom-form__input" name="email" placeholder="email" required="">

    <input type="password" class="custom-form__input" name="password" placeholder="password" required="">

    <button class="button" id="js-auth-form-btn" type="submit">Войти в личный кабинет</button>
  </form>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/templates/footer.php' ?>

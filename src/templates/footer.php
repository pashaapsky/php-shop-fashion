<?php use function dataBase\getFooterNavMenu as getFooterNavMenu; ?>
<footer class="page-footer">
  <div class="container">
    <a class="page-footer__logo" href="/">
      <img src="/src/img/logo--footer.svg" alt="Fashion">
    </a>
    <nav class="page-footer__menu">
        <?php getFooterNavMenu(); ?>
    </nav>
    <address class="page-footer__copyright">
© Все права защищены
</address>
  </div>
</footer>
</body>
</html>
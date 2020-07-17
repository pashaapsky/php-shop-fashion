<?php
if (isset($_GET['logout']) && $_GET['logout'] === 'yes') {
    setcookie('session_id', '', time() - 42000);
    setcookie('login', '', time() - 42000);
    setcookie('grants', '', time() - 42000);
    session_destroy();

    header('Location: /');
    exit;
}
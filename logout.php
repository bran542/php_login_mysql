<?php
    //INICIALIZAMOS LA SESSION
    session_start();
    //QUITAMOS LA SESSION
    session_unset();
    //DESTRUIMOS LA SESSION
    session_destroy();
    header('Location: /php_login_mysql');
?>
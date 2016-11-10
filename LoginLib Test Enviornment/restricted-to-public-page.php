<?php
    require_once "../LoginLib/Authentication.php";
    session_start();

    Authentication::isValidUserOrRedirectTo("https://www.google.com");
    echo $_SESSION["auth-current-user"]->getFirstName();
?>
HEoLLO WORLD

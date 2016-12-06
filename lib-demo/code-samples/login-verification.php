<?php

    /*
     * If user is NOT logged in this line of code will
     * redirect the user to the URL passed into the method
     * parameter.
     *
     * Place this line on all pages where you want to restrict
     * access to users not logged in.
     */

    Authentication::isValidUserElseRedirectTo("login.php");

?>
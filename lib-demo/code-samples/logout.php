<?php

    //Checks if the form has been submitted
    if (isset($_POST["logout"])) {

        /*
         * If user is logged in then this method
         * simply logs out the user.
         *
         * The parameter passed to this method is the
         * location of where you want the user to be
         * redirected to when logged out.
         */

        Authentication::logout("login.php");
    }

?>
<?php

//Checks if the form has been submitted
if (isset($_POST["logout"])) {

        /*
         * If user is NOT logged in then this method
         * simply logs in the user.
         *
         * This method takes three parameters.
         *
         * Email for a user name,
         * Password for verification,
         * and a Current Site to denote which site you are
         * logging into.
         *
         * This method also has a 4th parameter that is optional.
         * The 4th parameter is a url of where you want a user to
         * redirect to when login was successful.
         */

        Authentication::login($email, $password, $currentSite, $redirectUrl);
}

?>
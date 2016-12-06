<?php

    //Checks if the form has been submitted
    if (isset($_POST["submit"])) {

        /**
         * The parameters passed in to this method
         * are required for creating existing users
         * access to other sites.
         */

        //NOTE: This only adds existing user's

        Registration::registerExistingUser($email, $currentSite, $password);

    }

?>
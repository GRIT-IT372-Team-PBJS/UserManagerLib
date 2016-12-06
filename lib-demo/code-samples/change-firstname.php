<?php

    //Checks if the form has been submitted
    if (isset($_POST["submit"])) {

        /**
         * User must be logged in for this method to work.
         *
         * Simply pass the new FIRST name into the method and
         * the method will change the current FIRST name in the
         * database with the new FIRST name you passed in.
         */

        CurrentUser::editFirstName($newFirstName);
    }

?>
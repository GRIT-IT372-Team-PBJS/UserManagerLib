<?php

    //Checks if the form has been submitted
    if (isset($_POST["submit"])) {

        /**
         * User must be logged in for this method to work.
         *
         * Simply pass the new password into the method and
         * the method will change the current password in the
         * database with the new password you passed in.
         *
         * Note: Password will be hashed before stored in the database.
         */

        Authentication::changePassword($newPassword);
    }
?>
<?php

    //Checks if the form has been submitted
    if (isset($_POST["submit"])) {

        /**
         * The parameters passed in to this method
         * are required for creating a user in the
         * database.
         */

        //NOTE: This only adds new user's

        Registration::registerNewUser($firstName, $middleName, $lastName,
                                            $email, $siteName, $password);

    }

?>
<?php

//Checks if the form has been submitted
if (isset($_POST["submit"])) {

    /**
     * User must be logged in for this method to work.
     *
     * Simply pass the new LAST name into the method and
     * the method will change the current LAST name in the
     * database with the new LAST name you passed in.
     */

    CurrentUser::editLastName($newLastName);
}

?>
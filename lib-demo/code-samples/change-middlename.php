<?php

//Checks if the form has been submitted
if (isset($_POST["submit"])) {

    /**
     * User must be logged in for this method to work.
     *
     * Simply pass the new MIDDLE name into the method and
     * the method will change the current MIDDLE name in the
     * database with the new MIDDLE name you passed in.
     */

    CurrentUser::editMiddleName($newMiddleName);
}

?>
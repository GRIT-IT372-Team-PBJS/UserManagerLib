<?php

//Checks if the form has been submitted
if (isset($_POST["submit"])) {

    /**
     * User must be logged in for this method to work.
     *
     * Simply pass the new EMAIL into the method and
     * the method will change the current EMAIL in the
     * database with the new EMAIL you passed in.
     */

    CurrentUser::editEmail($newEmail);
}

?>
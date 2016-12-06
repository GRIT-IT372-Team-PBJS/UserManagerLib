<?php

    /**
     * Making sure that the User class is required and session_start
     * is called so that the login session is valid.
     */
    require_once "../../UserManagerLib/User.php";
    session_start();

    /**
     * This is the main handle for the login session. refrain from
     * creating a session of the same name.
     */
    $_SESSION["auth-current-user"];

    /**
     * This session handle is also a User object so it has all
     * the functionality of a User class.
     *
     * Therefore a developer has access to all of the logged
     * in user's data EXCEPT the password.
     */

    //gets first name.
    $_SESSION["auth-current-user"]->getFirstName();

    //gets middle name.
    $_SESSION["auth-current-user"]->getMiddleName();

    //gets last name.
    $_SESSION["auth-current-user"]->getLastName();

    //gets email.
    $_SESSION["auth-current-user"]->getEmail();

    //gets auth type.
    $_SESSION["auth-current-user"]->getAuthType();

    //gets the numeric value of the auth type.
    $_SESSION["auth-current-user"]->getAuthRank();

    //gets the user id of this user from the db.
    $_SESSION["auth-current-user"]->getUserId();

?>
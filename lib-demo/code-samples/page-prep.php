<?php

/**
 * Always use require_once on all classes when using them.
 * Otherwise errors may occur do to duplication of code that
 * should not be duplicated.
 *
 * All classes are designed to work stand alone.
 */

require_once "../../UserManagerLib/Authentication.php";
require_once "../../UserManagerLib/HelperFunctions.php";

/**
 * In most cases you don't need to require a user class
 * but if you want to use the login session WITHOUT requiring
 * any of these classes, ( Authentication class, CurrentUser
 * class or Registration class ) then a User class is required.
 * Because a User object is stored into the login session.
 */

require_once "../../UserManagerLib/User.php";

/**
 * Always start your session AFTER you require all
 * the dependent library classes.
 */

session_start();

?>
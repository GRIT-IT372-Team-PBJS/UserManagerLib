<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 4:46 PM
 */

/**
 * Class AuthType
 *
 * This is a enumeration of type
 * used to restrict the use of invalid user types.
 */
abstract class AuthType
{
    const SUPER_ADMIN = "SUPER_ADMIN";
    const ADMIN = "ADMIN";
    const EMPLOYEE = "EMPLOYEE";
    const STUDENT = "STUDENT";
    const GUEST = "GUEST";
}
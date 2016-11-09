<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/3/2016
 * Time: 7:32 PM
 */

require_once "User.php";
require_once "Database.php";

class Registration
{
    private $db;
    private $registeredUser;

    public static function registerUser($firstName, $middleName, $lastName, $email, $registeredSite, $type){
        if(self::userExists($email)){
            self::registerUserToSite($email, $registeredSite);
        } else {
            self::addNewUserToDB($firstName, $middleName, $lastName, $email, $registeredSite, $type);
            self::getUserId();
        }
    }

    private static function userExists($email) {



    }


    private static function registerUserToSite($email, $registeredSite) {
        return true;
    }

    private static function getUserId() {

    }

    private static function addNewUserToDB($firstName, $middleName, $lastName, $email, $registeredSite, $type) {

    }
}
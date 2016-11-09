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

    public static function registerUser($firstName, $middleName, $lastName, $email, $currentSite, $type, $password)
    {
        if (self::userExists($email)) {

            self::registerUserToSite($email, $currentSite);
            return true;

        } else {

            if (self::isAllIncomingDataValid()) {

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    self::addNewUserToDB($firstName, $middleName, $lastName, $email, $currentSite, $type, $hashedPassword);
                    return true;

            } else {

                return false;

            }

        }
    }

    private static function userExists($email)
    {


    }
    

    private static function registerUserToSite($email, $registeredSite) {
        return true;
    }

    private static function isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $type)
    {
        $registeredUser = new User();

        //if all user data is valid return true.
        if ($registeredUser->setFirstName($firstName) &
            $registeredUser->setLastName($lastName) &
            $registeredUser->setMiddleName($middleName) &
            $registeredUser->setEmail($email) &
            $registeredUser->setRegisteredSites(self::addStringToNewArray($currentSite)) &
            $registeredUser->setType($type)
        ) {

            return true;

        } else {

            return false;

        }
    }

    private static function addStringToNewArray($currentSite)
    {
        $currentSiteArr = [];
        $currentSiteArr[0] = $currentSite;
        return $currentSiteArr;
    }

    private static function getDBConnection(){
        return self::$db = Database::getDBConnection();
    }

    private static function closeDBConnection(){
        Database::closeDBConnection();
        }

}
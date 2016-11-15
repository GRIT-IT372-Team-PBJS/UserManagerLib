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
    private $dbConnection;

    /**
     * This method is responsible for registering existing users to new sites or new users in general.
     * Returns True is registration was successful.
     * Returns False if registration was unsuccessful.
     * @param $firstName : String first name.
     * @param $middleName : String middle name (can be left blank if no middle name)
     * @param $lastName : String last name.
     * @param $email : String email.
     * @param $currentSite : String current site name.
     * @param $type : String user type.
     * @param $password : This parameter is Optional because if a user already exists in the db they dont need to set a password field.
     * if the user doesnt exist in the database then the parameter is used to create that user with the new password.
     * @return Boolean
     */
    public static function registerUser($firstName, $middleName, $lastName, $email, $currentSite, $type)
    {
        //This gets the 7th argument passed in as a $password.
        $password = func_get_arg(6);

        if (self::doesUserExistsInDB($email)) {

            self::registerUserToSite($email, $currentSite);
            return true;

        } else {

            if (self::isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $type, $password)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                self::addNewUserToDB($firstName, $middleName, $lastName, $email, $currentSite, $type, $hashedPassword);
                return true;

            } else {

                return false;

            }

        }
    }

    private static function doesUserExistsInDB($email)
    {


    }


    private static function registerUserToSite($email, $registeredSite)
    {
        return true;
    }

    private static function isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $type,$password)
    {

        //if all user data is valid return true.
        if (self::isValidName($firstName) && self::isValidMiddleName($middleName) && self::isValidName($lastName) &&
            self::isValidEmail($email) && self::isValidSite($currentSite) && self::isValidType($type) && isPasswordValid($password)
        ) {

            return true;

        } else {

            return false;

        }
    }

    public static function isValidName($name)
    {

    }

    public static function isValidMiddleName($middleName)
    {

    }

    public static function isValidEmail($email)
    {

    }

    public static function isValidSite($currentSite)
    {

    }

    public static function isValidType($type)
    {

    }

    public static function isPasswordValid($password) {

    }


    private static function getDBConnection()
    {
        return self::$dbConnection = Database::getDBConnection();
    }

    private static function closeDBConnection()
    {
        Database::closeDBConnection();
    }

}
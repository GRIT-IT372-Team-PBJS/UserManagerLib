<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/3/2016
 * Time: 7:32 PM
 */

require_once "User.php";
require_once "Database.php";
require_once "HelperFunctions.php";

class Registration
{
    /**
     * This method is responsible for registering existing users to new sites or new users in general.
     * Returns True is registration was successful.
     * Returns False if registration was unsuccessful.
     * @param $firstName : String first name.
     * @param $middleName : String middle name (can be left blank if no middle name)
     * @param $lastName : String last name.
     * @param $email : String email.
     * @param $currentSite : String current site name.
     * @param $password : This parameter is Optional because if a user already exists in the db they dont need to set a password field.
     * if the user does't exist in the database then the parameter is used to create that user with the new password.
     * @return Boolean
     */
    public static function registerUser($firstName, $middleName, $lastName, $email, $currentSite)
    {

        //This gets the 7th argument passed in as a $password.

        if (func_num_args() > 5) {
            $password = func_get_arg(5);
        }

        if (HelperFunctions::isUserInDB($email)){

            if(!HelperFunctions::isRegisteredToCurrentSite($currentSite, $email)) {

                self::registerUserToSite($email, $currentSite);

                return true;

            } else {

                return false;

            }

        } else {

                $authType = "REGULAR";

            if (HelperFunctions::isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $authType, $password)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                self::addNewUserToDB($firstName, $middleName, $lastName, $email, $authType, $hashedPassword);
                self::registerUserToSite($email, $currentSite);
                self::setAuthTypeInDB($email, $authType);

                return true;

            } else {

                return false;

            }

        }
    }

    private static function addNewUserToDB($firstName, $middleName, $lastName, $email, $type, $hashedPassword){



        $sql = "INSERT INTO users (firstname, lastname, middlename, email, auth_type, password)
                VALUES(:firstname, :lastname, :middlename, :email, :auth_type, :password)";

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":firstname", $firstName, PDO::PARAM_STR);
        $statement->bindParam(":lastname", $lastName, PDO::PARAM_STR);
        $statement->bindParam(":middlename", $middleName, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":auth_type", $type, PDO::PARAM_STR);
        $statement->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

    }


    public static function registerUserToSite($email, $currentSite)
    {

        $sql = "INSERT INTO user_site_xref (user_id, site_id)
                VALUES(:user_id, :site_id)";

        $userId = HelperFunctions::getUserId($email);
        $siteId = HelperFunctions::getSiteId($currentSite);

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":site_id", $siteId, PDO::PARAM_INT);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());
    }

    private static function setAuthTypeInDB($email, $authType){

        $sql = "INSERT INTO user_auth_xref (user_id, auth_type)
                VALUES(:user_id, :auth_type)";

        $userId = HelperFunctions::getUserId($email);

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":auth_type", $authType, PDO::PARAM_STR);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

    }



}
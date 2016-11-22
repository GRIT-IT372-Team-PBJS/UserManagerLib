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

/**
 * Class Registration
 *
 * This class is used to registering new users and register existing users to new sites or applications that belong to greenrivertech.net.
 *
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 *
 */
class Registration
{
    /**
     * Registers new users to the database if they don't exist in the database. You can check this by using the methods in the HelperFunctions class. If user already exists in the database then use the registerExistingUsers method in this class.
     *
     * Returns TRUE if registration was successful.
     *
     * Returns FALSE if registration was unsuccessful.
     *
     * @param string $firstName first name field.
     * @param string $middleName middle name field (can be left blank if no middle name).
     * @param string $lastName last name field.
     * @param string $email email field.
     * @param string $currentSite current site name. This field isn't filled by the user it is set by the developer.
     * @param string $password This field is to create a password for a new user.
     * @param string $authType authority type field, if you dont add this field it will set a default parameter of "REGULAR". This field isn't filled by the user it is set by the developer.
     * @return Boolean
     */
    public static function registerNewUser($firstName, $middleName, $lastName, $email, $currentSite, $password, $authType = "REGULAR")
    {

            if (!HelperFunctions::isUserInDB($email) && HelperFunctions::isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $authType, $password)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if( self::addNewUserToDB($firstName, $middleName, $lastName, $email, $authType, $hashedPassword) &&
                    self::registerExistingUser($email, $currentSite) &&
                    self::setAuthTypeInDB($email, $authType)){

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
    }

    //adds new user to database if there were any database errors return false.
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

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        return $isThereNoDatabaseErrors;

    }


    /**
     * If registerer already exists in the database then there is no need to collect all data of that user. User must enter a password to be registered to new sites. This is so that people other than the user cant simply add users to other sites.This method will associate this user as registered to the site it is registering for (e.g. Peter is registered to IT-Connect).
     *
     * Returns TRUE if registration was successful.
     *
     * Returns FALSE if registration was un-successful.
     *
     * @param string $email email field.
     * @param string $currentSite current site name. This field isn't filled by the user it is set by the developer.
     * @param string $password pass in a password to validate user adding new site.
     * @return boolean
     */
    public static function registerExistingUser($email, $currentSite, $password)
    {
        if(HelperFunctions::isUserInDB($email) && HelperFunctions::isValidSite($currentSite)) {

            $userPasswordInDB = self::fetchUserPasswordFromDB($email);

            if ($userPasswordInDB != false) {

                if(password_verify($userPasswordInDB, $password)) {

                    $sql = "INSERT INTO user_site_xref (user_id, site_id)
                            VALUES(:user_id, :site_id)";

                    $userId = HelperFunctions::getUserId($email);
                    $siteId = HelperFunctions::getSiteId($currentSite);

                    $statement = Database::getDBConnection()->prepare($sql);
                    $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
                    $statement->bindParam(":site_id", $siteId, PDO::PARAM_INT);
                    $statement->execute();

                    $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

                    //Uncomment the code below if you want to do error handling on this database call.
                    //print_r($statement->errorInfo());

                    return true && $isThereNoDatabaseErrors;

                    } else {
                        return false;
                    }

                } else {

                    return false;
                }

            } else {

                return false;
            }

        }


    //sets the authtype for the user and returns true if there was no database errors.
    private static function setAuthTypeInDB($email, $authType){

        $sql = "INSERT INTO user_auth_xref (user_id, auth_type)
                VALUES(:user_id, :auth_type)";

        $userId = HelperFunctions::getUserId($email);

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":auth_type", $authType, PDO::PARAM_STR);
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        return $isThereNoDatabaseErrors;

    }

    //gets password associated with the email in the database. If the email is valid in
    //the database it returns the database results else returns a false boolean.
    private static function fetchUserPasswordFromDB($email)
    {
        $sql = "SELECT password FROM users WHERE email = :email";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $result = $isThereNoDatabaseErrors ? $statement->fetch()["password"] : false;

        return $result;
    }



}
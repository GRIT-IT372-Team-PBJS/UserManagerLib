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
require_once "RunsSQL.php";

/**
 * Class Registration
 *
 * This class is used to registering new users and register existing users to new sites or applications that belong to greenrivertech.net.
 *
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 *
 */
class Registration extends RunsSQL
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
     * @return Boolean
     */
    public static function registerNewUser($firstName, $middleName, $lastName, $email, $currentSite, $password)
    {
            $authType = "REGULAR";

            if (!HelperFunctions::isUserInDB($email) && HelperFunctions::isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $authType, $password)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                //checks if none of the DB queries failed while running the sql. If any of them failed return false.
                if( self::addNewUserToDB($firstName, $middleName, $lastName, $email, $authType, $hashedPassword) &&
                    self::setAuthTypeInDB($email, $authType)){

                    if (self::registerExistingUser($email, $currentSite, $password)){
                        return true;
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

    //adds new user to database if there were any database errors return false.
    private static function addNewUserToDB($firstName, $middleName, $lastName, $email, $type, $hashedPassword){

        $sql = "INSERT INTO users (firstname, lastname, middlename, email, auth_type, password)
                VALUES( " . parent::PREPARED_STATEMENT_1 . ",  " . parent::PREPARED_STATEMENT_2 . ", " . parent::PREPARED_STATEMENT_3 . ", " . parent::PREPARED_STATEMENT_4 . ", " . parent::PREPARED_STATEMENT_5 . ", " . parent::PREPARED_STATEMENT_6 . ")";

        return parent::runSQLWithSixClauses($sql, $firstName, $lastName, $middleName, $email, $type, $hashedPassword, false);

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

                if(password_verify($password, $userPasswordInDB["password"])) {

                    $sql = "INSERT INTO user_site_xref (user_id, site_id)
                            VALUES(" . parent::PREPARED_STATEMENT_1 . ", " . parent::PREPARED_STATEMENT_2 . ")";

                    $userId = HelperFunctions::getUserId($email);
                    $siteId = HelperFunctions::getSiteId($currentSite);

                    //sql will return false if it failed.
                    $isThereNoDatabaseErrors = parent::runSQLWithTwoClauses($sql, $userId, $siteId, false);

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
                VALUES(" . parent::PREPARED_STATEMENT_1 . ", " . parent::PREPARED_STATEMENT_2 . ")";

        $userId = HelperFunctions::getUserId($email);

        //sql will return false if it failed
        $isThereNoDatabaseErrors = parent::runSQLWithTwoClauses($sql, $userId, $authType, false);

        return $isThereNoDatabaseErrors;
    }

    //gets password associated with the email in the database. If the email is valid in
    //the database it returns the database results else returns a false boolean.
    private static function fetchUserPasswordFromDB($email)
    {
        $sql = "SELECT password FROM users WHERE email = " . parent::PREPARED_STATEMENT_1;

        //sql will return false if it failed
        return parent::runSQLWithOneClause($sql, $email, true);
    }
}
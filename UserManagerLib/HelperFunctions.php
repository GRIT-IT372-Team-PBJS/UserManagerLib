<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/16/2016
 * Time: 6:58 PM
 */

require_once "Database.php";

/**
 * Class HelperFunctions
 *
 * This class is used to give database utility to other developers using this library.
 *
 */
class HelperFunctions
{
    /**
     * Gets the site id associated with the site name passed in.
     *
     * Returns a site_id if siteName is valid.
     *
     * @param $siteName name of site.
     * @return int
     */
    public static function getSiteId($siteName){

        $sql = "SELECT site_id FROM sites WHERE site_name = :site_name";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":site_name", $siteName, PDO::PARAM_INT);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $result = $statement->fetch();

        return $result["site_id"];

    }

    /**
     * Gets the user id associated with the email passed in.
     *
     * Returns a user_id if email is valid.
     *
     * @param $email email of user.
     * @return int
     */
    public static function getUserId($email){

        $sql = "SELECT user_id FROM users WHERE email = :email";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":email", $email, PDO::PARAM_INT);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $result = $statement->fetch();

        return $result["user_id"];

    }

    /**
     * This checks the logged in users rank in terms of integers so that you can scale authentication, Example: if a Admin is rank 1 and a SuperAdmin is rank 0 and a Regular user is rank 10 and you want anyone who is Admin and up to have access you would want something like "If UserRankLevel <= AdminRankLevel then allow access".
     *
     * Returns FALSE if user is either not logged in or NOT Authorized.
     *
     * Returns TRUE if user is Authorized.
     *
     * @param int $rankNeeded This is so you can set the rank needed for access.
     * @return Boolean
     */
    public static function isUserAuthorized($rankNeeded)
    {

        if (HelperFunctions::isLoggedIn()) {

            $userRank = $_SESSION["auth-current-user"]->getAuthRank();

            //Checks to make sure the user who wants to use this class has the proper authority to use this class.
            return $userRank <= $rankNeeded && $userRank >= 0;

        } else {
            return false;
        }
    }

    public static function isRegisteredToCurrentSite($currentSite, $email)
    {

        $siteId = self::getSiteId($currentSite);
        $userId = self::getUserId($email);

        $sql = "SELECT count(*) FROM user_site_xref WHERE site_id = :site_id AND user_id = :user_id";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":site_id", $siteId, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        if($statement->fetchColumn() > 0 && $isThereNoDatabaseErrors) {

            return true;

        } else {

            return false;
        }
    }

    public static function isUserInDB($email)
    {
        $sql = "SELECT count(*) From users WHERE email = :email";

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $rowCount = $statement->fetchColumn();

        if ($rowCount > 0 && $isThereNoDatabaseErrors){
            return true;
        } else {
            return false;
        }
    }

    public static function isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $type, $password)
    {

        //if all user data is valid return true.
        $isAllDataValid = self::isValidName($firstName, 2) && self::isValidMiddleName($middleName) && self::isValidName($lastName, 2) &&
            self::isValidEmail($email) && self::isValidSite($currentSite) && self::isValidType($type) && self::isPasswordValid($password);

        return $isAllDataValid;
    }

    public static function isValidName($name, $minNumberOfChars)
    {

        $isValidName = preg_match("/^[a-zA-Z'-]+$/", $name);
        $isMoreThan1Char = strlen($name) >= $minNumberOfChars;

        return $isValidName && $isMoreThan1Char;
    }


    public static function isValidMiddleName($middleName)
    {

        $isValidMiddleName = empty($middleName) || $middleName == "" || self::isValidName($middleName, 0);

        return $isValidMiddleName;
    }

    public static function isValidEmail($email)
    {
        $isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

        return $isValidEmail;
    }

    public static function isValidSite($currentSite)
    {
        $sql = "SELECT count(*) FROM sites WHERE site_name = :site_name";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":site_name", $currentSite, PDO::PARAM_STR);
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $isValidSite = $statement->fetchColumn() > 0;


        return $isValidSite && $isThereNoDatabaseErrors;
    }

    public static function isValidType($type)
    {

        $sql = "SELECT count(*) FROM auth WHERE auth_type = :auth_type";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":auth_type", $type, PDO::PARAM_STR);
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $isValidType = $statement->fetchColumn() > 0;

        return $isValidType && $isThereNoDatabaseErrors;

    }

    /**
     * Password must have at least 8 characters long, and must contain at least one lower case character
     * , one uppercase character, and one digit.
     * Returns True if password is valid.
     * Retruns False if password is NOT valid.
     * @param $password : String passed being validated/
     * @return Boolean
     */
    public static function isPasswordValid($password) {

        $isValidPassword = preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password);

        return $isValidPassword;
    }

    /**
     * Checks to see if a user is logged in.
     *
     * @return Boolean
     */
    public static function isLoggedIn()
    {
        //checks if the session is set and if the session is set with the correct type.
        return isset($_SESSION["auth-current-user"]) && $_SESSION["auth-current-user"] instanceof User;
    }


}
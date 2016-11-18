<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/16/2016
 * Time: 6:58 PM
 */

require_once "Database.php";
class HelperFunctions
{
    public static function getSiteId($siteName){

        $sql = "SELECT site_id FROM sites WHERE site_name = :site_name";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":site_name", $siteName, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        return $result["site_id"];

    }

    public static function getUserId($email){

        $sql = "SELECT user_id FROM users WHERE email = :email";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":email", $email, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        return $result["user_id"];

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

        if($statement->fetchColumn() > 0) {

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
        $rowCount = $statement->fetchColumn();

        if ($rowCount > 0){
            return true;
        } else {
            return false;
        }
    }

    public static function isAllIncomingDataValid($firstName, $middleName, $lastName, $email, $currentSite, $type, $password)
    {
        //if all user data is valid return true.
        $isAllDataValid = self::isValidName($firstName, 2) && self::isValidMiddleName($middleName) && self::isValidName($lastName, 2) &&
            self::isValidEmail($email) && self::isValidSite($currentSite) && self::isValidType($type) && isPasswordValid($password);

        return $isAllDataValid;
    }

    public static function isValidName($name, $minNumberOfChars)
    {

        $isValidName = preg_match("/[^A-Za-z'-]/", $name);
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

        $isValidSite = $statement->fetchColumn() > 0;

        return $isValidSite;
    }

    public static function isValidType($type)
    {

        $sql = "SELECT count(*) FROM auth WHERE auth_type = :auth_type";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":auth_type", $type, PDO::PARAM_STR);
        $statement->execute();

        $isValidType = $statement->fetchColumn() > 0;

        return $isValidType;

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

        $isValidPassword = preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$", $password);

        return $isValidPassword;
    }


}
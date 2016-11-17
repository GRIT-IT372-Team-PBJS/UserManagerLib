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

        $sql = "SELECT site_id FROM sites WHERE site_name = :site_name";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":site_name", $email, PDO::PARAM_INT);
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

}
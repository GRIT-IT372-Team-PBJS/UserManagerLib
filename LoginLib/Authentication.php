<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 10:10 PM
 */

/**
 * Class Authentication (Singleton)
 *
 * This class is in charge of the sites authentication.
 * It takes care of the login and logout functions,
 * resets passwords and changes passwords and
 * keeps track of the current user. This class is a singleton
 * so that there cant be more than one current user at a time per
 * client.
 */

//Required classes for this class.
require_once "Database.php";
require_once "User.php";

class Authentication
{
    private static $instance;
    private $databaseConnection;
    private $currentUser;

    /**
     * Logs in user and sets user session and credentials for the current user.
     * Returns true if login was successful.
     * Returns false if login was unsuccessful.
     * @param $postEmail : Post data in the form of an email address.
     * @param $postPassword : Post data in the form of a password.
     * @return Boolean
     */
    public static function login($postEmail, $postPassword)
    {
        self::initializeAuthentication();

        if (!self::isLoggedIn()) {

            $result = self::fetchUserDataFromDB($postEmail);

            if (self::isPasswordValid($result, $postPassword)) {

                self::setCurrentUser($result["first_name"], $result["middle_name"], $result["last_name"], $result["email"], $result["user_id"], $result["registered_sites"], $result["auth_type"]);
                self::setUserSession($result);
                self::closeDBConnection();

                return true;

            } else {

                return false;

            }

        } else {
            return false;
        }
    }

    /**
     * Logs out user by un-setting the current user, user session, database connection and
     * setting the instance to null.
     */
    public static function logout()
    {

        if (self::isLoggedIn()) {

            self::unsetCurrentUser();
            self::unsetUserSession();
            self::closeDBConnection();
            self::$instance = null;

        }
    }

    /**
     * checks to see if a user is logged in.
     * @return Boolean
     */
    public static function isLoggedIn()
    {
        return !(self::getCurrentUser() == null);
    }

    /**
     * Returns the current User.
     * @return User
     */
    public static function getCurrentUser()
    {
        $auth = self::getInstance();
        return $auth->currentUser;
    }

    /**
     * Hashes Password and then inserts and updates the current user's password in the database.
     * @param $newPassword
     */
    public static function changePassword($newPassword)
    {
        if (self::getCurrentUser() != null) {

            self::initializeAuthentication();
            self::updatePasswordInDB($newPassword);
            self::closeDBConnection();

        }

    }

    /**
     * Updates the password in the database.
     * @param $newPassword
     */
    private static function updatePasswordInDB($newPassword)
    {
        try {

            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE tb_users SET password = :password WHERE user_id = :user_id";
            $auth = self::getInstance();
            $statement = $auth->databaseConnection->prepare($sql);
            $statement->bindParam(":password", $newPassword, PDO::PARAM_STR);
            $statement->bindParam(":user_id", self::getCurrentUser()->getUserId(), PDO::PARAM_STR);
            $statement->execute();

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }

    }

    /**
     * Fetches user data from database and returns the results.
     * @param $email
     * @return Database
     */
    private static function fetchUserDataFromDB($email)
    {
        try {

            $sql = "SELECT first_name, middle_name, last_name, email, user_id, registered_sites, auth_type, password FROM tb_users WHERE email = :email";
            $auth = self::getInstance();
            $statement = $auth->databaseConnection->prepare($sql);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    /**
     * Checks if password is valid.
     * (verifies Hashed Passwords)
     * @param $result
     * @param $password
     * @return Boolean
     */
    private static function isPasswordValid($result, $password)
    {
        if ($result->rowCount() > 0) {
            if (password_verify($password, $result["password"])) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    private static function closeDBConnection()
    {
        $db = self::getInstance();
        $db = $db::getDBConnection();
        $db::closeDBConnection();

    }

    /**
     * Returns a database connection
     * @return Database
     */
    private static function getDBConnection()
    {
        return self::databaseConnection;
    }

    /**
     * Sets the user session.
     * @param $result
     */
    private static function setUserSession($result)
    {
        $_SESSION["user_session"] = $result["user_id"];
    }

    /**
     * Un-sets the user session.
     */
    private static function unsetUserSession()
    {
        unset($_SESSION["user_session"]);
    }

    /**
     * Builds and sets the current user.
     * @param $firstName
     * @param $middleName
     * @param $lastName
     * @param $email
     * @param $userId
     * @param $registeredSites
     * @param $type
     */
    private static function setCurrentUser($firstName, $middleName, $lastName, $email, $userId, $registeredSites, $type)
    {
        $auth = self::getInstance();
        $auth->currentUser = new User($firstName, $middleName, $lastName, $email, $userId, $registeredSites, $type);
    }

    /**
     * un-sets the current user.
     */
    private static function unsetCurrentUser()
    {
        $auth = self::getInstance();
        $auth->currentUser = null;
    }

    /**
     * Gets the instance of the class.
     * (Singleton Method)
     * @return Authentication
     */
    private static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new Authentication();
        }

        return self::$instance;
    }

    /**
     * Initializes the Authentication class and also sets the database connection.
     */
    private static function initializeAuthentication()
    {
        $auth = self::getInstance();
        $auth->databaseConnection = Database::getDBConnection();

    }


}
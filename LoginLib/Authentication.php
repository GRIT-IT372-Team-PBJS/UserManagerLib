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
    private $dbConnection;

    /**
     * Logs in user and sets user session and credentials for the current user.
     * Returns true if login was successful.
     * Returns false if login was unsuccessful.
     * @param $postEmail : Post data in the form of an email address.
     * @param $postPassword : Post data in the form of a password.
     * @param $currentSite : static input used to indicate which app user is trying to login to
     * @param $authorizationType : This last parameter is optional, it allows you to set restrictions on what type of user can login.
     * @return Boolean
     */
    public static function login($postEmail, $postPassword, $currentSite)
    {
        self::initializeAuthentication();

        if (!self::isLoggedIn()) {

            $result = self::fetchUserDataFromDB($postEmail);

            $middleName = isset($result["middlename"]) ? $result["middlename"] : "";
            $firstName = isset($result["firstname"]) ? $result["firstname"] : "";
            $lastName = isset($result["lastname"]) ? $result["lastname"] : "";
            $email = isset($result["email"]) ?  $result["email"] : "";
            $userId = isset($result["user_id"]) ? $result["user_id"] : "";
            $authType = isset($result["auth_type"]) ? $result["auth_type"] : "";

            if (HelperFunctions::isRegisteredToCurrentSite($currentSite, $email)) {

                if (self::isPasswordValid($result, $postPassword)) {

                    $isAuthenticationTypePassedIn = func_num_args() > 3;

                    if(!$isAuthenticationTypePassedIn) {

                        self::setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $authType);
                        Database::closeDBConnection();

                        return true;

                    } else if(func_num_args() == 4) {

                        $authorizationType = func_get_arg(3);

                        if($authType == $authorizationType) {

                            self::setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $authType);
                            Database::closeDBConnection();

                            return true;
                        } else {
                            return false;
                        }
                    }
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

    /**
     * Fetches user data from database and returns the results.
     * @param $email : loginEmail
     * @return $results : results in the database.
     */
    private static function fetchUserDataFromDB($email)
    {
            $sql = "SELECT * FROM users WHERE email = :email";
            $auth = self::initializeAuthentication();
            $statement = $auth->dbConnection->prepare($sql);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch();

            return $result;
    }

    /**
     * Checks if password is valid.
     * (verifies Hashed Passwords)
     * @param $dbResults
     * @param $loginPassword
     * @return Boolean
     */
    private static function isPasswordValid($dbResults, $loginPassword)
    {
            if (password_verify($loginPassword, $dbResults["password"])) {

                return true;

            } else {

                return false;
            }
    }

    /**
     * Builds and sets the current user.
     * @param $firstName
     * @param $middleName
     * @param $lastName
     * @param $email
     * @param $userId
     * @param $type
     */
    private static function setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $type)
    {
        $_SESSION["auth-current-user"] = new User($firstName, $middleName, $lastName, $email, $userId, $type);
    }

    /**
     * Logs out user by un-setting the current user, user session, database connection and
     * setting the instance to null.
     * @param $redirectURL : This is an Optional parameter, Takes a string url and will redirect to that url upon logging out.
     */
    public static function logout()
    {

        if (self::isLoggedIn()) {

            self::unsetUserSession();

            if (func_num_args() == 1) {
                $redirectUrl = func_get_arg(0);
                header("Location: " . $redirectUrl);
            }

            Database::closeDBConnection();
            self::$instance = null;

        }

    }

    /**
     * checks to see if a user is logged in.
     * @return Boolean
     */
    private static function isLoggedIn()
    {
        return isset($_SESSION["auth-current-user"]);
    }

    /**
     * This method is use when you want to restrict a page to users who are not logged in.
     * @param $url : This is the location you want the user to redirect to if they are not an authorized user.
     * @param $authorizationType : This is an OPTIONAL field, only use it if you want to restrict access to specific types of users.
     */
    public static function isValidUserElseRedirectTo($url) {
        if(self::isLoggedIn()){

            $userId = $_SESSION["auth-current-user"]->getUserId();

            $sql = "SELECT count(*) FROM users WHERE user_id = :user_id";
            $auth = self::initializeAuthentication();
            $statement = $auth->dbConnection->prepare($sql);
            $statement->bindParam(":user_id", $userId, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetchColumn();

            if ($row < 1){
                header("Location: " . $url);
            }

            if (func_num_args() == 2) {

                $authorizationType = func_get_args(1);

                if ($_SESSION["auth-current-user"]->getType() == $authorizationType){
                    header("Location: " . $url);
                }

            }

        } else {
            header("Location: " . $url);
        }

    }

    /**
     * Hashes Password and then updates the current user's password in the database.
     * @param $newPassword : The new password to be put into the database.
     */
    public static function changePassword($newPassword)
    {
        if (self::isLoggedIn()){

            self::updatePasswordInDB($newPassword);
            Database::closeDBConnection();
        }
    }

    /**
     * Updates the password in the database.
     * @param $newPassword
     */
    private static function updatePasswordInDB($newPassword)
    {
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $userId = $_SESSION["auth-current-user"]->getUserId();

            $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
            $auth = self::initializeAuthentication();
            $statement = $auth->dbConnection->prepare($sql);
            $statement->bindParam(":password", $newPassword, PDO::PARAM_STR);
            $statement->bindParam(":user_id", $userId, PDO::PARAM_STR);
            $statement->execute();
    }

    /**
     * destroys session.
     */
    private static function unsetUserSession()
    {
        session_destroy();
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
        $auth->dbConnection = Database::getDBConnection();

        return $auth;
    }


}
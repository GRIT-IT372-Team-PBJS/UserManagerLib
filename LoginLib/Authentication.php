<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 10:10 PM
 */

/**
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 *
 * Class Authentication (Singleton)
 *
 * This class is in charge of the sites authentication.
 * It takes care of the login and logout functions,
 * resets passwords and changes passwords and
 * keeps track of the current user. This class is a singleton
 * so that sessions don't end up overwritten unknowingly.
 */

//Required classes for this class.
require_once "Database.php";
require_once "User.php";
require_once "HelperFunctions.php";

class Authentication
{
    private static $instance;
    private $dbConnection;

    /**
     * Logs user in by checking if data is valid and if user exists. Sets user object into a session if login was successful.
     *
     * Returns TRUE if login was successful.
     *
     * Returns FALSE if login was un-successful.
     *
     * @param string $email Email is used as a username in all applications that use this library.
     * @param string $password Password passed in from the login point.
     * @param string $currentSite This data is NOT passed in by the user. The developer sets this statically. Pass it the unique site name given to your application, if you don't know it talk to your administrator and they will either create one for you or give you the credential for your app's site name.
     * @param string $authorizationType This parameter is OPTIONAL, it allows you to set restrictions on what type of user can login. If no authorizationType is passed in then login will have no ristriction for users logging in.
     * @return Boolean
     */
    public function login($email, $password, $currentSite)
    {
        self::initializeAuthentication();

        if (!self::isLoggedIn()) {

            $result = self::fetchUserDataFromDB($email);

            if ($result != false) {

                $middleName = isset($result["middlename"]) ? $result["middlename"] : "";
                $firstName = isset($result["firstname"]) ? $result["firstname"] : "";
                $lastName = isset($result["lastname"]) ? $result["lastname"] : "";
                $userId = isset($result["user_id"]) ? $result["user_id"] : "";
                $authType = isset($result["auth_type"]) ? $result["auth_type"] : "";

                if (HelperFunctions::isRegisteredToCurrentSite($currentSite, $email)) {

                    if (self::isPasswordValid($result, $password)) {

                        $isAuthenticationTypePassedIn = func_num_args() > 3;

                        if (!$isAuthenticationTypePassedIn) {

                            self::setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $authType);
                            Database::closeDBConnection();

                            return true;
                        }

                        if ($isAuthenticationTypePassedIn) {

                            $authorizationType = func_get_arg(3);

                            if ($authType == $authorizationType && HelperFunctions::isValidType($authType)) {

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

            } else {
                return false;
            }
    }

    //gets all the data associated with the email in the database. If the email is valid in
    //the database it returns the database results else returns a false boolean.
    private function fetchUserDataFromDB($email)
    {
            $sql = "SELECT * FROM users WHERE email = :email";
            $auth = self::initializeAuthentication();
            $statement = $auth->dbConnection->prepare($sql);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            //Uncomment the code below if you want to do error handling on this database call.
            //print_r($statement->errorInfo());

            $result = $isThereNoDatabaseErrors ? $statement->fetch() : false;

            return $result;
    }

    //compares loginPassword with hashedPassword and sees if they are the same.
    private function isPasswordValid($dbResults, $loginPassword)
    {
            if (password_verify($loginPassword, $dbResults["password"])) {

                return true;

            } else {

                return false;
            }
    }

   //sets the current session, the session contains a user object.
    private function setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $type)
    {
        $_SESSION["auth-current-user"] = new User($firstName, $middleName, $lastName, $email, $userId, $type);
    }

    /**
     * Logs out user by destroying all sessions, closing the database connection and
     * setting the instance of Authentication to null.
     *
     * @param string $redirectURL : This is an OPTIONAL parameter, Takes a string url and will redirect to that url upon logging out, If no parameter is passes in then logging out will not redirect you anywhere.
     */
    public function logout()
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

    //Checks if a user is logged in.
    private function isLoggedIn()
    {
        return isset($_SESSION["auth-current-user"]);
    }

    /**
     * This method is use when you want to restrict a page to users who are not logged in or users who do not have authorization to be on that page.
     *
     * @param string $url : This is the location you want the user to redirect to if they are not an authorized user.
     * @param string $authType : This is an OPTIONAL field, only use it if you want to restrict access to specific types of users.
     */
    public function isValidUserElseRedirectTo($url) {
        if(self::isLoggedIn()){

            $userId = $_SESSION["auth-current-user"]->getUserId();

            $sql = "SELECT count(*) FROM users WHERE user_id = :user_id";
            $auth = self::initializeAuthentication();
            $statement = $auth->dbConnection->prepare($sql);
            $statement->bindParam(":user_id", $userId, PDO::PARAM_STR);
            $statement->execute();

            //Uncomment the code below if you want to do error handling on this database call.
            //print_r($statement->errorInfo());

            $row = $statement->fetchColumn();

            if ($row < 1){
                header("Location: " . $url);
            }

            $isAuthArgumentPassedIn = func_num_args() == 2;

            if ($isAuthArgumentPassedIn) {

                $authType = func_get_args(1);

                if(HelperFunctions::isValidType($authType)){

                    if ($_SESSION["auth-current-user"]->getType() != $authType){
                        header("Location: " . $url);
                    }
                }

            }

        } else {
            header("Location: " . $url);
        }

    }

    /**
     * Updates the current user's password in the database. If the user is logged in and
     * The new password is valid, the password is changed.
     * NOTE: Password has to be at least 8 characters long, contain at least 1 uppercase letter and 1 lowercase letter and 1 digit.
     *
     * Returns TRUE if change was successful.
     *
     * Returns FALSE if change was unsuccessful.
     *
     * @param string $newPassword : The new password to be put into the database.
     * @return Boolean
     */
    public function changePassword($newPassword)
    {
        if (self::isLoggedIn() && HelperFunctions::isPasswordValid($newPassword)){

            if (self::updatePasswordInDB($newPassword)) {
                Database::closeDBConnection();

                return true;
            } else {
                return false;
            }

        } else {

            return false;
        }
    }

    //updates password in database, returns true if update was successful returns false if update was unsuccessful.
    private function updatePasswordInDB($newPassword)
    {
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $userId = $_SESSION["auth-current-user"]->getUserId();

            $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
            $auth = self::initializeAuthentication();
            $statement = $auth->dbConnection->prepare($sql);
            $statement->bindParam(":password", $newPassword, PDO::PARAM_STR);
            $statement->bindParam(":user_id", $userId, PDO::PARAM_STR);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            //Uncomment the code below if you want to do error handling on this database call.
            //print_r($statement->errorInfo());

            return $isThereNoDatabaseErrors;
    }

    //destroys all sessions
    private function unsetUserSession()
    {
        session_destroy();
    }

   //gets instance of the Authentication class
    private function getInstance()
    {
        if (self::$instance == null) {

            self::$instance = new Authentication();
        }

        return self::$instance;
    }

    //Initializes the Authentication class and also sets the database connection.
    private function initializeAuthentication()
    {
        $auth = self::getInstance();
        $auth->dbConnection = Database::getDBConnection();

        return $auth;
    }

    /**
     * Resets the password with a generated password and emails the new password to the user. The user is then expected to log in and use the change password feature.
     *
     * Returns TRUE if user has an account.
     *
     * Returns FALSE if user does NOT have an account.
     *
     * @param string $email : the email address of the user who forgot their password.
     * @return Boolean
     */
    public function forgotPassword($email){

        if (HelperFunctions::isUserInDB($email)) {

            $generatedPass = self::generate_password();
            self::insertGeneratedPasswordIntoDB($generatedPass, $email);

            $to      = $email;
            $subject = 'Password Reset - Green River Tech';
            $message = 'Hi GR Student,' . "\r\n"
                . "\r\n" . "You have submitted a password change request. Here is your new password: " . "\r\n" . "\r\n" . $generatedPass . "\r\n" . "\r\n" . "Login with this password and change the password to anything you would like.";
            $headers = 'From: noreply@greenrivertech.net' . "\r\n" .
                'Reply-To: noreply@greenrivertech.net' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            return true;
        } else {
            return false;
        }
    }

    //inserts newly generated password replacing the users old password.
    private function insertGeneratedPasswordIntoDB($generatedPass, $email) {

        $generatedPass = password_hash($generatedPass, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $auth = self::initializeAuthentication();
        $statement = $auth->dbConnection->prepare($sql);
        $statement->bindParam(":password", $generatedPass, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());
    }

    //Generates a random password of length 10.
    private function generate_password($length = 10){

        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i=0; $i < $length; $i++)
            $str .= $chars[random_int(0, $max)];

        return $str;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 10:10 PM
 */

//Required classes for this class.
require_once "Database.php";
require_once "User.php";
require_once "HelperFunctions.php";
require_once "RunsSQL.php";

/**
 * Class Authentication
 *
 * This class is in charge of the sites authentication.
 * It takes care of the login and logout functions,
 * resets passwords, changes passwords and
 * has a forgot password method.
 *
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 */
class Authentication extends RunsSQL
{
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
     * @param string $requiredAuthType This parameter is OPTIONAL, it allows you to set restrictions on what type of user can login. If no requiredAuthType is passed in then the login will have no restriction for users logging in.
     * @return Boolean
     */
    public static function login($email, $password, $currentSite)
    {

        if (!HelperFunctions::isLoggedIn()) {


            $result = self::fetchUserDataFromDB($email);

            //checks if the DB query didn't fail while running the sql.
            if ($result != false) {

                $middleName = isset($result["middlename"]) ? $result["middlename"] : "";
                $firstName = isset($result["firstname"]) ? $result["firstname"] : "";
                $lastName = isset($result["lastname"]) ? $result["lastname"] : "";
                $userId = isset($result["user_id"]) ? $result["user_id"] : "";
                $usersAuthType = isset($result["auth_type"]) ? $result["auth_type"] : "";
                $hashedPassword = isset($result["password"]) ? $result["password"] : "";

                if (HelperFunctions::isRegisteredToCurrentSite($currentSite, $email)) {

                    if (password_verify($password, $hashedPassword)) {

                        $isAuthParamPassedIn = func_num_args() > 3;

                        if (!$isAuthParamPassedIn) {

                            self::setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $usersAuthType);
                            Database::closeDBConnection();

                                //returns true if session is set correctly else returns false.
                                return $_SESSION["auth-current-user"] instanceof User;
                        }

                        if ($isAuthParamPassedIn) {

                            $requiredAuthType = func_get_arg(3);

                            if ($usersAuthType == $requiredAuthType && HelperFunctions::isValidAuthType($usersAuthType)) {

                                self::setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $usersAuthType);
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
    private static function fetchUserDataFromDB($email)
    {

            $sql = "SELECT * FROM users WHERE email = " . parent::PREPARED_STATEMENT_1;

            return parent::runSQLWithOneClause($sql, $email, true);
    }

   //sets the current session, the session contains a user object.
    private static function setCurrentUserSession($firstName, $middleName, $lastName, $email, $userId, $type)
    {
        $_SESSION["auth-current-user"] = new User($firstName, $lastName, $middleName, $email, $userId, $type);
    }

    /**
     * Logs out user by destroying all sessions and closing the database connection.
     *
     * @param string $redirectURL This is an OPTIONAL parameter, Takes a string url and will redirect to that url upon logging out, If no parameter is passes in then logging out will not redirect you anywhere.
     */
    public static function logout()
    {

        if (HelperFunctions::isLoggedIn()) {

            self::unsetUserSession();

            $isParamPassedIn = func_num_args() == 1;

            if ($isParamPassedIn) {
                $redirectUrl = func_get_arg(0);
                header("Location: " . $redirectUrl);
            }

            Database::closeDBConnection();

        }

    }


    /**
     * This method is use when you want to restrict a page to users who are not logged in or users who do not have authorization to be on that page.
     *
     * @param string $url This is the location you want the user to redirect to if they are not an authorized user.
     * @param string $requiredAuthType This is an OPTIONAL field, only use it if you want to restrict access to specific types of users. This field is set by the developer.
     */
    public static function isValidUserElseRedirectTo($url) {
        if(HelperFunctions::isLoggedIn()){

            $userId = $_SESSION["auth-current-user"]->getUserId();

            $sql = "SELECT count(*) FROM users WHERE user_id = " . parent::PREPARED_STATEMENT_1;

            $row = parent::runSQLGetRowCountForOneClause($sql, $userId);

            if ($row == false && $row < 1){
                header("Location: " . $url);
            }

            $isAuthArgPassedIn = func_num_args() == 2;

            if ($isAuthArgPassedIn) {

                $requiredAuthType = func_get_args(1);

                if(HelperFunctions::isValidAuthType($requiredAuthType)){

                    if ($_SESSION["auth-current-user"]->getType() != $requiredAuthType){
                        header("Location: " . $url);
                    }
                }

            }

        } else {
            header("Location: " . $url);
        }

    }

    /**
     * Updates the current user's password in the database. If the user is logged in and if the current password is verified and
     * The new password is valid, the password is changed.
     * NOTE: Password has to be at least 8 characters long, contain at least 1 uppercase letter and 1 lowercase letter and 1 digit.
     *
     * Returns TRUE if change was successful.
     *
     * Returns FALSE if change was unsuccessful.
     *
     * @param string $currentPassword The current password.
     * @param string $newPassword The new password.
     * @return Boolean
     */
    public static function changePassword($currentPassword, $newPassword)
    {
        if (HelperFunctions::isLoggedIn() && HelperFunctions::isPasswordValid($newPassword)){

            $result = self::fetchUserDataFromDB($_SESSION["auth-current-user"]->getEmail());

            //checks if the DB query didn't fail while running the sql.
            if ($result != false) {

                if (password_verify($currentPassword, $result["password"])) {

                    //checks if the DB query didn't fail while running the sql.
                    if (self::updatePasswordInDB($newPassword)) {

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
    }

    //updates password in database, returns true if update was successful returns false if update was unsuccessful.
    private static function updatePasswordInDB($newPassword)
    {
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $userId = $_SESSION["auth-current-user"]->getUserId();

            $sql = "UPDATE users SET password = " . parent::PREPARED_STATEMENT_1 . " WHERE user_id = " . parent::PREPARED_STATEMENT_2;

            return parent::runSQLWithTwoClauses($sql, $newPassword, $userId, false);
    }

    //destroys all sessions
    private static function unsetUserSession()
    {
        session_destroy();
    }

    /**
     * Resets the password with a generated password and emails the new password to the user. The user is then expected to log in and use the change password feature.
     *
     * Returns TRUE if user has an account.
     *
     * Returns FALSE if user does NOT have an account.
     *
     * @param string $email the email address of the user who forgot their password.
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

        $sql = "UPDATE users SET password = " . parent::PREPARED_STATEMENT_1 . " WHERE email = " . parent::PREPARED_STATEMENT_2;

        return self::runSQLWithTwoClauses($sql, $generatedPass, $email, false);
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
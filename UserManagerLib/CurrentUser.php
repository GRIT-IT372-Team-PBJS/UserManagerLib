<?php

require_once "Database.php";
require_once "User.php";
require_once "HelperFunctions.php";
require_once "RunsSQL.php";

class CurrentUser extends RunsSQL
{

    /**
     * This class edits the first name field in the database.
     * Returns True if the method was successful.
     * Returns False if the method was unsuccessful.
     * @param $newFirstName : String input
     * @return Boolean
     */
    public static function editFirstName($newFirstName)
    {

        if (HelperFunctions::isLoggedIn() && HelperFunctions::isValidName($newFirstName, 2)) {
            $sql = "UPDATE users SET firstname = " . parent::PREPARED_STATEMENT_1 . " WHERE user_id = " . parent::PREPARED_STATEMENT_2;

            self::resetSession($newFirstName, "first-name");

            return parent::runSQLWithTwoClauses($sql, $newFirstName,  $_SESSION["auth-current-user"]->getUserId(), false);

        } else {
            return false;
        }
    }

    /**
     * This method edits the last name field in the database.
     * Returns True if the method was successful.
     * Returns False if the method was unsuccessful.
     * @param $newLastName : String input
     * @return Boolean
     */
    public static function editLastName($newLastName)
    {

        if (HelperFunctions::isValidName($newLastName, 2)) {
            $sql = "UPDATE users SET lastname = " . parent::PREPARED_STATEMENT_1 . " WHERE user_id = " . parent::PREPARED_STATEMENT_2;

            self::resetSession($newLastName, "last-name");

            return parent::runSQLWithTwoClauses($sql, $newLastName, $_SESSION["auth-current-user"]->getUserId(), false);

        } else {
            return false;
        }
    }

    /**
     * This method edits the middle name field in the db.
     * Returns True if the method was successful.
     * Returns False if the method was unsuccessful.
     * @param $newMiddleName : String
     * @return Boolean
     */
    public static function editMiddleName($newMiddleName)
    {

        if (HelperFunctions::isValidMiddleName($newMiddleName)) {
            $sql = "UPDATE users SET middlename = " . parent::PREPARED_STATEMENT_1 . " WHERE user_id = " . parent::PREPARED_STATEMENT_2;

            self::resetSession($newMiddleName, "middle-name");

            return parent::runSQLWithTwoClauses($sql, $newMiddleName, $_SESSION["auth-current-user"]->getUserId(), false);
        } else {
            return false;
        }
    }

    /**
     * This method edits the email field in the database.
     * Returns True if the method was successful.
     * Returns False if the method was unsuccessful.
     * @param $newEmail : String
     * @return Boolean
     */
    public static function editEmail($newEmail)
    {

        if (HelperFunctions::isValidEmail($newEmail)) {
            $sql = "UPDATE users SET email = " . parent::PREPARED_STATEMENT_1 . " WHERE user_id = " . parent::PREPARED_STATEMENT_2;

            self::resetSession($newEmail, "email");

            return parent::runSQLWithTwoClauses($sql, $newEmail, $_SESSION["auth-current-user"]->getUserId(), false);
        } else {
            return false;
        }
    }

    private static function resetSession($newData, $type){

        $firstName = $_SESSION["auth-current-user"]->getFirstName();
        $middleName = $_SESSION["auth-current-user"]->getMiddleName();
        $lastName = $_SESSION["auth-current-user"]->getLastName();
        $email = $_SESSION["auth-current-user"]->getEmail();
        $userId = $_SESSION["auth-current-user"]->getUserId();

        switch ($type) {
            case "first-name":
                $firstName = $newData;
                break;
            case "middle-name":
                $middleName = $newData;
                break;
            case "last-name":
                $lastName = $newData;
                break;
            case "email":
                $email = $newData;
                break;
        }


        $_SESSION["auth-current-user"] = new User($firstName, $lastName, $middleName, $email, $userId, $type);
    }

}

?>

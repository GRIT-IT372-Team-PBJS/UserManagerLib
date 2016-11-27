<?php

require_once 'Database.php';
require_once 'User.php';
require_once "HelperFunctions.php";
require_once "Registration.php";
require_once "RunsSQL.php";

/**
 * Created by PhpStorm.
 * User: Benjamin Arnold
 * Date: 11/11/2016
 * Time: 2:53 PM
 */

/**
 * Class Administration
 *
 * This class provides administration functions for admin users to apply CRUD functions on all users. All methods in this class require you to be logged in and of at least an admin level user.
 *
 * @author Benjamin Arnold <benji.arnold@gmail.com>
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 */
class Administration extends RunsSQL
{

    public static function createUser($firstName, $middleName, $lastName, $email, $site, $password, $authType = "REGULAR")
    {
        if (HelperFunctions::isLoggedIn() && HelperFunctions::isUserAuthorized(1)) {
            return Registration::registerNewUser($firstName, $middleName, $lastName, $email, $site, $password, $authType);
        } else {
            return false;
        }
    }


    public static function editUserType($email, $authType)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "UPDATE users SET auth_type = " . parent::PREPARED_STATEMENT_1 . " WHERE email = " . parent::PREPARED_STATEMENT_2;
            $execution = parent::runSQLWithTwoClauses($sql, $email, $authType, false);

            if ($execution != false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Adds website registration to user
     */
    public static function editUserAddRegistrationTo($userId, $websiteId)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "INSERT INTO user_site_xref (user_id, site_id) VALUES (" . parent::PREPARED_STATEMENT_1 . ", " . parent::PREPARED_STATEMENT_2 . ");";
            $execution = parent::runSQLWithTwoClauses($sql, $userId, $websiteId, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Removes website registration from user
     * @param $userId
     * @param $websiteId
     */
    public static function editUserRemoveRegistrationFrom($userId, $websiteId)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "DELETE FROM user_site_xref WHERE user_id = " . parent::PREPARED_STATEMENT_1 . " AND site_id = " . parent::PREPARED_STATEMENT_2;
            $execution = parent::runSQLWithTwoClauses($sql, $userId, $websiteId, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select lastname, firstname, middlename, email from user with user_id
     * @param $userId
     */
    public static function getUserWithID($userId)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT lastname, firstname, middlename, email  FROM users WHERE " .
                "user_id = " . parent::PREPARED_STATEMENT_1 . " ORDER BY lastname";
            $execution = parent::runSQLWithOneClause($sql, $userId, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select lastname, firstname, middlename, user_id from user with email
     * @param $userEmail
     */
    public static function getUserWithEmail($userEmail)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT lastname, firstname, middlename, user_id FROM users WHERE " .
                "email = " . parent::PREPARED_STATEMENT_1 . " ORDER BY lastname";
            $execution = parent::runSQLWithOneClause($sql, $userEmail, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select lastname, firstname, middlename, email, user_id from user with passed firstname and lastname
     * @param $userFirstName
     * @param $userLastName
     */
    public static function getUsersWithFirstAndLastName($userFirstName, $userLastName)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT lastname, firstname, middlename, email, user_id FROM users WHERE " .
                " firstname = " . parent::PREPARED_STATEMENT_1 . " AND lastname = " . parent::PREPARED_STATEMENT_2 . " ORDER BY lastname";
            $execution = parent::runSQLWithTwoClauses($sql, $userFirstName, $userLastName, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select all users in ascending order whose first name starts with passed letter
     * @param $searchLetter
     */
    public static function getUsersByFirstNameStartingWith($searchLetter)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT firstname, middlename, lastname, email, user_id FROM users WHERE " .
                "firstname LIKE " . parent::PREPARED_STATEMENT_1 . "% ORDER BY firstname ASC";
            $execution = parent::runSQLWithOneClause($sql, $searchLetter, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select all users in ascending order whose last name starts with passed letter
     * @param $searchLetter
     */
    public static function getUsersByLastNameStartingWith($searchLetter)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT lastname, firstname, middlename, email, user_id FROM users WHERE lastname LIKE " . parent::PREPARED_STATEMENT_1 . "% ORDER BY lastname ASC";
            $execution = parent::runSQLWithOneClause($sql, $searchLetter, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select all users who are registered to the passed website name
     * @param $currentWebsite
     */
    public static function getUsersRegisteredToThisSite($currentWebsite)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT users.lastname, users.firstname, users.middlename, users.email, users.user_id FROM " .
                "users INNER JOIN users ON users.user_id = user_site_xref.user_id INNER JOIN sites ON " .
                "sites.site_id = user_site_xref.site_id WHERE site.site_name = " . parent::PREPARED_STATEMENT_1 . " ORDER BY lastname";
            $execution = parent::runSQLWithOneClause($sql, $currentWebsite, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Select all users with passed type.  Unused, field not present in database
     * @param $userType
     */
    public static function getUsersWithType($userType)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT users.lastname, users.firstname, users.middlename, users.email, users.user_id FROM " .
                "users INNER JOIN users ON users.user_id = user_auth_xref.user_id INNER JOIN auth ON " .
                "auth.auth_type = user_auth_xref.auth_type WHERE auth.auth_type = " . parent::PREPARED_STATEMENT_1 . " ORDER BY lastname";

            $execution = parent::runSQLWithOneClause($sql, $userType, true);

            if ($execution != false) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get a list of all websites and their associated ids
     */
    public static function getWebsites()
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT * FROM sites";
            $execution = parent::runSQLWithNoClause($sql, true);

            if ($execution != false ) {
                return $execution;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Deletes user with passed user id
     * @param $userId
     */
    public static function deleteUserById($userId)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "DELETE FROM users WHERE user_id = " . parent::PREPARED_STATEMENT_1 . "";
            $execution = parent::runSQLWithOneClause($sql, $userId, false);

            if ($execution != false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public static function addNewAuthType($newAuthType, $rankAssociated)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $isAuthTypeUnique = !HelperFunctions::isValidAuthType($newAuthType);
            $isCharsAllUpperCase = ctype_upper($newAuthType);
            $isRankAnInt = ctype_digit($rankAssociated);

            if ($isAuthTypeUnique && $isCharsAllUpperCase && $isRankAnInt && HelperFunctions::isUserAuthorized(0) && $rankAssociated > 1 && !HelperFunctions::isAuthRankValueAlreadyInUse($rankAssociated)) {

                $sql = "INSERT INTO auth (auth_type, auth_rank) values( " . parent::PREPARED_STATEMENT_1 . ", " . parent::PREPARED_STATEMENT_2 . ");";

                $execution = parent::runSQLWithTwoClauses($sql, $newAuthType, $rankAssociated, false);

                if ($execution != false) {
                    return true;
                } else {
                    return false;
                }

            }

        }
    }

    public static function deleteAuthType($authType)
    {
        if (HelperFunctions::isUserAuthorized(0)) {
            if ($authType != "SUPER_ADMIN" || $authType != "ADMIN") {

                $sql = "DELETE FROM auth_user_xref WHERE auth_type = " . parent::PREPARED_STATEMENT_1;
                $execution1 = parent::runSQLWithOneClause($sql, $authType, false);

                $sql = "DELETE FROM auth WHERE auth_type = " . parent::PREPARED_STATEMENT_1;
                $execution2 = parent::runSQLWithOneClause($sql, $authType, false);

                if ($execution1 != false && $execution2 != false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public static function deleteSite($siteName)
    {
        if (HelperFunctions::isUserAuthorized(1)) {

            $sql = "DELETE FROM user_site_xref WHERE site_name = " . parent::PREPARED_STATEMENT_1;
            $execution1 = parent::runSQLWithOneClause($sql, $siteName, false);

            $sql = "DELETE FROM sites WHERE site_name = " . parent::PREPARED_STATEMENT_1;
            $execution1 = parent::runSQLWithOneClause($sql, $siteName, false);

            if ($execution1 != false && $execution2 != false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}


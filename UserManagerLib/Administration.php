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

    /**
     * Creates a user profile in the database, does NOT assign authentication or websites registered
     * @param $firstName
     * @param $middleName
     * @param $lastName
     * @param $email
     * @param $site
     * @param $password
     * @return bool
     */
    public static function createUser($firstName, $middleName, $lastName, $email, $site, $password)
    {
        if (HelperFunctions::isLoggedIn() && HelperFunctions::isUserAuthorized(1)) {
            return Registration::registerNewUser($firstName, $middleName, $lastName, $email, $site, $password);
        } else {
            return false;
        }
    }


    /**
     * Edits user authentication based on current website.  Returns false if unauthorized.
     * @param $email
     * @param $authType
     * @return bool
     */
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
     * Adds website registration and their related authentication to a user.  Returns false if unauthorized.
     * @param $userId
     * @param $websiteId
     * @param $userAuth
     * @return bool
     */
    public static function editUserAddRegistrationTo($userId, $websiteId, $userAuth)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "INSERT INTO user_site_auth (user_id, site_id) VALUES (" . parent::PREPARED_STATEMENT_1 . ", " . parent::PREPARED_STATEMENT_2 . ", " . parent::PREPARED_STATEMENT_3 . ");";
            $execution = parent::runSQLWithThreeClauses($sql, $userId, $websiteId, $userAuth, true);

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
     * Removes website registration from user.  Returns false if unauthorized.
     * @param $userId
     * @param $websiteId
     * @return bool
     */
    public static function editUserRemoveRegistrationFrom($userId, $websiteId)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "DELETE FROM user_site_auth WHERE user_id = " . parent::PREPARED_STATEMENT_1 . " AND site_id = " . parent::PREPARED_STATEMENT_2;
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
     * Select lastname, firstname, middlename, email from user with user_id.  Returns false if unauthorized.
     * @param $userId
     * @return bool
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
     * Select lastname, firstname, middlename, user_id from user with email.  Returns false if unauthorized.
     * @param $userEmail
     * @return bool
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
     * Select lastname, firstname, middlename, email, user_id from user with passed firstname and lastname.  Returns false if unauthorized.
     * @param $userFirstName
     * @param $userLastName
     * @return bool
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
     * Select all users in ascending order whose first name starts with passed letter.  Returns false if unauthorized.
     * @param $searchLetter
     * @return bool
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
     * Select all users in ascending order whose last name starts with passed letter.  Returns false if unauthorized.
     * @param $searchLetter
     * @return bool
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
     * Select all users who are registered to the passed website name.  Returns false if unauthorized.
     * @param $currentWebsite
     * @return bool
     */
    public static function getUsersRegisteredToThisSite($currentWebsite)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT users.lastname, users.firstname, users.middlename, users.email, users.user_id, user_site_auth.user_auth FROM " .
                "users INNER JOIN users ON users.user_id = user_site_auth.user_id INNER JOIN sites ON " .
                "sites.site_id = user_site_auth.site_id WHERE site.site_name = " . parent::PREPARED_STATEMENT_1 . " ORDER BY lastname";
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
     * Select all users with passed type.  Returns false if unauthorized.
     * @param $userType
     * @return bool
     */
    public static function getUsersWithType($userType)
    {
        if (HelperFunctions::isUserAuthorized(1)) {
            $sql = "SELECT users.lastname, users.firstname, users.middlename, users.email, users.user_id FROM " .
                "users INNER JOIN users ON users.user_id = user_site_auth.user_id INNER JOIN auth ON " .
                "auth.auth_type = user_site_auth.user_auth WHERE auth.auth_type = " . parent::PREPARED_STATEMENT_1 . " ORDER BY lastname";

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
     * Get a list of all websites and their associated ids.  Returns false if unauthorized.
     * @return bool
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
     * Deletes user with passed user id.  Returns false if unauthorized.
     * @param $userId
     * @return bool
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

    /**
     * Adds a new authentication type with related numerical rank (0 = regular user, 10 = super admin).  Returns false if unauthorized.
     * @param $newAuthType
     * @param $rankAssociated
     * @return bool
     */
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

    /**
     * Deletes selected authentication type.  Returns false if unauthorized.
     * @param $authType
     * @return bool
     */
    public static function deleteAuthType($authType)
    {
        if (HelperFunctions::isUserAuthorized(0)) {
            if ($authType != "SUPER_ADMIN" || $authType != "ADMIN") {

                $sql = "DELETE FROM user_site_auth WHERE user_auth = " . parent::PREPARED_STATEMENT_1;
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

    /**
     * Deletes site name.  Returns false if unauthorized.
     * @param $siteName
     * @return bool
     */
    public static function deleteSite($siteName)
    {
        if (HelperFunctions::isUserAuthorized(1)) {

            $sql = "DELETE FROM user_site_auth WHERE site_name = " . parent::PREPARED_STATEMENT_1;
            $execution1 = parent::runSQLWithOneClause($sql, $siteName, false);

            $sql = "DELETE FROM sites WHERE site_name = " . parent::PREPARED_STATEMENT_1;
            $execution2 = parent::runSQLWithOneClause($sql, $siteName, false);

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


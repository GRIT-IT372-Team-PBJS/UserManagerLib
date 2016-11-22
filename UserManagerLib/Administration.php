<?php

require_once 'Database.php';
require_once 'Authentication.php';
require_once 'User.php';
require_once 'EditCurrentUserInfo.php';

/**
 * Created by PhpStorm.
 * User: Benjamin Arnold
 * Date: 11/11/2016
 * Time: 2:53 PM
 */
class Administration extends EditCurrentUserInfo {

    //Apparently required to run queries?

    private $currentUser;

    /**
     * AdminFunctions constructor.  Apparently required?
     */
    public function __construct(){

        if(HelperFunctions::isLoggedIn()) {
            $_SESSION["auth-current-user"] = Authentication::getCurrentUser();
        }

    }

    /**
     * Creates User from UserObject I presume?
     */
    public function createUser() {

        //creates user
    }

    /**
     * Edits user type.  Unused, field not present in database
     */
    public function editUserType() {

        //edits user type
    }

    /**
     * Adds website registration to user
     */
    public function editUserAddRegistrationTo($userId, $websiteId) {

        $sql = "INSERT INTO user_site_xref (user_id, site_id) VALUES ($userId, $websiteId);";
        $this->getDataWithTwoClauses($sql, $userId, $websiteId);
    }

    /**
     * Removes website registration from user
     * @param $userId
     * @param $websiteId
     */
    public function editUserRemoveRegistrationFrom($userId, $websiteId) {

        $sql = "DELETE FROM user_site_xref WHERE user_id = $userId AND site_id = $websiteId;";
        $this->getDataWithTwoClauses($sql, $userId, $websiteId);
    }

    /**
     * Select lastname, firstname, middlename, email from user with user_id
     * @param $userId
     */
    public function getUserWithID($userId) {

        $sql = "SELECT lastname, firstname, middlename, email  FROM users WHERE " .
            "user_id = $userId ORDER BY lastname";
        $this->getDataWithOneClause($sql, $userId);
    }

    /**
     * Select lastname, firstname, middlename, user_id from user with email
     * @param $userEmail
     */
    public function getUserWithEmail($userEmail) {

        $sql = "SELECT lastname, firstname, middlename, user_id FROM users WHERE " .
            "email = $userEmail ORDER BY lastname";
        $this->getDataWithOneClause($sql, $userEmail);
    }

    /**
     * Select lastname, firstname, middlename, email, user_id from user with passed firstname and lastname
     * @param $userFirstName
     * @param $userLastName
     */
    public function getUsersWithFirstAndLastName($userFirstName, $userLastName) {

        $sql = "SELECT lastname, firstname, middlename, email, user_id FROM users WHERE " .
            " firstname = $userFirstName AND lastname = $userLastName ORDER BY lastname";
        $this->getDataWithTwoClauses($sql, $userFirstName, $userLastName);
    }

    /**
     * Select all users in ascending order whose first name starts with passed letter
     * @param $searchLetter
     */
    public function getUsersByFirstNameStartingWith($searchLetter) {

        $sql = "SELECT firstname, middlename, lastname, email, user_id FROM users WHERE " .
            "firstname LIKE " . "$searchLetter" . "% ORDER BY firstname ASC";
        $this->getDataWithOneClause($sql, $searchLetter);
    }

    /**
     * Select all users in ascending order whose last name starts with passed letter
     * @param $searchLetter
     */
    public function getUsersByLastNameStartingWith($searchLetter) {

        $sql = "SELECT lastname, firstname, middlename, email, user_id FROM users WHERE lastname LIKE " .
            "$searchLetter" . "% ORDER BY lastname ASC";
        $this->getDataWithOneClause($sql, $searchLetter);
    }

    /**
     * Select all users who are registered to the passed website name
     * @param $currentWebsite
     */
    public function getUsersRegisteredToThisSite($currentWebsite) {

        $sql = "SELECT users.lastname, users.firstname, users.middlename, users.email, users.user_id FROM " .
            "users INNER JOIN users ON users.user_id = user_site_xref.user_id INNER JOIN sites ON " .
            "sites.site_id = user_site_xref.site_id WHERE site.site_name = $currentWebsite " .
            "ORDER BY lastname";
        $this->getDataWithOneClause($sql, $currentWebsite);
    }

    /**
     * Select all users with passed type.  Unused, field not present in database
     * @param $userType
     */
    public function getUsersWithType($userType) {

        //get users with type
    }

    /**
     * Get a list of all websites and their associated ids
     */
    public function getWebsites() {

        $sql = "SELECT * FROM sites";
        $this->getDataWithNoClause($sql);
    }

    /**
     * Deletes user with passed user id
     * @param $userId
     */
    public function deleteUserById($userId) {

        $sql = "DELETE FROM users WHERE user_id = $userId";
        $this->getDataWithOneClause($sql, $userId);
    }

    /**
     * Executes SQL query that has no variable clauses
     * @param $sql
     */
    private function getDataWithNoClause($sql) {

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->execute();
    }

    /**
     * Executes SQL query that has one variable clause
     * @param $sql
     * @param $whereClause
     */
    private function getDataWithOneClause($sql, $variableClause) {

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam($variableClause, PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Executes SQL query that has two variable clauses
     * @param $sql
     * @param $firstVariableClause
     * @param $secondVariableClause
     */
    private function getDataWithTwoClauses($sql, $firstVariableClause, $secondVariableClause) {

        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam($firstVariableClause, $secondVariableClause, PDO::PARAM_STR);
        $statement->execute();
    }
}


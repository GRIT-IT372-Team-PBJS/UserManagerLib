<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 3:21 PM
 */

/**
 * Class User
 *
 * This class is mainly used to handle user info so that it can store the user into a session.
 *
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 */
class User
{
    private $firstName;
    private $lastName;
    private $middleName;
    private $email;
    private $userId;
    private $authType;

    /**
     * User constructor.
     * @param string $firstName required to be at least 2 characters long
     * @param string $lastName required to be at least 2 characters long
     * @param string $middleName middle name is allowed to be an empty string.
     * @param string $email required to be a valid email
     * @param int $userId
     * @param string $type required to be a valid type found in the DB
     */
    public function __construct($firstName, $lastName, $middleName, $email, $userId, $type)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->email = $email;
        $this->userId = $userId;
        $this->authType = $type;
    }

    /**
     * Returns the FIRST name of the user.
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Returns the LAST name of the user.
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     * Returns MIDDLE name of the user.
     * @return String (can be an empty string)
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Returns EMAIL of the user.
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns USERID of the user.
     * @return Integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns TYPE of user.
     * @return string
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    public function getAuthRank() {

        $sql = "SELECT auth_rank FROM auth WHERE auth_type = :auth_type";
        $statement = Database::getDBConnection()->prepare($sql);
        $statement->bindParam(":auth_type", $this->authType(), PDO::PARAM_INT);
        $statement->execute();

        //Uncomment the code below if you want to do error handling on this database call.
        //print_r($statement->errorInfo());

        $result = $statement->fetch();

        return $result["auth_type"];

    }

    /**
     * Modified to string for error handling.
     * @return string
     */
    public function __toString()
    {
        return "<b>CLASS INFO:</b> This is a User class object use the class's getter methods to retrieve data from this object. This class contains these field values: [". $this->firstName . "], [" . $this->getMiddleName() . "], [" . $this->lastName . "], [" . $this->email . "], [" . $this->authType . "], [" . $this->userId . "]";
    }


}
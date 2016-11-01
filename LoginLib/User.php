<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 3:21 PM
 */
class User
{
    private $firstName;
    private $lastName;
    private $middleName;
    private $email;
    private $userId;
    private $registeredSites;
    private $type;

    /**
     * User constructor.
     * @param $firstName : Type is String
     * @param $lastName : Type is String
     * @param $middleName : Type is String
     * @param $email : Type is String
     * @param $userId : Type is integer
     * @param $registeredSites : Type is array
     * @param $type : Type is AuthType(Enum)
     */
    public function __construct($firstName, $lastName, $middleName, $email, $userId, $registeredSites, $type)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->email = $email;
        $this->userId = $userId;
        $this->registeredSites = $registeredSites;
        $this->type = $type;
    }

    /**
     * Returns the First name of the user.
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the FIRST name of the user.
     * @param String $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
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
     * Sets the LAST name of the user.
     * @param String $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
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
     * Sets MIDDLE name of the user.
     * @param String $middleName (can be an empty string)
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
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
     * Sets EMAIL of the user.
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * Returns REGISTERED SITES of user.
     * @return Array of Strings
     */
    public function getRegisteredSites()
    {
        return $this->registeredSites;
    }

    /**
     * Sets REGISTERED SITES of user.
     * @param Array of Strings $registeredSites
     */
    public function setRegisteredSites($registeredSites)
    {
        $this->registeredSites = $registeredSites;
    }

    /**
     * Returns TYPE of user.
     * @return AuthType (enum)
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Type of User.
     * @param AuthType (enum) $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}
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
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getRegisteredSites()
    {
        return $this->registeredSites;
    }

    /**
     * @param mixed $registeredSites
     */
    public function setRegisteredSites($registeredSites)
    {
        $this->registeredSites = $registeredSites;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}
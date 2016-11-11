<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 3:21 PM
 */

/**
 * Class User
 * This class is used to pass user data around and check if data is valid before it is set into the user object.
 */
class User
{
    private $firstName;
    private $lastName;
    private $middleName;
    private $email;
    private $userId;
    private $type;

    /**
     * User constructor.
     * @param $firstName : Type is String
     * @param $lastName : Type is String
     * @param $middleName : Type is String
     * @param $email : Type is String
     * @param $userId : Type is integer
     * @param $type : Type is String
     */
    public function __construct($firstName, $lastName, $middleName, $email, $userId, $type)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->email = $email;
        $this->userId = $userId;
        $this->type = $type;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * checks if name has no numeric or special characters except for -
     * @param $name
     * @return bool
     */
    public function isValidName($name)
    {
        return ctype_alpha(str_replace("-", "", $name));
    }

    /**
     * Modified to string for error handling.
     * @return string
     */
    public function __toString()
    {
        return "<b>CLASS INFO:</b> This is a User class object use the class's getter methods to retrieve data from this object. This class contains these field values: [". $this->firstName . "], [" . $this->getMiddleName() . "], [" . $this->lastName . "], [" . $this->email . "], [" . $this->type . "], [" . $this->userId . "]";
    }


}
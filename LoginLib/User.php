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
     * Returns true if set was successful (valid).
     * Returns false if set was unsuccessful (invalid).
     * @param String $firstName
     * @return Boolean
     */
    public function setFirstName($firstName)
    {
        if ($this->isValidName($firstName)) {
            $this->firstName = $firstName;
            return true;
        } else {
            return false;
        }

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
     * Returns true if set was successful (valid).
     * Returns false if set was unsuccessful (invalid).
     * @param String $lastName
     * @return Boolean
     */
    public function setLastName($lastName)
    {
        if ($this->isValidName($lastName)) {
            $this->lastName = $lastName;
            return true;
        } else {
            return false;
        }
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
     * Returns true if set was successful (valid).
     * Returns false if set was unsuccessful (invalid).
     * @param String $middleName (can be an empty string)
     * @return Boolean
     */
    public function setMiddleName($middleName)
    {
        if ($this->isValidName($middleName)) {
            $this->lastName = $middleName;
            return true;
        } else {
            return false;
        }
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
     * Checks if $email is valid
     * Returns true if set was successful (valid).
     * Returns false if set was unsuccessful (invalid).
     * @param String $email
     * @return Boolean
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        } else {
            echo "Error from User class: setRegisteredSites(\$email): your variable \$email is not an valid email.";
            return false;
        }

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
     * Checks if $registeredSites is a valid array.
     * Returns true if set was successful (valid).
     * Returns false if set was unsuccessful (invalid).
     * @param Array of Strings $registeredSites
     * @return Boolean
     */
    public function setRegisteredSites($registeredSites)
    {
        if (is_array($registeredSites)) {
            $this->registeredSites = $registeredSites;
            return true;
        } else {
            echo "Error from User class: setRegisteredSites(\$registeredSites): your variable \$registeredSites is not an array.";
            return false;
        }

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
     * Checks if AuthType is valid.
     * Returns true if set was successful (valid).
     * Returns false if set was unsuccessful (invalid).
     * @param AuthType (enum) $type
     * @return Boolean
     */
    public function setType($type)
    {
        if (AuthType::$type == $type) {
            $this->type = AuthType::$type;
            return true;
        } else {
            echo "Error from User class: setType(\$type): Your variable \$type is an invalid type.";
            return false;
        }

    }

    /**
     * checks if name has no numeric or special characters except for -
     * @param $name
     * @return bool
     */
    private function isValidName($name)
    {
        return ctype_alpha(str_replace("-", "", $name));
    }


}
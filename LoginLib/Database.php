<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 2:16 PM
 */

/**
 * This is a singleton database class. Singleton means that there
 * is only one instance of the class at all times.
 */
class Database
{
    private static $instance = null;
    private $databaseConnection;

    private static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    private static function initializeConnection()
    {

        $dbHost = "";
        $dbName = "";
        $dbUsername = "";
        $dbPassword = "";

        $db = self::getInstance();
        $db->databaseConnection = new PDO("mysql:host=" . $dbHost . "; dbname=" . $dbName . "", "" . $dbUsername . "", "" . $dbPassword . "");
        return $db;

    }

    /**
     * Gets the database connection.
     * @return a database connection.
     */
    public static function getDBConnection()
    {
        try {
            $db = self::initializeConnection();
            return $db->databaseConnection;
        } catch (Exception $ex) {
            echo "I was unable to open a connection to the database. " . $ex->getMessage();
            return null;
        }
    }

    /**
     * Closes the database connection.
     */
    public static function closeDBConnection()
    {
        $db = self::getInstance();
        $db->databaseConnection = null;
    }
}
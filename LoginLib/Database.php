<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/1/2016
 * Time: 2:16 PM
 */

/**
 * Class Database (Singleton)
 *
 * This class manages the database connection on all sites that use it
 * and make sure there is only one instance of it at all times.
 */
class Database
{
    private static $instance = null;
    private $databaseConnection;

    /**
     * Gets the database connection.
     * @return Database
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

    private static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Initializes the connection.
     * @return PDO
     */
    private static function initializeConnection()
    {
        //Set database credentials here.
        //Make sure to put the database-constant outside public and reset
        //the path if needed.
        require_once "../database-constants.php";

        $db = self::getInstance();
        $db->databaseConnection = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "", "" . DB_USER . "", "" . DB_PASS . "");
        return $db;

    }
}
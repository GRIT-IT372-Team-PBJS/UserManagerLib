<?php

require_once "Database.php";
require_once "User.php";
require_once "HelperFunctions.php";

class CurrentUser{

  /**
   * This class edits the first name field in the database.
   * Returns True if the method was successful.
   * Returns False if the method was unsuccessful.
   * @param $newFirstName : String input
   * @return Boolean
   */
public static function editFirstName($newFirstName){

  if(HelperFunctions::isValidName($newFirstName, 2)){
    $sql = "UPDATE users SET firstname = :firstname WHERE user_id = :user_id";
    $fieldToBeUpdated = ":email";
    self::updateUserData($sql, $fieldToBeUpdated, $$newFirstName);

    return true;
  }else {
    return false;
  }
}

  /**
   * This method edits the last name field in the database.
   * Returns True if the method was successful.
   * Returns False if the method was unsuccessful.
   * @param $newLastName : String input
   * @return Boolean
   */
public static function editLastName($newLastName){

  if(HelperFunctions::isValidName($newLastName, 2)){
    $sql = "UPDATE users SET lastname = :lastname WHERE user_id = :user_id";
    $fieldToBeUpdated = ":lastname";
    self::updateUserData($sql, $fieldToBeUpdated, $newLastName);

    return true;
  }else {
    return false;
  }
}

  /**
   * This method edits the middle name field in the db.
   * Returns True if the method was successful.
   * Returns False if the method was unsuccessful.
   * @param $newMiddleName : String
   * @return Boolean
   */
public static function editMiddleName($newMiddleName){

  if(HelperFunctions::isValidMiddleName($newMiddleName)){
    $sql = "UPDATE users SET middlename = :middlename WHERE user_id = :user_id";
    $fieldToBeUpdated = ":middlename";
    self::updateUserData($sql, $fieldToBeUpdated, $newMiddleName);

    return true;
  }else {
    return false;
  }
}

    /**
     * This method edits the email field in the database.
     * Returns True if the method was successful.
     * Returns False if the method was unsuccessful.
     * @param $newEmail : String
     * @return Boolean
     */
public static function editEmail($newEmail){

  if(HelperFunctions::isValidEmail($newEmail)){
    $sql = "UPDATE users SET email = :email WHERE user_id = :user_id";
    $fieldToBeUpdated = ":email";
    self::updateUserData($sql, $fieldToBeUpdated, $newEmail);

    return true;
  }else {
    return false;
  }
}

private static function updateUserData($sql, $fieldToBeUpdated, $valueOfField) {

  if (HelperFunctions::isLoggedIn()) {
    $statement = Database::getDBConnection()->prepare($sql);
    $statement->bindParam($fieldToBeUpdated, $valueOfField, PDO::PARAM_STR);
    $statement->bindParam(":user_id", $_SESSION["auth-current-user"]->getUserId, PDO::PARAM_INT);
    $statement->execute();

    //Uncomment the code below if you want to do error handling on this database call.
    //print_r($statement->errorInfo());
  }
}

}
?>

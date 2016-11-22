<?php

require_once "Database.php";
require_once "Authentication.php";
require_once "User.php";
require_once "HelperFunctions.php";

class EditCurrentUserInfo{

//Unsure of whether these are really necessary if we do use includes.
private $currentUser;

  /**
   * UserFunctions constructor.
   */
public function __construct(){

  if (isset($_SESSION["auth-current-user"])){
    $this->currentUser = $_SESSION["auth-current-user"];
  }

}

  /**
   * This class edits the first name field in the database.
   * Returns True if the method was successful.
   * Returns False if the method was unsuccessful.
   * @param $newFirstName : String input
   * @return Boolean
   */
public function editFirstName($newFirstName){

  if(HelperFunctions::isValidName($newFirstName, 2)){
    $sql = "UPDATE tb_users SET firstname = :firstname WHERE user_id = :user_id";
    $fieldToBeUpdated = ":email";
    $this->updateUserData($sql, $fieldToBeUpdated, $$newFirstName);

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
public function editLastName($newLastName){

  if(HelperFunctions::isValidName($newLastName, 2)){
    $sql = "UPDATE tb_users SET lastname = :lastname WHERE user_id = :user_id";
    $fieldToBeUpdated = ":lastname";
    $this->updateUserData($sql, $fieldToBeUpdated, $newLastName);

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
public function editMiddleName($newMiddleName){

  if(HelperFunctions::isValidMiddleName($newMiddleName)){
    $sql = "UPDATE tb_users SET middlename = :middlename WHERE user_id = :user_id";
    $fieldToBeUpdated = ":middlename";
    $this->updateUserData($sql, $fieldToBeUpdated, $newMiddleName);

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
public function editEmail($newEmail){

  if(HelperFunctions::isValidEmail($newEmail)){
    $sql = "UPDATE tb_users SET email = :email WHERE user_id = :user_id";
    $fieldToBeUpdated = ":email";
    $this->updateUserData($sql, $fieldToBeUpdated, $newEmail);

    return true;
  }else {
    return false;
  }
}

private function updateUserData($sql, $fieldToBeUpdated, $valueOfField) {

  $statement = $this->dbConnection->prepare($sql);
  $statement->bindParam($fieldToBeUpdated, $valueOfField, PDO::PARAM_STR);
  $statement->bindParam(":user_id", $this->currentUser->getUserId, PDO::PARAM_INT);
  $statement->execute();

  //Uncomment the code below if you want to do error handling on this database call.
  //print_r($statement->errorInfo());
}

}
?>

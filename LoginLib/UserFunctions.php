<?php

//TODO add include from the other classes.

class userFunctions{

//Unsure of whether these are really necessary if we do use includes.
private  var $db;
private var $currentUser;

//Added these for SQL UPDATE. May be made unnecessary further into development process.
private var $newFirstName;
private var $newLastName;
private var $newMiddleName;
private var $newEmail;

if(isset($_POST["firstName"])){
  $newFirstName = $_POST["firstName"];
}

if(isset($_POST["lastName"])){
  $newLastName = $_POST["lastName"];
}

if(isset($_POST["middleName"])){
  $newMiddleName = $_POST["middleName"];
}

if(isset($_POST["email"])){
  $newEmail = $_POST["email"];
}

//Unsure if we are using the previous user table or making a new one. Clarification from group needed.
public function editFirstName($newFirstName){
  $sql = "UPDATE tableName SET firstName = ".$newFirstName."WHERE id = ".$currentUser->id;
}

public function editLastName($newLastName){
  $sql = "UPDATE tableName SET lastName = ".$newLastName."WHERE id = ".$currentUser->id;
}

public function editMiddleName($newMiddleName){
  $sql = "UPDATE tableName SET lastName = ".$newMiddleName."WHERE id = ".$currentUser->id;
}

public function editEmail($newEmail){
  $sql = "UPDATE tableName SET lastName = ".$newEmail."WHERE id = ".$currentUser->id;
}

}


 ?>

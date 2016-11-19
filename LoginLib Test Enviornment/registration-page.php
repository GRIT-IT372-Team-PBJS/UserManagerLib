<?php

require_once "../LoginLib/Registration.php";
session_start();

$siteName = "it-connect";


if(isset($_POST["submit"])){

    echo Registration::registerUser("fnameff", "mnameff", "lnameff", "test2@gmail.com", $siteName, "Get2Work");
}





?>









<div class="row">
    <h3 class="center-align">Registration</h3>
    <form action="registration-page.php" method="post">
        <div class="card col s4 offset-s4 ">
            Email: <input type="email" name="email">
            Password: <input type="text" name="password">
            FirstName:<input type="text" name="fname">
            MiddleName:<input type="text" name="mname">
            LastName:<input type="text" name="lname">
            <input type="submit" name="submit">
        </div>
    </form>

    <a href="login-page.php">restricted site</a>
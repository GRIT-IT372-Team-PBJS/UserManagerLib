<?php
require_once "../UserManagerLib/Authentication.php";
session_start();

        $siteName = "it-connect";
        if(isset($_POST["submit"])){

           echo Authentication::login(/*"pk2@gmail.com"*/ $_POST["email"], /*"get2work"*/ $_POST["password"], $siteName) ? "True" : "False";
        }

         isset($_SESSION["auth-current-user"]) ? header("Location: test-page.php") : false;
?>

<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
<link rel="stylesheet" href="css/main.css">

<div class="container">


    <div class="row">
        <h3 class="center-align">Login</h3>
        <form action="index.php" method="post" class=" card col s4 offset-s4 ">

            Email: <input type="email" name="email">
            Password: <input type="password" name="password">
            <input class="btn col s10 offset-s1" type="submit" name="submit">
            <br>
            <br>
            <br>
        </form>

    </div>

</div>



<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>

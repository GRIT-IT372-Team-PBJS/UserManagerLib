<?php
require_once "../UserManagerLib/Registration.php";
session_start();

$siteName = "it-connect";


if (isset($_POST["submit"])) {

    $isThereNoErrors = Registration::registerNewUser($_POST["fname"], $_POST["mname"], $_POST["lname"], $_POST["email"], $siteName, $_POST["password"]);

    if ($isThereNoErrors) {
        header("Location: index.php");
    } else {

        $registrationFailMsg = "<span style=\"color: red\">Sorry registration has failed</span>";
        echo Registration::getDBErrorMsg();

    }

}

?>

<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css"/>
<link rel="stylesheet" href="css/index.css"/>


<div class="row">
    <h3 class="center-align">Registration</h3>
    <h5 class="center-align"><?php echo !empty($registrationFailMsg) ? $registrationFailMsg : ""; ?></h5>
    <form action="registration.php" method="post">
        <div class="card col s4 offset-s4 ">
            Email: <input class="text-input" type="email" name="email">
            Password: <input class="text-input" type="text" name="password">
            FirstName:<input class="text-input" type="text" name="fname">
            MiddleName:<input class="text-input" type="text" name="mname">
            LastName:<input class="text-input" type="text" name="lname">
            <input class="btn col s10 offset-s1" type="submit" name="submit">
        </div>
    </form>

</div>


<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
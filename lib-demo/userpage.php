<?php
require_once "../UserManagerLib/CurrentUser.php";
require_once "../UserManagerLib/Authentication.php";
session_start();

    Authentication::isValidUserElseRedirectTo("index.php");

if (isset($_POST["password-change"])){
    Authentication::changePassword( $_POST["old-password"] ,$_POST["new-password"]);
}

if (isset($_POST["logout"])) {

    Authentication::logout("index.php");
}

if (isset($_POST["first-name-change"])) {

    CurrentUser::editFirstName($_POST["new-first-name"]);

}

if (isset($_POST["middle-name-change"])) {

    CurrentUser::editMiddleName($_POST["new-middle-name"]);
}

if (isset($_POST["last-name-change"])) {

    CurrentUser::editLastName($_POST["new-last-name"]);
}

if (isset($_POST["email-change"])) {

    CurrentUser::editEmail($_POST["new-email"]);
}

?>
<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css"/>
<link rel="stylesheet" href="css/index.css"/>

<div class="row">

    <div class="col s10 offset-s1 form">
        <h1 class="center-align">User Access Page</h1>
    </div>

    <div class="col s10 offset-s1">

        <div class="col s8 offset-s2 form" method="post" action="">
            <h3 class="center-align">Login Verification</h3>
            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Login Verification</u></h6>
                <?php highlight_file("code-samples/login-verification.php"); ?>
            </div>

        </div>

        <form class="col s8 offset-s2 form" method="post" action="">
            <h3 class="center-align">Log Out</h3>
            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Logging Out</u></h6>
                <?php highlight_file("code-samples/logout.php"); ?>
            </div>

            <input class="btn col s8 offset-s2 red lighten-2" type="submit" name="logout" value="Logout">

        </form>

        <form class="col s8 offset-s2 form" method="post" action="">

            <h3 class="center-align">Change Password</h3>
            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Changing Password</u></h6>
                <?php highlight_file("code-samples/change-password.php"); ?>
            </div>

            <div class="col s8 offset-s2">

                <input value="Old Password:" class="text-input col s8 center-align" type="text" name="old-password">
                <input value="New Password:" class="text-input col s8 center-align" type="text" name="new-password">
                <input class="btn col s3 offset-s1 pink lighten-2" type="submit" value="Change Password"
                       name="password-change"/>
            </div>

        </form>

        <form class="col s8 offset-s2 form" method="post" action="">

            <h3 class="center-align">Edit First Name</h3>

            <h4 class="col s12 center-align" style="color: #0080CC"><?php echo $_SESSION["auth-current-user"]->getFirstName();?></h4>

            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Editing First Name</u></h6>
                <?php highlight_file("code-samples/change-firstname.php"); ?>
            </div>

            <div class="col s8 offset-s2">
                <input class="text-input col s8 center-align" type="text" name="new-first-name">
                <input class="btn col s3 offset-s1 pink lighten-2" type="submit" value="Change First"
                       name="first-name-change"/>
            </div>

        </form>

        <form class="col s8 offset-s2 form" method="post" action="">

            <h3 class="center-align">Edit Middle Name</h3>

            <h4 class="col s12 center-align" style="color: #0080CC"><?php echo $_SESSION["auth-current-user"]->getMiddleName();?></h4>

            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Editing Middle Name</u></h6>
                <?php highlight_file("code-samples/change-middlename.php"); ?>
            </div>

            <div class="col s8 offset-s2">
                <input class="text-input col s8 center-align" type="text" name="new-middle-name">
                <input class="btn col s3 offset-s1 pink lighten-2" type="submit" value="Change Middle"
                       name="middle-name-change"/>
            </div>


        </form>

        <form class="col s8 offset-s2 form" method="post" action="">

            <h3 class="center-align">Edit Last Name</h3>

            <h4 class="col s12 center-align" style="color: #0080CC"><?php echo $_SESSION["auth-current-user"]->getLastName();?></h4>

            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Editing Last Name</u></h6>
                <?php highlight_file("code-samples/change-lastname.php"); ?>
            </div>

            <div class="col s8 offset-s2">
                <input class="text-input col s8 center-align" type="text" name="new-last-name">
                <input class="btn col s3 offset-s1 pink lighten-2" type="submit" value="Change Last"
                       name="last-name-change"/>
            </div>


        </form>

        <form class="col s8 offset-s2 form" method="post" action="">

            <h3 class="center-align">Change Email</h3>

            <h4 class="col s12 center-align" style="color: #0080CC"><?php echo $_SESSION["auth-current-user"]->getEmail();?></h4>

            <div class="col s8 offset-s2 card grey lighten-3">
                <h6 class="center-align"><u>Code Sample for Changing Email</u></h6>
                <?php highlight_file("code-samples/change-email.php"); ?>
            </div>

            <div class="col s8 offset-s2">
                <input class="text-input col s8 center-align" type="text" name="new-email">
                <input class="btn col s3 offset-s1 pink lighten-2" type="submit" value="Change Email"
                       name="email-change"/>
            </div>


        </form>


    </div>


    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>


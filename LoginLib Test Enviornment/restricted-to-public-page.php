<?php
    require_once "../LoginLib/Authentication.php";
    session_start();
    $pageValidation = new Authentication();

    $pageValidation->isValidUserElseRedirectTo("login-page.php");

    if(isset($_POST["logout"])){
        echo "hello";
        Authentication::logout("login-page.php");
    }

    if(isset($_POST["submit2"])){

       Authentication::changePassword($_POST["newPassword"]);
    }

?>
HEoLLO WORLD

<form method="post" action="">

    <input type="submit" name="logout" value="Logout">
</form>

<form method="post" action="">
    <h3>Change Password</h3>

    <input type="text" name="newPassword">
    <input type="submit" name="submit2">

</form>


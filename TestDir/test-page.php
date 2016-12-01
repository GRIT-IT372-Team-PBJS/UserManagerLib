<?php
require_once "../UserManagerLib/Authentication.php";
require_once "../UserManagerLib/Administration.php";
require_once "../UserManagerLib/CurrentUser.php";
require_once "../UserManagerLib/Registration.php";
require_once "../UserManagerLib/HelperFunctions.php";
session_start();

    //If you're not logged in you are redirected to the login page.
    Authentication::isValidUserElseRedirectTo("index.php");

    if(isset($_POST["submit"])){

        $entry1 = isset($_POST["entry1"]) ? $_POST["entry1"] : "";
        $entry2 = isset($_POST["entry2"]) ? $_POST["entry2"] : "";
        $entry3 = isset($_POST["entry3"]) ? $_POST["entry3"] : "";
        $entry4 = isset($_POST["entry4"]) ? $_POST["entry4"] : "";
        $entry5 = isset($_POST["entry5"]) ? $_POST["entry5"] : "";
        $entry6 = isset($_POST["entry6"]) ? $_POST["entry6"] : "";
        $entry7 = isset($_POST["entry7"]) ? $_POST["entry7"] : "";

        //Store your test methods below these comments and pass the entries into the parameters to start tests.
        Registration::registerNewUser($entry1,$entry2,$entry3,$entry4,$entry5,$entry6,$entry7);

    }

    if(isset($_POST["logout"])){
        Authentication::logout();
    }

    function processDataIntoVisualResults($results) {

    }

    $testResults = true ? "<span style='color: green; font-weight: bold'> Test Passed </span>" : "<span style='color: red; font-weight: bold'> Test Failed </span>";
    $user = isset($_SESSION["auth-current-user"]) ? "<div class='center-align' style='color:#FF6600'> <span style='color:teal; font-weight:bold'>" . $_SESSION["auth-current-user"]->getFirstName() . " " . $_SESSION["auth-current-user"]->getMiddleName() . " " . $_SESSION["auth-current-user"]->getLastName() . "</span> Is Logged In</div> <div class='center-align' style='color:#FF6600'>This user has <span style='color:teal; font-weight:bold'>" . $_SESSION["auth-current-user"]->getAuthType() . "</span> level of authority.</div>" : "<div class='center-align' style='color: red; font-weight: bold'>No One Is Logged In</div>";
?>


<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">

<div class="container">


    <div class="row">
        <br>
        <form action="" method="post">
            <input class="center-align btn col s4 offset-s4" type="submit" name="logout" value="logout">
        </form>

        <br>
        <h2 class="center-align">Testing Form</h2>
        <?php echo $user; ?>
        <h4 class="center-align"><?php echo $testResults; ?></h4>

        <form action="" method="post" class=" card col s4 offset-s4 ">


            Entry 1: <input type="text" name="entry1">
            Entry 2: <input type="text" name="entry2">
            Entry 3: <input type="text" name="entry3">
            Entry 4: <input type="text" name="entry4">
            Entry 5: <input type="text" name="entry5">
            Entry 6: <input type="text" name="entry6">
            Entry 7: <input type="text" name="entry7">

            <p>
                <input type="checkbox" id="results" />
                <label for="results">Show results or return values below</label>
            </p>

            <input class="btn col s10 offset-s1" type="submit" name="submit">

            <br>
            <br>
            <br>
        </form>



        <?php
            echo $results = "";
        ?>
    </div>

</div>



<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
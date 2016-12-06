<?php
                    require_once "../UserManagerLib/Authentication.php";
                    session_start();

                    $siteName = "it-connect";

                    if(isset($_POST["submit"])){

                        Authentication::login($_POST["email"], $_POST["password"], $siteName);
                    }

                    $userLoggedIn = isset($_SESSION["auth-current-user"]) ? $_SESSION["auth-current-user"]->getFirstName() . ' <br><br> <div class="center-align"><a class="btn" href="userpage.php">Go To User Access Page</a></div>' : "No One Logged In";

        ?>

    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css" />
    <link rel="stylesheet" href="css/index.css" />

                <div class="row">
                    <h3 class="col s12 center-align">How To Prep A Page</h3>
                    <div class="col s4 offset-s4 card grey lighten-3">
                        <h6 class="center-align"><u>Code Sample for Page Prep</u></h6>
                        <?php highlight_file("code-samples/page-prep.php"); ?>
                    </div>

                    <h3 class="col s12 center-align">Handling the login Session</h3>
                    <div class="col s4 offset-s4 card grey lighten-3">
                        <h6 class="center-align"><u>Code Sample for The Login Session</u></h6>
                        <?php highlight_file("code-samples/login-session.php"); ?>
                    </div>

                    <h3 class="col s12 center-align">Log In</h3>
                    <h5 class="col s12 center-align"><?php echo $userLoggedIn; ?></h5>
                    <form action="index.php" method="post">

                        <div class="col s4 offset-s4 card grey lighten-3">
                            <h6 class="center-align"><u>Code Sample for Logging In</u></h6>
                            <?php highlight_file("code-samples/login.php"); ?>
                        </div>

                        <div class="card col s4 offset-s4 ">
                            Email: <input type="email" name="email" class="text-input">
                            Password: <input type="password" name="password" class="text-input">
                            <input class="btn col s10 offset-s1" type="submit" value="Login" name="submit">
                        </div>
                    </form>

                </div>

            </div>

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>


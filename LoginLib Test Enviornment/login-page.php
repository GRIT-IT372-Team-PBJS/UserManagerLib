<?php

                    require_once "../LoginLib/Authentication.php";
                    session_start();
                    $login = new Authentication;
                    $currentPassword =  password_hash("get2work", PASSWORD_DEFAULT);
                    $siteName = "it-connect";


                    if(isset($_POST["submit"])){

                        $login->login(/*"pk2@gmail.com"*/ $_POST["email"], /*"get2work"*/ $_POST["password"], $siteName);
                    }

                    echo isset($_SESSION["auth-current-user"]) ? $_SESSION["auth-current-user"]->getFirstName() : "No Data";

//        Authentication::logout();



        ?>

            <a href="restricted-to-public-page.php">restricted site</a>

            <div class="row">
                <h3 class="center-align">Login through Submit</h3>
                <form action="login-page.php" method="post">
                    <div class="card col s4 offset-s4 ">
                        Email: <input type="email" name="email">
                        Password: <input type="password" name="password">
                        <input type="submit" name="submit">
                    </div>
                </form>

            </div>

            </div>

        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>


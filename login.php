<?php

  session_start();

   if (isset($_SESSION['name'])){

       session_unset();
       session_destroy();
   }

?>

<!doctype html>
<html lang = "en">

   <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <head>
        <meta charset = "utf-8"/>
        <title>CMYK</title>


        <style>

            body{

                background-color: #CFFBFF;
                color: #956DE8;
                font-family: 'Roboto Slab', serif;

            }

            h1 {

                font-size: 50px;

            }

            a {

                color: black;
            }

            #sub {

              color: #CFFBFF;
              background-color: #956DE8;
                                font-family: 'Roboto Slab', serif;

                background-image: none;

                font-size: 20px;
            }

        </style>
    </head>

    <body>

        <br/><br/><br/><br/><br/>

       <center>
        <h1> W E L C O M E </h1>


            <p>New here? <a href = "newuser.php">Join the community!</a></p> <br/>
         <form method = "post" action = "login.php" enctype="multipart/form-data">

          Username: <input type = "text" name = "user" /><br/>
        <br/>
        Password: <input type = "password" name = "pass" />  <br/>
              <br/>
              <br/>
        <input type = "submit" value = "Enter!" id = "sub"/>



    </form>

    <?php
    require_once('backend-login.php');
    $conn = db_connect();

    if ($_POST){

        $username = $_POST['user'];
        $password= $_POST['pass'];

        $result = $conn -> query ("select * from user where username = '$username' and password ='$password'");

        if (!$result) {

            echo 'Error: problem accessing users.';

            exit;
        }

        if ($result -> num_rows ==0) {

            echo "<center>Sorry, no users with those credentials. <br/> </center>";
            exit;
        }


        $_SESSION['username'] = $_POST['user'];
        header ("Location: index.html");
    }

?>
             </center>

    </body>
</html>

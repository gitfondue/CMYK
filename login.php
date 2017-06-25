<?php

  session_start();

   if (isset($_SESSION['name'])){

       session_unset();
       session_destroy();
   }

?>

<!doctype html>
<html class="blue" lang = "en">
    <head>
        <meta charset = "utf-8"/>
        <title>CMYK</title>
        <link href="color.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Happy+Monkey" rel="stylesheet">

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
                color:#d683ef;
                text-decoration: none;
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

      <header>
        <a class="home" href="coloring.php"><img src="logo.png" width="100px" height="60px"/></a>
        <a href="browse.php">Browse</a>
        <a href="upload.php">Upload</a>
        <a href="about.html">About</a>


        <?php


              if (isset($_SESSION['name'])){

                echo "<a class='signin' href='signout.php'>Sign Out</a>";

              }

              else {


                        echo "<a class='signin' href='login.php'>Sign in</a>";              }

        ?>
      </header>



        <br/><br/>

       <center>
        <h1> W E L C O M E </h1>


            <p>New here? <a href = "new.php">Join the community!</a></p> <br/>
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
        $_SESSION['name'] = $_POST['user'];
        header ("Location: coloring.php");
    }
?>
             </center>

    </body>
</html>

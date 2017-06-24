<?php

  session_start();

   if (isset($_SESSION['name'])){

       session_unset();
       session_destroy();
   }

   require_once('backend-login.php');
   $conn = db_connect();


?>

<!Doctype html>

<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Hi there!</title>
<!--
<link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">

    <style>

        body {

            background-image: url('home.jpg');
            color: white;
            font-family: 'Josefin Slab', serif;
        }

        .main{

            background-image: url('home.jpg');

            border: 1px solid white;
        }

        a {

            color: rosybrown;
        }

    </style>
--->

</head>

<body>

        <center>
            <br/><br/>
            <div>
                <br/> <br/> <br/> <br/><br/><br/> <br/> <br/> <br/><br/> <br/>  <br/> <br/> <br/><br/>
                    <h1> w e l c o m e </h1>


            <p>New here? <a href = "newuser.php">Join the community!</a></p>
         <form method = "post" action = "memento.php" enctype="multipart/form-data">

          Username: <input type = "text" name = "user" /><br/>
        <br/>
        Password: <input type = "password" name = "pass" />  <br/>
              <br/>
              <br/>
        <input type = "submit" value = "Enter!" id = "sub"/>



    </form>
        </div>
    </center>

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
</body>

</html>

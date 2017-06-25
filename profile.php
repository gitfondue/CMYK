<?php

  session_start();
require_once('backend-login.php');
$conn = db_connect();
?>

<!DOCTYPE html>
<html class="black" lang="en">
  <head>
    <meta charset = "utf-8"/>
    <title>CMYK</title>
    <link href="color.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Happy+Monkey" rel="stylesheet">

    <style>


    .page {

      padding: 25px 50px 15px 55px;
      float: left;

    }
    </style>
  </head>
  <body>
    <header>
      <a class="home" href="coloring.php"><img src="logo.png" width="100px" height="60px"/></a>
      <a href="about.php">About</a>
      <a href="browse.php">Browse</a>
      <a href="upload.php">Upload</a>
      <a href="about.html">About</a>

      <a class="signin" href="login.html">Sign in</a>
    </header>

    <img class="head" src="header.png"/>

    <!--<p class="ask">How are you feeling?</p>-->

    <img src="designs/square.png" style="float:left;width:150px;height:150px;"/>

    <p class="profile">Lindsay</p>
    <p>Washington D.C.<br>
      Member since June 25, 2017<br>
      Favorite Color(s): Orange</p>

    <p class="ask">Submissions</p>

    <?php

        $tables=array("angry", "anxious", "happy", "sad","scared", "festive", "upset", "empty", "bored", "hopeless", "idk");
        $types = array ("complicated", "simple");
        for($i = 0; $i < count( $tables ); $i++)
    {

           $result = $conn->query("select * from $tables[$i] where uploader = 'Lindsay'");

           if (!$result){

             echo 'Something is wrong with the table';
             exit;

           }

           if ($result -> num_rows != 0){

             echo "<h1> $tables[$i] </h1>";

            while ($row = $result->fetch_object())
            {


              $title = $row -> title;
              $pic = $row -> fname;

              $image = file_get_contents("colorings/$pic");
              $source = imagecreatefromstring($image);
              $width = imagesx($source);
              $height = imagesy($source);
              $newHeight = (200/$width) * $height;

          imagedestroy($source);
          echo "<div class = 'page'><a href = 'colorings/$pic' target='_blank'><img class = 'color' src = 'colorings/$pic' width = '200px' height = '$newHeight'/></a><br/>";
                echo "<center><p class='caption'>$title</p></center></div>";

            }

            echo "</br></br></br></br></br></br></br></br></br>";

          }

          echo "</br>";

        }

    ?>

  </body>
</html>

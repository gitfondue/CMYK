<?php

  session_start();
require_once('backend-login.php');
$conn = db_connect();
?>
<!DOCTYPE html>
<html class="black" lang="en">
  <head>
    <meta charset = "utf-8"/>
    <title>CMYKj</title>
    <link href="color.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Happy+Monkey" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=IM+Fell+Great+Primer+SC" rel="stylesheet">

    <style>

.page {

  padding: 25px 50px 15px 55px;
  float: left;

}

/*.color:link{
  transition:1s;
  transform:none;
}*/

.color:hover{
 transform: scale(1.5, 1.25);
/* -moz-transform: scale(1.5, 1.25);
-ms-transform: scale(1.5, 1.25);
-webkit-transform: scale(1.5, 1.25);
-o-transform: scale(1.5, 1.25);*/
transition:0.5s;
}

    </style>
  </head>
  <body>
    <header>
      <a class="home" href="coloring.php"><img src="logo.png" width="100px" height="60px"/></a>
      <a href="browse.php">Browse</a>
      <a href="upload.php">Upload</a>

      <?php
           if (isset($_SESSION['name'])){

              echo "<a class='signin' href='signout.php'>Sign Out</a>";

           }
           else {


                     echo "<a class='signin' href='login.php'>Sign in</a>";           }

      ?>

    </header>

    <img class="head" src="header.png"/>

    <!--<p class="ask">How are you feeling?</p>-->
<?php

    $tables=array("angry", "anxious", "happy", "sad","scared", "festive", "upset", "empty", "bored", "hopeless", "idk");
    $types = array ("complicated", "simple");
    for($i = 0; $i < count( $tables ); $i++)
{

       $result = $conn->query("select * from $tables[$i]");

       if (!$result){

         echo 'Something is wrong with the table';
         exit;

       }

       if ($result -> num_rows != 0){

         echo "<h1> $tables[$i] </h1>";

        while ($row = $result->fetch_object())
        {


          $title = $row -> title;

          $by = $row -> uploader;

          $pic = $row -> fname;

          $image = file_get_contents("colorings/$pic");
          $source = imagecreatefromstring($image);
          $width = imagesx($source);
          $height = imagesy($source);
          $newHeight = (200/$width) * $height;

      imagedestroy($source);
      echo "<div class = 'page'><a href = 'colorings/$pic' target='_blank'><img class = 'color' src = 'colorings/$pic' width = '200px' height = '$newHeight'/></a><br/>";
            echo "<center class='caption'>".$title." by ".$by."</center></div>";

        }

        echo "</br></br></br></br></br></br></br>";

      }

      echo "</br>";

    }

?>
  </body>
</html>

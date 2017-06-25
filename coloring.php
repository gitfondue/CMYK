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

    <style>

.page {

  padding: 25px 50px 75px 55px;
  float: left;

}

.help {

  background-color: white;

  height: 300px;

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

        echo "<a class='signin' href='login.php'>Sign in</a>";
      }

      ?>

    </header>

    <img class="head" src="header.png"/>

    <!--<p class="ask">How are you feeling?</p>-->

    <img class="feeling" src="front-page.gif" width="400" height="400" alt="How are you feeling today?"/>

    <form method="post" action="coloring.php">
        <select name="Mood">
                <option value="sad">Sad</option>
                <option value="happy">Happy</option>
                <option value="angry">Angry</option>
                <option value="scared">Scared</option>
                <option value="anxious">Anxious</option>
                <option value="festive">Festive</option>
                <option value="upset">Upset</option>
                <option value="bored">Bored</option>
                <option value="empty">Empty</option>
                <option value="hopeless">Hopeless</option>
                <option value="idk">Idk</option>
                <option value="see_all">See All</option>
        </select>


    <p class="ask">What type of coloring page would you like?</p>

    <div class="space" method="post">
        <select name="Style">
                <option value="simple">Simple</option>
                <option value="complicated">Complicated</option>
        </select>
    </div>

    <div class="space">
        <button type="submit">Continue</button>
    </div>

  </form>

<?php

if ($_POST){

  $mood = $_POST['Mood'];
  $style = $_POST['Style'];
   if ($mood != 'see_all'){

     $result = $conn->query("select * from $mood where style = '$style'");

     if (!$result){

       echo 'Something is wrong with the table';
       exit;

     }

     if ($result -> num_rows == 0){

       echo "There are no pages with those credentials yet! Check back later!";
     }

    else {

      $numposts = $result -> num_rows;
      $dh = 200 * ($numposts / 3);

      echo "<div class = 'help' height = '400' width = 'auto'>";

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

        echo "<div class = 'page'><img src = 'colorings/$pic' width = '200px' height = '$newHeight'/><br/>";
          echo "<center>".$title." by ".$by."</center></div>";

      }

    }
  }

  else {


    $tables=array("angry", "anxious", "happy", "sad","scared", "festive", "upset", "empty", "bored", "hopeless", "idk");

    for($i = 0; $i < count( $tables ); $i++)
{


       $result = $conn->query("select * from $tables[$i] where style = '$style'");

       if (!$result){

         echo 'Something is wrong with the table';
         exit;

       }


       if ($result -> num_rows != 0){

         echo "</br><h1> $tables[$i] </h1>";

        echo "<div class = 'help'>";

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

          echo "<div class = 'page'><img src = 'colorings/$pic' width = '200px' height = '$newHeight'/><br/>";
            echo "<center>".$title." by ".$by."</center></div>";

        }

        echo "</div>";



      }

}



  }
}

?>
  </body>
</html>

<?php
session_start();
require_once("backend-login.php");
$conn = db_connect();
?>
<!DOCTYPE html>
<html class="black" lang="en">
    <head>
      <meta charset = "utf-8"/>
      <title>Coloring Page</title>
      <link href="color.css" rel="stylesheet"/>
      <link href="https://fonts.googleapis.com/css?family=Happy+Monkey" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:700" rel="stylesheet">
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

                header ("Location: login.php");


              }
              ?>
      </header>

<h1 class="ask">Choose a coloring page to upload:</h1>
<form method = "post" action = "upload.php" enctype="multipart/form-data">


    <input  type="file" name = "filename"/>

Title: <input type = "text"  name = "title">
<h1 class="ask">Add tags to describe your coloring page:</h1>
  <input type="checkbox" name = "type[]" value="happy">Happy
  <input type="checkbox" name = "type[]" value="angry">Angry
  <input type="checkbox" name = "type[]" value="scared">Scared
  <input type="checkbox" name = "type[]" value="anxious">Anxious
  <input type="checkbox" name = "type[]" value="festive">Festive<br>
  <input type="checkbox" name = "type[]" value="upset">Upset
  <input type="checkbox" name = "type[]" value="bored">Bored
  <input type="checkbox" name = "type[]" value="empty">Empty
  <input type="checkbox" name = "type[]" value="hopleless">Hopeless
  <input type="checkbox" name = "type[]" value="idk">Idk<br>
  <input type="checkbox" name = "type[]" value="check_all">Check All

<h1 class="ask">Describe the coloring page's style:</h1>
  <input type="radio" name = "style" value="simple">Simple
  <input type="radio" name = "style" value="complicated">Complicated

  <br/>
  <br/>

    <button type="submit">Submit!</button>

</form>

<img src=""/> <!--image header-->


    <?php
    if($_POST){
         $filetype = $_FILES['filename']['type'];
         $pic = $_FILES['filename']['name'];
         $types = $_POST['type'];
         $title = $_POST['title'];
         $style = $_POST['style'];
        if(empty($pic) or empty($types) or empty($filetype) or empty($style) or empty($title)){
            echo "ERROR: Need to fill all fields!!!";
            exit;
        }
        else{
                 $image = file_get_contents($_FILES['filename']['tmp_name']);
                //create a copy of the original image
                $source = imagecreatefromstring($image);
                //save and destroy
                imagejpeg($source, "colorings/".$pic);
                imagedestroy($source);
            $user = $_SESSION['name'];
            for($i = 0; $i < count($types); $i++)
            {
            $result = $conn->query("SELECT pageid FROM $types[$i] ORDER BY pageid DESC LIMIT 1");
            $idinc = 0;
            if ($result -> num_rows !=0){
              $idinc = $result->fetch_object()->pageid;
            }
            $idinc = $idinc +1;
            $result = $conn->query("insert into $types[$i] (pageid, uploader, title, fname, style) values($idinc, '".$user."','".$title."','".$pic."', '".$style."')");
            if (!$result){
              echo "error!";
              exit;
            }
          }
            echo "Page has been uploaded!";
        }
    }

    ?>

    <br/>;

    </body>

    </html>

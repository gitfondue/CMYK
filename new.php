<?php

  session_start();

    require_once('backend-login.php');
    $conn = db_connect();
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
            body {
                background-color: #B492E8;
                color: #5b829e;
                font-family: 'Roboto Slab', serif;
            }

            h1 {
                font-size: 50px;
                color: #CFFBFF;

            }

            a {
                color: white;
            }

            #sub {
                color: #CFFBFF;
                background-color: #956DE8;
                font-family: 'Roboto Slab', serif;
                background-image: none;
                font-size: 20px;
            }

            form {
                position: absolute;
                left: 30%;
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
            <h1> G R E E T I N G S</h1>

            <p style="color:#CFFBFF;">Do we know you? <a href="login.php">Login here!</a></p>
            <br/>
        </center>
        <form method="post" action="new.php" enctype="multipart/form-data">

            Username (no spaces please):
            <input type="text" name="user" />
            <br/>
            <br/> Password:
            <input type="password" name="pass" />
            <br/>
            <br/> Email:
            <input type="text" name="email" />
            <br/>
            <br/> Photo:
            <input type="file" name="filename" />
            <br/>

            <br/>

            <br/>
            <center>
                <input type="submit" value="Enter!" id="sub" />
            </center>
        </form>



        <?php

    if ($_POST){

        $user = $_POST['user'];

        $result = $conn -> query ("select * from users where userid = '$user'");

         if ($result -> num_rows !=0) {

            echo "Sorry, that username is taken.";
            exit();
        }

        if (strpos($user, " ")){

            echo "No spaces in the username!";
        }

        else {

            $pass = $_POST['pass'];
            $email = $_POST['email'];
            $photo = $_FILES['filename']['name'];
            $filetype = $_FILES['filename']['type'];


            if (!$user || !$email || !$photo || !$pass){

                echo "Please fill out all fields!";

                exit();

            }

            else {
            switch ($filetype){

                case 'image/pjjpeg': $ext = 'jpg'; break;

                     case 'image/jpeg': $ext = 'jpg'; break;

                     case 'image/gif': $ext = 'gif'; break;

                     case 'image/png': $ext = 'png'; break;


                default: $ext = 'invalid';
            }

            if ($ext == 'invalid'){


                echo "Invalid File type entered for photo";
            }

            else {

                $result = $conn -> query ( "insert into users (userid, password, email, photo) values ('$user', '$pass', '$email', '$photo')");


                if (!$result){

                    echo 'Error: problem accessing users';
                    exit;
                }

                $image = file_get_contents($_FILES['filename']['tmp_name']);

                //create a copy of the original image
                $source = imagecreatefromstring($image);
                $width = imagesx($source);
                $height = imagesy($source);

                $newHeight = (200/$width) * $height;

                //create the thumbnail
                $thumb = imagecreatetruecolor(200, $newHeight);
                imagecopyresampled($thumb, $source, 0, 0, 0, 0, 200, $newHeight, $width, $height);

                //save and destroy
                imagejpeg($thumb, "user_pics/".$photo);
                imagedestroy($thumb);
                imagedestroy($source);


                $_SESSION['username'] = $user;
            header ("Location: home.php");

            }

        }
        }

    }



    ?>
            </center>
    </body>

    </html>

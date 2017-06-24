<?php

  session_start();

    require_once('backend-login.php');
    $conn = db_connect();
?>

    <!doctype html>
    <html lang="en">

    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

    <head>
        <meta charset="utf-8" />
        <title> SUP</title>
<!--

        <style>
            body {
           background-image: url('new.jpg');
                font-family: 'Permanent Marker', cursive;

            }

            form {
                position: absolute;
                left: 40%;
            }

        </style>
      -->

    </head>

    <body>
        <center>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
      <br/>
            <br/>
            <br/>
<br/>


            <h1> G R E E T I N G S</h1>

            <p>Do we know you? <a href="login.php">Login here!</a></p>
            <br/>
        </center>
        <form method="post" action="newuser.php" enctype="multipart/form-data">

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

                <input type="submit" value="Enter!" id="sub" />
        </form>


<center>
        <?php

    if ($_POST){

        $user = $_POST['user'];

        $result = $conn -> query ("select * from user where username = '$user'");

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

                $result = $conn -> query ( "insert into user (username, password, email, photo) values ('$user', '$pass', '$email', '$photo')");


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
            header ("Location: index.html");

            }

        }
        }

    }



    ?>
            </center>
    </body>

    </html>

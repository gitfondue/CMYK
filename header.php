
<?php

    require_once('backend-login.php');
    $conn = db_connect();

?>
<head>

        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
<center><img src="newCanoe.png"></center>

<div class="nav">

    <a href="home.php"> My Feed</a>
</div>
<div class="nav">

    <a href="newpost.php"> Make a Post</a>
</div>
<div class="nav">

    <a href="searchuser.php"> Search for a User</a>
</div>

<div class="nav">

    <a href="login.php">Logout </a>
</div>


<br/> <br/> <br/> <br/> 
<div id = "about">

    <?php
    
     $name = $_SESSION['username'];
    $result =  $conn -> query ("select * from users where userid = '$name'");

        while ($row = $result ->fetch_object())
        {
        
            
            $pic = $row -> photo;
            
            $image = file_get_contents("user_pics/$pic");
            $source = imagecreatefromstring($image);
            $width = imagesx($source);
            $height = imagesy($source);
            imagedestroy ($source);
            
            echo "<br/><br/><center><img src = 'user_pics/$pic' width='$width' height = '$height'/> <br/>";
        
        }
    
   
    echo " <p>Hi there, $name </p></center>";
    ?>
</div>
    
    </body>



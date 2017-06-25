<!Doctype html>

<?php

  session_start();
?>

    <html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>YOUR FEED ON NICK OFFERMAN</title>

        <link href="style.css" type="text/css" rel="stylesheet">

    </head>

    <body>



        <?php
        
        include("header.php");

        
        $feed = $conn->query("select * from posts order by postid desc");
        
        if($feed->num_rows==0){
            echo "Sorry, no posts have been made yet.";
        }
        else{

            while($row = $feed->fetch_object()){
                $postID = $row->postid;
                        $poster = $row->userid;
                        $link = $row->linkurl;
                        $pic = $row->image;
                        $text = $row->text;
                        
                       echo "<div class='shownpost'><h3>Post #".$postID." by ".$poster."</h3>";
                if($pic!="empty"){
                    echo "<img src='post_pics/".$pic."'>";
                }
                if($link!=""){
                    echo "<a href='".$link."'>".$text."</a>";
                }
                else{
                    echo $text;
                }
                echo "</div><p></p>";
            }
        
        }
        
        ?>
    </body>

    </html>

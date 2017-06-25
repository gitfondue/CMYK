<head>
    
      <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <style>
        body{
                
                background-color: #CFFBFF;
                color: #956DE8;
                font-family: 'Roboto Slab', serif;
            
                font-size: 30px;
                
            }
    </style>
            
</head>
<?php

  session_start();

    require_once('backend-login.php');
    $conn = db_connect();

    if ($_POST){
        
        $username = $_POST['user'];
        $password= $_POST['pass'];
                
        $result = $conn -> query ("select * from users where userid = '$username' and password ='$password'");

        if (!$result) {
            
            echo 'Error: problem accessing users.';
            
            exit;
        }
        
        if ($result -> num_rows ==0) {
            
            echo "<br/><br/><br/><br/><br/><br/><br/><br/><center>Sorry, no users with those credentials. <br/> <a href = 'login.php'> Click here to login again</a></center>";
            exit;
        }
        
    
                $_SESSION['username'] = $_POST['user'];
                header ("Location: home.php");
    }
    
        else {
                    
            header ("Location: login.php");
           
        }
                
    
?>
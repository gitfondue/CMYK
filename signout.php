<?php
session_start();

 if (isset($_SESSION['name'])){

     session_unset();
     session_destroy();

     header ("Location: coloring.php");

 }


?>

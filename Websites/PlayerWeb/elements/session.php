<?php
   session_start();
   if(!isset($_SESSION['user'])){
      header("location: ../login.php");
      die();
   } else {
      if(isset($_SESSION['result'])) {
         header("location: ../results.php");
      }
   }
?>
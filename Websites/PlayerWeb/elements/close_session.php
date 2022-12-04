<?php
   session_start();
   if(isset($_SESSION['user'])){
      session_destroy();
      header("location: ../login.php");
   }
   elseif(!isset($_SESSION['user'])){
      header("location: ../login.php");
      die();
   }
?>
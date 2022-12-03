<?php
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      session_start();

      $username = $_POST['username'];
      $password = $_POST['password'];
      $team_name = $_POST['team_name'];
		
      if($username=='iutchercheurs' && $password=='no_earthquake') {
         $_SESSION['user'] = $username;
         
         header("location: ../board.php");
      } else {
         $error = "Identifiants invalides !";
         header("location: ../login.php");
      }
   }
?>
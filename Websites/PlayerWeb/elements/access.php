<?php
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      session_start();
      include "config.php";

      $username = mysqli_real_escape_string($con,$_POST['username']);
      $password = mysqli_real_escape_string($con,$_POST['password']);

      $team_name = $_POST['team_name'];
		
      $sql_query = "SELECT COUNT(*) FROM users WHERE username='".$username."' AND password='".$password."'";
      $result = mysqli_query($con, $sql_query);

      if($result > 0){
         $_SESSION['user'] = $username;
         header("location: ../board.php");
      } else {
         $error = "Identifiants invalides !";
         header("location: ../login.php");
      }
   }
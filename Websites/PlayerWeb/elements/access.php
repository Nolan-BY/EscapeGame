<?php
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      include "config.php";

      $username = mysqli_real_escape_string($con,$_POST['username']);
      $password = mysqli_real_escape_string($con,$_POST['password']);

      $team_name = $_POST['team_name'];
		
      $sql_query = "select COUNT(*) from users where username='".$username."' and password='".$password."'";
      $result = mysqli_query($con,$sql_query);
      // $row = mysqli_fetch_array($result);

      // $count = $row['cntUser'];

      if($result > 0){
         $_SESSION['user'] = $username;
         header("location: ../board.php");
      } else {
         $error = "Identifiants invalides !";
         header("location: ../login.php");
      }
   }
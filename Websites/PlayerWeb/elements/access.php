<?php
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      session_start();
      include "config.php";

      $username = mysqli_real_escape_string($con, $_POST['username']);
      $password = mysqli_real_escape_string($con, $_POST['password']);

      $_SESSION['team_name'] = $_POST['team_name'];
      mysqli_query($con,"UPDATE gamecontrol SET team_name='".$_SESSION['team_name']."' LIMIT 1");
		
      $result = mysqli_fetch_array(mysqli_query($con, "SELECT count(*) as cntUser FROM users WHERE username='".$username."' AND password='".$password."'"));

      if($result['cntUser'] > 0){
         $_SESSION['user'] = $username;
         header("location: ../board.php");
      } else {
         mysqli_query($con, "UPDATE gamecontrol SET penalties= penalties + 10 LIMIT 1");
         header("location: ../login.php");
      }
   }
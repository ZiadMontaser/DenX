<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["type"]);
   
   echo 'redirecting...';
   header('Refresh: 2; URL = login.php');
?>
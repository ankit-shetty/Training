<?php
 session_start();
 if (!isset($_SESSION['user'])) {
  header("Location: mainpage.php");
 } else if(isset($_SESSION['user']) ==1) {
  header("Location: adminpage.php");
 }
 
 if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
  session_unset();
  session_destroy();
  header("Location: mainpage.php");
  exit;
 }
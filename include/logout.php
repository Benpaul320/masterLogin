<?php
// requrie the config page containing the database connections
  require_once 'config.php';

  //if $_SESSION['username'] is isset
  if(isset($_SESSION['username'])){
    //destory all sessions
    session_destroy();
    //redirect the user back to login page
    header('Location: ../login.php');
  }
 ?>

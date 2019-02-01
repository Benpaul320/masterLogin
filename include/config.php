<?php
//error reporting turn On
error_reporting(E_ALL);
//clear buffers
ob_start();
// start the session
session_start();

//set timezone
date_default_timezone_set('Africa/Lagos');

define('DBHOST','localhost');
define('DBNAME','masterLogin');
define('DBUSERNAME','root');
define('DBPASSWORD', '');
define('DIR','http://www.domainname.com');
define('SITEEMAIL','noreply@domain.com');


try{

  //create connection using PDO
  $conn = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSERNAME, DBPASSWORD);
  //var_dump($conn);
  //set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

}catch(PDOException $e){

  //catch the errors
  echo '<p class="error-danger" style="color:#f08686;text-align:center;font-size:20px;">'.$e->getMessage().'</p>';
  #echo '<p class="error-danger" style="color:#f08686;text-align:center;font-size:20px;">Sorry, They was an error trying to connect the database. Please again later. Thank you</p>';

  exit();
}

<?php
// requrie the config page containing the database connections
require_once 'include/config.php';
if(!isset($_SESSION['username'])){ header('Location: index.php');}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Account >> Profile</title>
  </head>
  <body>
    <div class="form_wrapper">
      <div class="form_content">
<?php
  echo '<pre>Welcome '. $_SESSION['username'] . '<br/>First Name: ' . $_SESSION['firstName'] .'<br/>Last Name: ' . $_SESSION['lastName'] . '<br/><a href="include/logout.php">Log Out</a></pre>';
 ?>
</div>
</div>
  </body>
</html>

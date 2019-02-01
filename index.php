<?php
// requrie the config page containing the database connections
  require_once 'include/config.php';

  // check if a session of the username is already made if true, redirect the user to the account page
  if(isset($_SESSION['username'])){ header('Location: account.php');}

  //if the submit button is press and the username is not empty
  if(isset($_POST['submit']) && !empty($_POST['username'])){

    //Flag the following errors if the fields are empty
    if(empty($_POST['username'])) $error[] = 'Username Required';
    if(empty($_POST['firstName'])) $error[] = 'First Name is Required';
    if(empty($_POST['lastName'])) $error[] = 'Last Name is Required';
    if(empty($_POST['password'])) $error[] = 'Password is required';
    if(empty($_POST['confirm_pass'])) $error[] = 'Confirmation Password is required';

    //if not empty execute this block of code
    if(!empty($_POST['username']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['password']) && !empty($_POST['confirm_pass'])){
      /*
      * Clear the input for sql injection.
      */
      $username = filter_var(preg_replace('#[^A-Z0-9_-]#i','', trim($_POST['username'])), FILTER_SANITIZE_STRING);
      $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
      $pass_confrim = filter_var(trim($_POST['confirm_pass']), FILTER_SANITIZE_STRING);
      $firstName = filter_var(preg_replace('#[^A-Z0-9]#i','',trim($_POST['firstName'])), FILTER_SANITIZE_STRING);
      $lastName = filter_var(preg_replace('#[^A-Z0-9]#i','',trim($_POST['lastName'])), FILTER_SANITIZE_STRING);
      /*
      * ENDS HERE!!
      */
      //ip address
      $ip = filter_var(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')), FILTER_VALIDATE_IP);
      //check if both password provided by user matches each other
      if($password != $pass_confrim){
        $error[] = 'Password Must Match';
      }else{

        //hash the user password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        //prepare the insertion of new record
        $stmt = $conn->prepare('INSERT INTO account (username,user_pass,user_firstName,user_lastName,user_ip,user_lastLogin,user_createdDate) VALUES (:username,:password,:firstName,:lastName,:ip,now(),now())');
        $stmt->execute(array('username'=>$username,'password'=>$password_hash,'ip'=>$ip,'firstName'=>$firstName,'lastName'=>$lastName));
        $lastInsertId = $conn->lastInsertId();
        if($lastInsertId){
          //create user sessions
          $_SESSION['username'] = $username;
          $_SESSION['firstName'] = $firstName;
          $_SESSION['lastName'] = $lastName;
          //redirect the user to his/her account page
          header('Location: account.php');
        }else{
          $error[] = 'Sorry, they must be an error';
        }
      }

  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
    <title>Master Login</title>
  </head>
  <body>
    <div class="form_wrapper">
      <div class="form_content">
        <form class="form" action="" method="post">
          <h4>CREATE ACCOUNT</h4>
          <div class="status">
            <?php
            if(isset($error)){
              foreach ($error as $key) {
                echo '<p class="error">'.$key.'</p>';
              }
            }
             ?>
          </div>
          <label for="username">Username:</label>
          <input type="text" name="username" id="username" value="<?php if(isset($error)){ echo $_POST['username']; } ?>">
          <label for="firstName">First Name:</label>
          <input type="text" name="firstName" id="firstName" value="<?php if(isset($error)){ echo $_POST['firstName']; } ?>">
          <label for="lastName">Last Name:</label>
          <input type="text" name="lastName" id="lastName" value="<?php if(isset($error)){ echo $_POST['lastName']; } ?>">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" value="">
          <label for="confirm_pass">Confirm Password:</label>
          <input type="password" name="confirm_pass" id="confirm_pass" value="">
          <input type="submit" name="submit" value="Register">

          <center>
            <p>
              Already have an account? <a href="login.php">Login</a>
            </p>
          </center>
        </form>
      </div>
    </div>
  </body>
</html>

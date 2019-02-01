<?php
// requrie the config page containing the database connections
  require_once 'include/config.php';

  // check if a session of the username is already made if true, redirect the user to the account page
  if(isset($_SESSION['username'])){ header('Location: account.php');}

  //if the submit button is press and the username is not empty
  if(isset($_POST['submit']) && !empty($_POST['username'])){

    //Flag the following errors if the fields are empty
    if(empty($_POST['username'])) $error[] = 'Username Required';
    if(empty($_POST['password'])) $error[] = 'Password is required';

    //if not empty execute this block of code
    if(!empty($_POST['username']) && !empty($_POST['password'])){
      /*
      * Clear the input for sql injection.
      */
      $username = filter_var(preg_replace('#[^A-Z0-9_-]#i','', trim($_POST['username'])), FILTER_SANITIZE_STRING);
      $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
      /*
      * ENDS HERE!!
      */
      //ip address
      $ip = filter_var(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')), FILTER_VALIDATE_IP);

      //query to check if the username is already registered
        $stmt = $conn->prepare('SELECT count(*) FROM account WHERE username=:username LIMIT 1 ');
        $stmt->execute(array('username'=>$username));
        $record = $stmt->fetchColumn();

        //if username is found execute thi block of code
        if($record == 1){

          //fetch the user hash password
          $stt = $conn->prepare('SELECT * FROM account WHERE username=:username LIMIT 1 ');
          $stt->execute(array('username'=>$username));
          $hash = $stt->fetch(PDO::FETCH_ASSOC);

          //verify the password, if match login the user into the account
          if(password_verify($password, $hash['user_pass'])){
            //create user sessions
            $_SESSION['username'] = $username;
            $_SESSION['firstName'] = $hash['user_firstName'];
            $_SESSION['lastName'] = $hash['user_lastName'];

            //update the last login date
            $sst = $conn->prepare('UPDATE account SET user_lastLogin=now() WHERE username=:username LIMIT 1');
            $sst->execute(array('username'=>$username));

            //redirect the user to his account page
            header('Location: account.php');
          }else{
            $error[] = 'Password not Correct';
          }
        }else{
          $error[] = 'Username not found in database';
        }
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
  </head>
  <body>
    <div class="form_wrapper">
      <div class="form_content">
        <form class="form" action="" method="post">
          <h4>LOGIN</h4>
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
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" value="">
          <input type="submit" name="submit" value="Login">

          <center>
            <p>
              Don't Have? <a href="index.php">Sign Up</a>
            </p>
          </center>
        </form>
      </div>
    </div>
  </body>
</html>

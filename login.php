<?php include "base.php"?>
<!DOCTYPE html>
<html>

  <head>

    <title>Login</title>

    <meta charset=UTF-8>

    <link rel=stylesheet href=../stylesheet.css>

  </head>

  <body>

    <div class=header>
      <a href=./><img src=images/Gierki.png></a>
    </div>

    <div class=login>
      
      <?php

        $showOptions = 'all';

        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION['LoggedIn']) {
          ?>
            
            You are already logged in! You are <?php echo($_SESSION['Username']);?>.
            <br>
            <a href=index.php>Proceed to start page</a><br>

          <?php

          $showOption = 'none';

        } elseif (!empty($_POST['Username']) && !empty($_POST['Password'])) {

          $username = $_POST['Username'];
          $password = sha1($_POST['Password']);

          $stmt = $pdo->prepare('SELECT *FROM users WHERE username LIKE :username;');
          $stmt->execute(['username' => $username]);
          $userdata = $stmt->fetch();
          if (!$userdata) {
            echo('Sorry, you are not registered!<br>');
          } elseif ($userdata['username'] == $username && $userdata['password'] == $password) {
            if ($userdata['verified']) {
              $_SESSION['Username'] = $username;
              $_SESSION['LoggedIn'] = 1;
              echo('Success! Now you can proceed to the <a href=index.php>start page</a>.<br>');
            } else {
              echo("You haven't verified your email. please, check yur inbox (and, possibly, spam).");
            }
          } else {
            echo('Wrong username or password! Try again.<br>');
          }
        } else {
          echo('Log in here!<br>');
        }
        
        if (empty($_SESSION['LoggedIn']) || empty($_SESSION['Username']) || !$_SESSION['LoggedIn']) {
          ?>

            <form action=login.php method=post>

              <table>
                <tr><td>Username:</td> <td><input type=text name=Username></td></tr>
                <tr><td>Password:</td> <td><input type=password name=Password><td></tr>
              </table>
              
              <input type=submit value="Log in"><br>

            </form>
            
          <?php
        }

      ?>
      <br>
      <a href=../>Back to the main page.</a><br>
      <a href=signup.php>Signup or reset password.</a>

    </div>

  </body>

</html>
<?php include "end.php"?>

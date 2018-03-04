<?php
include "base.php";

function sendMail($mail, $userName) {
  $appendage = random_int(0, 9999999999);
  mail($mail, 'Signup at olus2000/Gierki',
'Hello '.$userName.'!
Here is your confirmation link:
olus2000.w.staszic.waw.pl/Gierki/signup.php?mail='.$mail.'&hash='.sha1($mail.(string)$appendage).'
If you aren\'t '.$userName.' or you didn\'t request to set your password, simply ignore this letter.',
       'From: noreply@olus2000.w.staszic.waw.pl');
  return $appendage;
}
?>
<!DOCTYPE html>
<html>

  <head>

    <title>Signup</title>

    <meta charset=utf-8>
    
    <link rel=stylesheet href=../stylesheet.css>

  </head>

  <body>

    <div class=header>
      <a href=./><img src=./images/Gierki.png></a>
    </div>

    <div class=login>

      <?php  

        $showForm = 'signup';


        //Jeżeli jest zalogowany:
        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
          ?>

            You are already logged in! You are <?php echo($_SESSION['Username']);?>.<br>
            <a href=index.php>Proceed to main page.</a><br>

          <?php
            $showForm = 'none';


        //Jeżeli już wpisał dane do założenia konta:
        } elseif (isset($_POST['NewUsername']) && isset($_POST['NewEmail'])) { 
          $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :value;');
          $stmt->execute(['value' => $_POST['NewUsername']]);
          $userData = $stmt->fetch();

          $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :value;');
          $stmt->execute(['value' => $_POST['NewEmail']]);
          $emailData = $stmt->fetch();

          if ($userData) {
            echo('Username already exists!<br>');
            if ($userData['emailHashDeath'] > time()) {
              echo('The confirmation mail has already been sent to '.$userData['email'].'.<br>Please wait '.($userData['emailHashDeath'] - time()).'s before sending another one.<br>');
            } else {
              $appendage = sendMail($userData['email'], $userData['username']);
              echo($appendage.' ');
              $update = $pdo->prepare('UPDATE users SET hashSeed = :hashSeed, emailHashDeath = :emailHashDeath, timesVerified = :timesVerified WHERE username = :username');
              $update->execute(['emailHashDeath' => time() + 10 * $userData['timesVerified'], 'hashSeed' => $appendage, 'timesVerified' => $userData['timesVerified']*1 + 1, 'username' => $userData['username']]);
              echo($appendage.'<br>');
              $showForm = 'none';
              echo('Verification email with verification link sent to address '.$userData['email'].'.<br>');
            }
          } elseif ($emailData) {
            echo('Email already used by user '.$emailData['username'].'<br>');
          } else {
            $appendage = sendMail($_POST['NewEmail'], $_POST['NewUsername']);
            $update = $pdo->prepare('INSERT INTO users (username, email, hashSeed, emailHashDeath) VALUES (:username, :email, :hashSeed, :emailHashDeath);');
            $update->execute(['username' => $_POST['NewUsername'], 'email' => $_POST['NewEmail'], 'hashSeed' => $appendage, 'emailHashDeath' => time()]);
            $showForm = 'none';
            echo('Verification email with verification link sent to address '.$_POST['NewEmail'].'.<br>');
          }


        //Jeżeli przyszedł tu z linku weryfikacyjnego:
        } elseif (isset($_GET['hash']) && isset($_GET['mail'])) {
          $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :value;');
          $stmt->execute(['value' => $_GET['mail']]);
          $userData = $stmt->fetch();

          if (!$userData) {
            echo('Wrong verification link!<br>');
          } elseif (sha1($userData['email'].$userData['hashSeed']) != $_GET['hash']) {
            echo('Wrong or expired verification link!<br>');
          } elseif ($userData['emailHashDeath'] + 86400 < time()) {
            echo('Verification link expired!<br>');
          } else {
            $update = $pdo->prepare('UPDATE users SET verified = 1 WHERE username = :value;');
            $update->execute(['value' => $userData['username']]);
            $_SESSION['Username'] = $userData['username'];
            $showForm = 'password';
          }


        //Jeżeli właśnie ustawiał hasło:
        } elseif (isset($_POST['NewPassword']) && isset($_POST['RepeatPassword']) && isset($_SESSION['Username'])) {
          if ($_POST['NewPassword'] != $_POST['RepeatPassword']) {
            echo('Passwords don\'t match!<br>');
            $showForm = 'password';
          } else {
            $showForm = 'none';
            $stmt = $pdo->prepare('UPDATE users SET password = :newPassword WHERE username = :username;');
            $stmt->execute(['newPassword' => sha1($_POST['NewPassword']), 'username' => $_SESSION['Username']]);
            $_SESSION['LoggedIn'] = 1;
            echo('Password successfully updated! <br><a href=./>Proceed to main page.</a><br>');
          }
        }


        //Formulaż hasła:
        if ($showForm == 'password') {
            ?>

              <h4>Set a new password for account <?php echo($_SESSION['Username']);?></h4>

              <form action=signup.php method=post>

                <table>
                  <tr><td>Password:</td><td><input type=password name="NewPassword"></td></tr>
                  <tr><td>Repeat password:</td><td><input type=password name="RepeatPassword"></td></tr>
                </table>

                <input type=submit value=Submit><br>

              </form>

            <?php
          }


        //Formulaż zakładania konta:
        if ($showForm == 'signup') {
          ?>

            <h4>Create an account or reset password</h4>

            <form action=signup.php method=post>

              <table>
                <tr><td>Username:</td> <td><input type=text name="NewUsername"></td></tr>
                <tr><td>Email:</td> <td><input type=text name="NewEmail"></td></tr>
              </table>

              <input type=submit value=Submit><br>

            </form>

          <?php
        }

      ?>

    </div>

  </body>

</html>
<?php include "end.php";?>

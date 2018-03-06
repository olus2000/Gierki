<?php
include "base.php";
include "checkLogin.php";
?>
<!DOCTYPE html>
<html>

  <head>

    <meta charset=utf-8>

    <title>Account</title>

    <link rel=stylesheet href=../stylesheet.css>

  </head>

  <body>

    <div class=header>
      <a href=./><img src=images/Gierki.png></a>
    </div>

    <div class=menu>
      <ul>
        <li><a href=tabliczkaMnożenia.php>Tabliczka mnożenia</a></li>
        <li><a href=formulażMnożenia.php>Formulaż tabliczki mnożenia</a></li>
        <li><a href=licznik.php>Licznik odwiedzin</a></li>
        <li><a href=accountManager.php>Ustawienia konta</a></li>
        <li><a href=logout.php>Logout</a></li>
        <li><a href=../>Back</a></li>
      </ul>
    </div>

    <div class=main>

      <h1>Użytkownik: <?php echo($_SESSION['Username']); ?>.</h1>

      <?php

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $_SESSION['Username']]);
        $userdata = $stmt->fetch();
        
        for ($userdata as $key => $val) {
          if ($key == 'password') {
            echo('password: <a href=signup.php>Change password</a><br>');
          } elseif (in_array($key, ['userID', 'password', 'email'])) {
            echo($key.': '.$val)
          }
        }

      ?>

    </div>


  </body>

</html>
<?php include "end.php"?>

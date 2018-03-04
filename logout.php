<?php
include "base.php";
include "checkLogin.php";
?>
<!DOCTYPE html>
<html>

  <head>

    <title>Logout</title>

    <meta charset=UTF-8>
    
    <link rel=stylesheet href=../stylesheet.css>

  </head>

  <body>

    <div class=header>
      <a href=./><img src=images/Gierki.png></a>
    </div>

    <div class=main>
      
      <?php

        unset($_SESSION['Username']);
        $_SESSION['LoggedIn'] = 0;
        echo('Logout successful!');
  
      ?>

      <a href=../>Back to the main page</a>

    </div>

  </body>

</html>

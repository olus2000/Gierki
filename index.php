<?php
include "base.php";
include "checkLogin.php";
?>
<!DOCTYPE html>
<html>

  <head>

    <meta charset="UTF-8">

    <title>Gierki</title>

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
      
      Zalogowany jako <?php echo($_SESSION['Username']); ?>.
      <h1>
        Dzisiaj stronę odwiedziło

        <?php

          $licznik = file_get_contents('licznik.txt');
          if (!isset($_SESSION['liczone']) && !isset($_COOKIE['liczone'])) {
            $_SESSION['liczone'] = 1;
            $_COOKIE['liczone'] = 1;
            $licznik += 1;
            file_put_contents('licznik.txt', $licznik);
          }
          echo($licznik);

        ?>

        osób.

      </h1>
    </div>

  </body>

</html>
<?php include "end.php";?>

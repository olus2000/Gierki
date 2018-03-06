<?php
include "base.php";
include "checkLogin.php";
?>


<!DOCTYPE: html>
<html>

  <head>

    <title>Licznik odwiedzin</title>

    <meta charset=UTF-8>

    <link rel=stylesheet href=../stylesheet.css>

  </head>

  <body>

    <div class=header>
      <a href=./><img src=./images/Gierki.png></a>
    </div>

    <?php

      $licznik = file_get_contents("głupiLicznik.txt") * 1;
      $licznik += 1;
      echo('Liczba odwiedzin: '.$licznik);
      file_put_contents("głupiLicznik.txt", $licznik);

    ?>

    <a href=./>Back</a>

  </body>

</html>
<?php include "end.php";?>

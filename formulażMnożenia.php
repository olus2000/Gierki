<?php
include "base.php";
include "checkLogin.php";
?>
<!DOCTYPE html>
<html>

  <head>

    <title>Obsługa Mnożenia</title>

    <meta charset=UTF-8>

    <link rel=stylesheet href=../stylesheet.css>

  <head>

  <body>

    <div class=header>
      <a href=./><img src=images/Gierki.png></a>
    </div>

    <form action="formulażMnożenia.php" method="post">

      Podaj liczbę wierszy: <input type=text name=w><br>
      Podaj liczbę kolumn: <input type=text name=k><br>

      <input type=reset value=Reset>
      <input type=submit value=Wyślij><br>

    </form>

    <?php

      if (empty($_POST)) {
        echo('Put in the values');
      } else {
        echo '<table border=1 style="border-collapse:collapse;width:100%;text-align:center">';
        echo '<tr style="font-weight:bold">';
        echo '<td>*</td>';
        for ($j = 1; $j <= $_POST['w']*1; $j++) {
          echo "<td>$j</td>";
        }
        echo '</tr>';
        for ($i = 1; $i <= $_POST['k']*1; $i++) {
          echo '<tr>';
          echo '<td style="font-weight:bold">'.$i.'</td>';
          for ($j = 1; $j <= $_POST['w']*1; $j++) {
            echo '<td>'.($i * $j).'</td>';
          }
          echo '</tr>';
        }
        echo '</table>';
      }

      //phpinfo();

    ?>

  </body>

</html>
<?php include "end.php";?>

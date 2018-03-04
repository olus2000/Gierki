<?php
include "base.php";
include "checkLogin.php";
?>
<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">
    <title>Tabliczka mnożenia</title>
    <link rel=stylesheet href=../stylesheet.css>

  </head>

  
  <body>

    <div class=header>
      <a href=./><img src=./images/Gierki.png></a>
    </div>

    <?php

      echo '<table border=1 style="border-collapse:collapse;width:100%;text-align:center">';
      echo '<tr style="font-weight:bold">';
      echo '<td>*</td>';
      for ($i = 1; $i <= 10; $i++) {
        echo "<td>$i</td>";
      }
      echo '</tr>';
      for ($i = 1; $i <= 10; $i++) {
        echo '<tr>';
        echo '<td style="font-weight:bold">'.$i.'</td>';
        for ($j = 1; $j <= 10; $j++) {
          echo '<td>'.($i * $j).'</td>';
        }
        echo '</tr>';
      }
      echo '</table>';

    ?>

    <p><a href="./">Back</a></p>

  </body>

</html>
<?php include "end.php";?>

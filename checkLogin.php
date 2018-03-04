<?php

if (empty($_SESSION['LoggedIn']) || empty($_SESSION['Username'])) {
  header('Location: login.php', 301);
  die();
}

?>

<?php

session_start();

$dbuser = 'olus2000';
$dbpass = file_get_contents("../dbpass.txt");
$dbname = 'olus2000';
$dbhost = 'mysql:host=mysql.staszic.waw.pl; dbname='.$dbname;

try {
  $pdo = new PDO($dbhost, $dbuser, $dbpass);
} catch(PDOException $e) {
  echo 'Error - '.$e->getMessage();
}

?>

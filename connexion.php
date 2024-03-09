<?php
$dbhost = "";
$dbuser ="";
$dbpass = "";
$dbname = "";
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('<p>Error connecting to mysql</p>');
mysqli_set_charset($connect, 'utf8');
?>

<?php
$dbhost = "tuxa.sme.utc";
$dbuser ="nf92a043";
$dbpass = "rrhCU3Pl";
$dbname = "nf92a043";
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('<p>Error connecting to mysql</p>');
mysqli_set_charset($connect, 'utf8');
?>

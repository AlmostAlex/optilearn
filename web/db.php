<?php
/*$host="127.0.0.1";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="web171db";

$dbh = new mysqli($host, $user, $password, $dbname, $port, $socket); */
$host="127.0.0.1";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="web171db";

$dbh = new mysqli($host, $user, $password, $dbname, $port, $socket);
$dbh->set_charset("utf8");


//$con->close();
?>
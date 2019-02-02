<?php

header("Content-Type:text/html;   charset=utf-8"); 

$mysql_server_name='sqld-hk.bcehost.com'; //mysql server name

$mysql_username='f54c1a97d02347ba813b64348db2c311'; //mysql username

$mysql_password='81963b2b36e94e1381e83623953d4d34'; //mysql password

$mysql_database='OgAFZfdNGoAEMwtzKADk'; //mysql database name


GLOBAL $conn;
$conn = mysqli_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting: ") ; //Connect to database

mysqli_query($GLOBALS['conn'], "set character set 'utf8'");
mysqli_query($GLOBALS['conn'], "set names 'utf8'"); 

mysqli_select_db($GLOBALS['conn'], $mysql_database); //Open database

?>
<?php 
/*
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DB', 'wallatong');
define('MYSQL_HOST', 'localhost');
*/
$DB_HOST=gatenv("DB_HOST");
$DB_USER=gatenv("DB_USERNAME");
$DB_PASS=gatenv("DB_PASSWORD");
$DB_DB=gatenv("DB_NAME");

$connect=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_DB);

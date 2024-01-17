<?php 
/*
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DB', 'wallatong');
define('MYSQL_HOST', 'localhost');
*/
define('MYSQL_USER', 'pyhhccgtjq');
define('MYSQL_PASS', '00CXC4B8W7S1FE3Z$');
define('MYSQL_DB', 'ejemploclaseivan-database');
define('MYSQL_HOST', 'ejemploclaseivan-server.mysql.database.azure.com');
/*
$DB_HOST=gatenv("DB_HOST");
$DB_USER=gatenv("DB_USERNAME");
$DB_PASS=gatenv("DB_PASSWORD");
$DB_DB=gatenv("DB_NAME");
*/

$connect=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_DB);

<?php 

$DB_USER= getenv('MYSQL_USER');
$DB_PASS= getenv('MYSQL_PASS');
$DB_DB= getenv('MYSQL_DB');
$DB_HOST getenv('MYSQL_HOST');

$conn=mysqli_connect($DB_USER,$DB_PASS,$DB_DB,$DB_HOST);




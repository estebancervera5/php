<?php

$db_host = 'localhost';
$db_username = 'sysadmin';
$db_password = 'bakugan8';
$db_database = 'alumnos';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die('No es psible conectarse a la base de datos ['. $db->connect_error .']');
}



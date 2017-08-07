<?php
$host = 'localhost';
$dbuser = 'root';
$dbpasswd = '';
$dbname = 'burgers';
$mysqli = new mysqli($host, $dbuser, $dbpasswd, $dbname);
if ($mysqli->connect_error){ //если ошибки при подключении
    die ('connect error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
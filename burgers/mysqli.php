<?php
require_once ('config.php');

//$mysqli->query('SET NAMES "CP1251"'); //устанавливаем кодировку по умолчанию
$stmt = $mysqli->stmt_init(); //начало подготовки запроса
$stmt->prepare('SELECT * FROM orders INNER JOIN users ON orders.id_user = users.id'); //подготовка запроса

$stmt->execute();//выполняем
$result=$stmt->get_result();
$data = $result -> fetch_all(MYSQLI_ASSOC); //для получения асоциативного массива
//fetch_assoc - одна запись
echo '<pre>';
print_r($data);

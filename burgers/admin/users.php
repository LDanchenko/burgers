<?php
require_once('../config.php');
//$mysqli->query('SET NAMES "CP1251"'); //устанавливаем кодировку по умолчанию
$stmt = $mysqli->stmt_init(); //начало подготовки запроса
$stmt->prepare('SELECT * FROM users'); //подготовка запроса
//$stmt->bind_param('i',);//указываем параметры запроса
$stmt->execute();//выполняем
$result=$stmt->get_result();
$data = $result -> fetch_all(MYSQLI_ASSOC); //для получения асоциативного массива
//fetch_assoc - одна запись

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML  4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Тег TABLE</title>
</head>
<body>
<table border="1" width="100%" cellpadding="5">
    <tr align="center">
        <td> ID пользователя</td>
        <td>Имя</td>
        <td>Телефон</td>
        <td>email</td>
        <td>Улица</td>
        <td>Дом</td>
        <td>Корпус</td>
        <td>Этаж</td>
        <td>Квартира</td>
    </tr>

      <?php
      foreach($data as $arr => $massiv)
        {
echo '<tr>';
        foreach($massiv  as  $inner_key => $value)
        {
            echo '<th>' . $value . '</th>';
        }

echo '</tr>';
        }
        ?>





</table>
</body>
</html>
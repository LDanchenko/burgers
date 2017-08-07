<?php
require_once('../config.php');
//$mysqli->query('SET NAMES "CP1251"'); //устанавливаем кодировку по умолчанию
$stmt = $mysqli->stmt_init(); //начало подготовки запроса
$stmt->prepare('SELECT orders.id_order, orders.comments, orders.short_change, orders.card, orders.callback, users.user_name, users.phone,
 users.street, users.house, users.housing, users.floor, users.flat FROM orders INNER JOIN users ON orders.id_user = users.id'); //подготовка запроса
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
        <td> ID заказа</td>
        <td>Комментарий</td>
        <td>Сдача</td>
        <td>Оплата картой</td>
        <td>Перезвонить</td>
        <td>Имя</td>
        <td>Телефон</td>
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
            if(($inner_key == 'callback') or ($inner_key == 'short_change') or ($inner_key == 'card')) {
               if ($value == 1) {
                   $value = '+';
                }
               else {
                  $value = '-';
                }
            }
            echo '<th>' . $value . '</th>';
        }

        echo '</tr>';
    }
    ?>





</table>
</body>
</html>
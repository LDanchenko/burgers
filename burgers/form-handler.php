<?php
require_once('config.php');
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$street = $_POST['street'];
$home = $_POST['home'];
$part = $_POST['part'];
$appt = $_POST['appt'];
$floor = $_POST['floor'];
$change = $_POST['change'];
$card = $_POST['card'];
$comments = $_POST['comments'];
$callback = $_POST['callback'];

//узнаем есть ли в базе пользователь
$stmt = $mysqli->stmt_init(); //начало подготовки запроса
$stmt->prepare('SELECT * FROM users WHERE email = ?'); //подготовка запроса
$stmt->bind_param('s', $email);//указываем параметры запроса
$stmt->execute();//выполняем
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC); //для получения асоциативного массива


//если такого  email нет в таблице - записываем данные - регистрация
if (count($data) == 0) {

    $stmt = $mysqli->stmt_init(); //начало подготовки запроса
    $stmt->prepare('INSERT INTO users (user_name, phone, email, street, house, housing, floor, flat) 
    VALUES ("' . $name . '", "' . $phone . '" ,"' . $email . '", "' . $street . '", "' . $home . '", "' . $part . '", "' . $floor . '",
    "' . $appt . '")'); //подготовка запроса а

    $stmt->execute();//выполняем

}

//находим id пользователя
$stmt = $mysqli->stmt_init();
$stmt->prepare('SELECT id FROM users WHERE email = ? ');
$stmt->bind_param('s', $email);//указываем параметры запроса
$stmt->execute();//выполняем
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC); //для получения асоциативного массив
$user_id = $data[0]['id'];

$stmt = $mysqli->stmt_init();
//передаем id пользователя и данные  заказ

$stmt->prepare('INSERT INTO orders (id_user, comments, short_change, card, callback)
VALUES ("' . $user_id . '", "' . $comments . '", "' . (int)$change . '", "' . $card . '" , "' . $callback . '")');
$stmt->execute();
//
$new_order_id = $mysqli->insert_id;

if (!$mysqli->error) {
    printf("Errormessage: %s\n", $mysqli->error);
}
//Затронуты строки
if (($mysqli->affected_rows) > 0) {//есес затронутые строки - заказ успешно добавлен
    $adres = $email;

    $subject = 'Заказ №' . $new_order_id;
    //по айди ищем данные заказа
    $stmt = $mysqli->stmt_init();
    $stmt->prepare('SELECT id_user FROM orders WHERE id_order = ?'); //подготовка запроса
    $stmt->bind_param('i', $new_order_id);//указываем параметры запроса
    $stmt->execute();//выполняем
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC); //для получения асоциативного массива
    $user_id = $data[0]['id_user'];// нашли айди юзера из заказа

//ищем адресс
    $stmt = $mysqli->stmt_init();
    $stmt->prepare('SELECT users.street, users.house, users.housing, users.floor, users.flat
 FROM users WHERE id = ?'); //подготовка запроса
    $stmt->bind_param('i', $user_id);//указываем параметры запроса
    $stmt->execute();//выполняем
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC); //для получения асоциативного массива
    $user_street = $data[0]['street'];
    $user_house = $data[0]['house'];
    $user_housing = $data[0]['housing'];
    $user_floor = $data[0]['floor'];
    $user_flat = $data[0]['flat'];
    $text = 'Ваш заказ: DarkBeefBurger за 500 рублей, 1 шт, будет доставлен по адресу улица ' . $user_street . ' дом ' . $user_house
        . ' корпус ' . $user_housing . ' этаж  ' . $user_floor . ' квартира ' . $user_flat;

    //ищем какой это заказ для пользователя

    $stmt = $mysqli->stmt_init();
    $stmt->prepare('SELECT * FROM orders WHERE id_user = ?'); //подготовка запроса
    $user_id = 26;
    $stmt->bind_param('i', $user_id);//указываем параметры запроса
    $stmt->execute();//выполняем
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC); //для получения асоциативного массива
    $count = $mysqli->affected_rows;
    $text = $text . PHP_EOL . ' Спасибо, это Ваш ' . $count . ' заказ!';
    mail($adres, $subject, $text);
}

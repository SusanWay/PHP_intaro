<?php
require_once 'connect.php'; //Подключение к бд
$fullname = $_POST['fullname'];
$mail = $_POST['mail'];
$phone = $_POST['phone'];
$comment = $_POST['comment'];
$time = $_POST['time'];
// получение записей из бд, 
//где получают все записи за последний час
$res = $connect->query("SELECT COUNT(*) FROM `requests` WHERE email = '$mail' AND (date BETWEEN DATE_SUB(NOW(), INTERVAL 1 HOUR) AND NOW())"); 
//Считывание данных из запроса
$row = mysqli_fetch_row($res);
$total = $row[0]; // всего записей, 0-ой индекс отвечает за их количество
if ($total > 0) {
    echo 'С момента вашей последней заявки не прошел 1 час, попробуйте позже.';
} else { //Отправка сообщения на почту, если проверка пройдена 
    $sending = mail(
        $mail,
        'Новое сообщение',
        'Ваша заявка:' . "\n" .
            'ФИО: ' . $fullname . "\n" .
            'Адрес почты: ' . $mail . "\n" .
            'Телефон: ' . $phone . "\n" .
            'комментарий: ' . $comment
    );
    mysqli_query($connect, "INSERT INTO `requests` (`id`, `fullname`, `email`, `phone`, `comment`, `date`) VALUES (NULL, '$fullname', '$mail', '$phone', '$comment', '$time')");
}

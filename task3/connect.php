<?php
$connect = mysqli_connect('localhost', 'root', '', 'requst');
if (!$connect) {
    echo "Ошибка подключения бд";
}

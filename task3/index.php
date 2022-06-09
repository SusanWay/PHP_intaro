<?php
require_once 'connect.php';
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Форма обратной связи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <form method="POST" id="form">
        <div class="container" style="width: 60%">
            <div class="p-3 mb-2 mt-5 bg-dark text-white rounded">
                Оставьте сообщение и мы обязательно с вами свяжемся.
            </div>
            <div class="form-group">
                <label for="inputFullname">ФИО</label>
                <input type="fullname" class="form-control" id="inputFullname">
                <label for="inputMail">Почта</label>
                <input type="mail" class="form-control" id="inputMail">
                <label for="inputPhone">Номер телефона</label>
                <input type="phone" class="form-control" id="inputPhone">
                <label for="inputСomment">Комментарий</label>
                <input type="comment" class="form-control" id="inputСomment">
            </div>
            <button type="button" id="sendMail" class="btn btn-dark mt-3">Отправить</button>
            <div id="errorMes"></div>

        </div>


    </form>
    <div id="form2" class="rounded p-5" style="position: fixed;top: 0%; visibility: hidden;width: 100%; height: 100%;">
        <h>ФИО</h>
        <p id="fullname"></p>
        <h>Телефон</h>
        <p id="phone"></p>
        <h>Почта</h>
        <p id="mail"></p>
        <h>Комментарий</h>
        <p id="comment"></p>
        <p id="curtime"></p>
    </div>

</body>
<script type="text/javascript" src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/formMail.js"></script>

</html>
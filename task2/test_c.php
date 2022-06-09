<?php
//-----------------------Задание c
echo '<h2>Задание C</h2>
            <br>';
function S( $data, $n, $m) {
    $pattern = "/^[a-zA-Z _']{" . $n . "," . $m . "}$/";
    return preg_match($pattern, $data);
}
function N( $data, $n, $m ) {
    $pattern = "/^[-0-9][0-9']{0,10}$/";
    if (preg_match($pattern, $data) === 1) {
        $val = intval($data);
        return $n <= $val and $val <= $m;
    }
    return false;
}
function P( $data) {
    $pattern = "/^[+][7][ ][(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{2}[-][0-9]{2}$/";
    return preg_match($pattern, $data);
}
function D($data) {
    $pattern = "^[0-9]{1,2}.[0-9]{1,2}.[0-9]{4} [0-9]{1,2}:[0-9]{1,2}^";
    if (preg_match($pattern, $data) === 1){
        $date = explode(" ", $data)[0];
        $time = explode(" ", $data)[1];
        $date = explode(".", $date);
        $time = explode(":", $time);
        if ( checkdate($date[1], $date[0], $date[2]) == false )
            return false;
        if ( intval($time[0]) >= 24 )
            return false;
        if ( intval($time[1]) >= 60 )
            return false;
        return true;
    }
    return false;

}

function E($data) {
    $pattern = "/^[a-zA-Z][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}[.][a-z]{2,10}$/";
    return preg_match($pattern, $data);
}

function task_с($input){
    $data=explode("<",$input);
    $data=explode(">",$data[1]); //удаление треугольных скобок
    $parameters=explode(" ",$data[1]); //выделение параметров
    unset($parameters[0]); //пустое поле(появляется в следствии explode)
    $data=$data[0];
    if($parameters[1]=='S') { //проверка типа валидации
        $result = S($data, $parameters[2], $parameters[3]);
    }
    else if($parameters[1]=='N') {
        $result = N($data, $parameters[2], $parameters[3]);
    }
    else if($parameters[1]=='P') {
        $result = P($data);
    }
    else if($parameters[1]=='D') {
        $result = D($data);
    }
    else if($parameters[1]=='E') {
        $result = E($data);
    }
    else {
        return "FAIL";
    }

    if ($result === 1 or $result === true)
        return "OK";
    else
        return "FAIL";
}
$inputData = glob('C/*.dat');//загрузка файлов с входными данными
$inputAns = glob('C/*.ans');//загрузка файлов с ответами
$num=1;//счетчик теста
foreach(array_combine($inputData,$inputAns) as $input => $output) {//создание массива с ключами data и данными ans
    $task_input = fopen($input, 'r');//запись отдельного задания и ответа
    $task_answer = fopen($output, 'r');
    $test_flag = true;
    while((!feof($task_answer)) && (!feof($task_input))){//проверка на достижение конца файла
        $input_r = trim(fgets($task_input), " \n\r\t");//запись строки входных данных
        $answer = trim(fgets($task_answer), " \n\r\t");//запись строки ответа
        if(!empty($input_r) && !empty($answer)){//вывод результата проверки
            $result = task_с($input_r);
            if ($answer != $result) {
                $test_flag = false;
            }
        }
    }
    if($test_flag){
        echo "<br>Тест $num: ";
        echo "<br>Ok";
    }
    else{
        echo "<br>Тест $num: ";
        echo "<br>Ошибка";
    }
    $num++;
}
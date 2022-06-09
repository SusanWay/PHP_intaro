<div style="display: flex; justify-content: space-between; width: 200px">
    <h3>Example</h3>
    <h3><a href="test_b.php">Test B</a></h3>
    <h3><a href="test_c.php">Test C</a></h3>
</div>
<?php
//-----------------------Задание 1
echo '<h2>Задание 1</h2>
            <br>';
$input = "2aaa'3'bbb'4'";//пример входных данных
echo $input . '--->';
preg_match_all("/'[0-9]'/", $input, $value);//поиск значений подходящих под регулярное выражение
$copy_value=$value[0]; //копирование значений
foreach($copy_value as &$number){
    $number=intval(trim($number, "'"))*2;//конвертация в int и умножение на 2
    $number="'".$number."'";//добавление кавычек
}
foreach ($value[0] as &$number) {
    $number = "/" . $number . "/";//преобразование в регулярное выражение
}
$output = preg_replace($value[0], $copy_value,$input);//замена значение по регулярному выражению
echo $output;


//-----------------------Задание 2
echo '<h2>Задание 2</h2>
            <br>';
$input = 'http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=366426-7&11';//пример входных данных
echo $input . '--------->';
preg_match_all("/http:\/\/asozd.duma.gov.ru\/main.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9]{1,10}[-][0-9]{1,10}&[0-9]{1,10}/",
    $input, $value);//поиск значений подходящих под регулярное выражение
$copy_value=$value[0];//копирование значений
foreach($copy_value as &$element) {//преобразование копии в регулярное выражение
    $element = str_replace("/", "\/", $element);
    $element = str_replace("?", "\?", $element);
    $element = str_replace("(", "\(", $element);
    $element = str_replace(")", "\)", $element);
    $element = "/" . $element . "/";
}
foreach ($value[0] as &$element) {
    preg_match("/[0-9]{1,10}[-][0-9]{1,10}/", $element, $number);//поиск номера указа
    $element="http://sozd.parlament.gov.ru/bill/" . $number[0];//создание новой ссылки
}
$output = preg_replace($copy_value, $value[0], $input);
echo  $output;


//-----------------------Задание b
echo '<h2>Задание B</h2>
            <br>';
$ip = 'c32g:t2:0:124:1::';//пример входных данных
echo $ip . '--------->';
$result = "";
$all_blocks_amount = 8;
$full_blocks_amount = 0;
$first_check_ip = explode("::", $ip);//определение возможных участков с ::
foreach ($first_check_ip as $second_check_ip) {
    $blocks = explode(":", $second_check_ip);
    $full_blocks_amount += count($blocks);//счет количества блоков без ::
}
$empty_blocks_amount = $all_blocks_amount - $full_blocks_amount;
if ($ip[0] == ":" && $ip[1] == ":") { //если :: в начале, тогда сразу добавляем в итоговую строку блоки с 0
    for ($i = 0; $i < $empty_blocks_amount; $i++) {
        $result .= "0000:";
    }
    $empty_blocks_amount = 0;
}
foreach ($first_check_ip as $second_check_ip) {
    $blocks = explode(":", $second_check_ip);
    foreach ($blocks as $block) {
        for ($i = 0; $i < (4 - strlen($block)); $i++) {//определение скольких 0 не хватает до полного блока
            $result .= "0";
        }
        $result .= $block . ":";
    }
    while ($empty_blocks_amount > 0) {
        $result .= "0000:";
        $empty_blocks_amount--;
    }
}
$result = substr($result, 0, -1);//убираем лишний : на конце
echo $result;


//-----------------------Задание c
echo '<h2>Задание C</h2>
            <br>';
$input = '<asd ns> S 1 10';//пример входных данных
echo filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS).'------------>';
$data = explode("<", $input); //убираем <>
$data = explode(">", $data[1]);
$parameters = explode(" ", $data[1]); //выделение параметров
unset($parameters[0]);
$data = $data[0];
if ($parameters[1] == 'S') {
    $result = preg_match("/^[a-zA-Z _']{" . $parameters[2] . "," . $parameters[3] . "}$/", $data);
} else if ($parameters[1] == 'N') {
    $pattern = "/^[-0-9][0-9']{0,10}$/";
    if (preg_match($pattern, $data) === 1) {
        $val = intval($data);
        $result = ($parameters[2] <= $val and $val <= $parameters[3]);
    }
    else{
        $result = false;
    }
} else if ($parameters[1] == 'P') {
    $result = preg_match("/^[+][7][ ][(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{2}[-][0-9]{2}$/", $data);
} else if ($parameters[1] == 'D') {
    $pattern = "^[0-9]{1,2}.[0-9]{1,2}.[0-9]{4} [0-9]{1,2}:[0-9]{1,2}^";
    if (preg_match($pattern, $data) === 1) {
        $date = explode(" ", $data)[0];
        $time = explode(" ", $data)[1];
        $date = explode(".", $date);
        $time = explode(":", $time);
        if (checkdate($date[1], $date[0], $date[2]) == false)
            $result = false;
        if (intval($time[0]) >= 24)
            $result = false;
        if (intval($time[1]) >= 60)
            $result = false;
        $result = true;
    }
    $result = false;
} else if ($parameters[1] == 'E') {
    $result = preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}[.][a-z]{2,10}$/", $data);
} else {
    echo "FAIL";
}
if ($result === 1)
    echo "OK";
else
    echo "FAIL";
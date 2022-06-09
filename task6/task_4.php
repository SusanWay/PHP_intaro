<?php
echo '<h2>Задание D</h2><br>';
// Считываем данные тестов
$inputFiles = glob('D/*.dat');
$outputFiles = glob('D/*.ans');
$num=0;
//Создание нового массива, используя входные данные в качестве ключей, а ответы для его значений
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $read = fopen($output, 'r');
    $right_answer="";
    while(!feof($read)){
        $str = trim(fgets($read), " \r");//Удаление переноса каретки
        if(!empty($str)){
            $right_answer.=trim($str,"\r\t\n")."\n";
        }
    }
    $prog_answer = getResult($input); //получаем результат программы
    echo "Тест $num: <br><br>";
    echo "Ответ: $right_answer<br><br>Результат программы: $prog_answer<br><br>";
    if (trim($right_answer) == trim($prog_answer)) { //сравниваем правильный и полученный результаты

        echo "Result: Ок<br><br>";
    } else {
        echo "Result: Not Ok<br><br>";
    }
    $num++;
}
/*
Функция минимизации данных о margin или padding.
str:String - определяет первое слово свойства(margin или padding)
margin_top, margin_right, margin_bottom, margin_left - соответствующие параметры.
Возвращает минимизированную строку
*/
function minifyMargin($str, $margin_top, $margin_right, $margin_bottom, $margin_left){
    if( $margin_top == "" and $margin_right == "" and $margin_bottom == "" and $margin_left == "" ){
        return "";
    }
    if ($margin_top == $margin_right and $margin_bottom == $margin_left){
        return $str . ":" . $margin_left . ";";
    }
    if ($margin_left != "" and $margin_top != "" and $margin_bottom != "" and $margin_right != ""){
        return $str . ":$margin_top $margin_right $margin_bottom $margin_left;";
    }
    $result = ""; //строка-результат

    //Сборка кастомного margin
    $str.="-custom";
    if ($margin_top != ""){
        $result .= $str . "-top:$margin_top;";
    }
    if ($margin_right != ""){
        $result .= $str . "-right:$margin_right;";
    }
    if ($margin_bottom != ""){
        $result .= $str . "-bottom:$margin_bottom;";
    }
    if ($margin_left != ""){
        $result .= $str . "-left:$margin_left;";
    }
    return $result;
}

/*
Функция нахождения слова. Словом считается любая последовательность символов кроме : и }
str - строка, в которой находим слово
offset - позиция, с которой начинаем поиск
Возвращает слово(Строка)
*/
function getWord($str, $offset){
    $result = "";
    for ($i=$offset; $i < 99999; $i++) {
        if ($str[$i] == ":" or $str[$i] == "}"){
            break;
        }
        $result.= $str[$i];
    }
    return $result;
}


/*
Функция минимизации CSS
file_path - путь к файлу, который необходимо минимизировать
return минимизированный css
*/
function getResult($file_path){
    $hexes = ["#CD853F",'#FFC0CB','#DDA0DD','#FF0000','#FFFAFA','#D2B48C']; //Массив 16ричных значений цветов
    $colors = ["peru", "pink", "plum", "red","snow", "tan"]; //Массив названий HTML цветов
    $is_in_comment = false;//Флаг нахождения в комментариях
    $result = "";
    $text = file_get_contents($file_path);//Запись файла в одну строку
    $text = preg_replace('/[ \n\t]/', "", $text);//Удаление проеблов, переносов строки, табуляции
    $text = str_replace(":0px", ":0", $text);//Замена 0px на 0
    $text = preg_replace('/[#.]?[a-zA-Z0-9]{1,10}>?[#.]?[a-zA-Z0-9]{1,10}{}/', "", $text);//Удаление пустых стилей
    $text = str_replace($hexes, $colors, $text); //Замена 16ричных цветов на HTML цвета
    //Сокращение 16ричного цвета при повторении двух разрядов
    $text = preg_replace('/#([0-9A-z])[0-9A-z]([0-9A-z])[0-9A-z]([0-9A-z])[0-9A-z]/', "#$1$2$3", $text);
    //Удаление лишних ;
    $text = preg_replace('/;}/', "}", $text);
    $text_array = str_split($text); //Перевод в массив символов строки
    $new_text = "";
    foreach ($text_array as $key => $value) {
        //Активация фалага при побадании в комментарий
        if( $value == "/" and $text_array[$key+1] == "*"){
            $is_in_comment = true;
            continue;
        }
        //Выключение флага при выходе из комментариев
        if( $value == "/" and $text_array[$key-1] == "*"){
            $is_in_comment = false;
            continue;
        }
        //Отключение записи символа при вкл фалаге комментария
        if ($is_in_comment == true){
            continue;
        }
        //Обнуление значениев margin, padding
        if ( $value == "{" ){
            $margin_top = "";
            $margin_right = "";
            $margin_bottom = "";
            $margin_left = "";

            $padding_top = "";
            $padding_right = "";
            $padding_bottom = "";
            $padding_left = "";
        }
        //Минимизация magin, padding
        if ( $value == "}" ){
            //Добавление в конец блока минимизированный magin
            $new_text.=minifyMargin("margin", $margin_top, $margin_right, $margin_bottom, $margin_left);
            //Добавление в конец блока минимизированный padding
            $new_text.=minifyMargin("padding", $padding_top, $padding_right, $padding_bottom, $padding_left);
        }

        //Если следующее слово "margin-..." то находим его значение и записываем в соответствующую переменную
        switch (getWord($text, $key)) {
            case "margin-top":
                preg_match('/margin-top:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $margin_top = $matches[1];
                break;
            case "margin-right":
                preg_match('/margin-right:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $margin_right = $matches[1];
                break;
            case "margin-bottom":
                preg_match('/margin-bottom:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $margin_bottom = $matches[1];
                break;
            case "margin-left":
                preg_match('/margin-left:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $margin_left = $matches[1];
                break;
        }
        //Если следующее слово "padding-..." то находим его значение и записываем в соответствующую переменную
        switch (getWord($text, $key)) {
            case "padding-top":
                preg_match('/padding-top:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $padding_top = $matches[1];
                break;
            case "padding-right":
                preg_match('/padding-right:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $padding_right = $matches[1];
                break;
            case "padding-bottom":
                preg_match('/padding-bottom:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $padding_bottom = $matches[1];
                break;
            case "padding-left":
                preg_match('/padding-left:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
                $padding_left = $matches[1];
                break;
        }
        //Запись символа
        $new_text.= $value;
    }
    //Запись в result
    $result.=$new_text;
    //массив regex'ов по которым мы будем удалять ненужные margin, padding
    $regexes = [
        '/margin-top:[0-9]{1,10}p?x?;?/',
        '/margin-right:[0-9]{1,10}p?x?;?/',
        '/margin-bottom:[0-9]{1,10}p?x?;?/',
        '/margin-left:[0-9]{1,10}p?x?;?/',
        '/padding-top:[0-9]{1,10}p?x?;?/',
        '/padding-right:[0-9]{1,10}p?x?;?/',
        '/padding-bottom:[0-9]{1,10}p?x?;?/',
        '/padding-left:[0-9]{1,10}p?x?;?/'
    ];
    $result = preg_replace($regexes, "", $result);
    //Замена margin-custom на обычный margin
    $result = preg_replace('/margin-custom/', 'margin', $result);
    //Замена padding-custom на обычный padding
    $result = preg_replace('/padding-custom/', 'padding', $result);
    $result = preg_replace('/;}/', "}", $result); //После всех манипуляций могут остаться лишние ; Убираем их
    //Удаление пустых стилей.
    $result = preg_replace('/[#.]?[a-zA-Z0-9]{1,10}>?[#.]?[a-zA-Z0-9]{1,10}{}/', "", $result);

    return $result;
}
<?php
echo '<h2>Задание B</h2><br>';
//Считывание данных тестов
$inputFiles = glob('B/*.dat');
$outputFiles = glob('B/*.ans');
$num = 0;
//Создание нового массива, используя входные данные в качестве ключей, а ответы для его значений
foreach (array_combine($inputFiles, $outputFiles) as $input => $output) {
    $read = fopen($output, 'r');
    $right_answer = "";
    //Редактирование ответов
    while (!feof($read)) {
        $str = trim(fgets($read), " \r");//Удаление переноса каретки
        if (!empty($str)) {
            $right_answer .= trim($str, "\r\t\n") . "\n";
        }
    }

    for ($k = 1; $k < 8; $k++) {
        //Массив пунктов меню
        $nodes = array();
        //Считывание параметров меню
        $file = fopen($input, 'r'); //открываем файл на чтение
        while (!feof($file)) {
            $str = trim(fgets($file));
            $data = explode(" ", $str);

            $id = $data[0];
            $name = $data[1];
            $leftValue = $data[2];
            $rightValue = $data[3];
            $nodes[] = new Node($id, $name, $leftValue, $rightValue);
        }
        //Вычисление максимального значения среди элементов дерева
        $maxValue = count($nodes) * 2;
        $fileResult = "";
        //Алгоритм обхода дерева
        $level = 0;
        for ($i = 1; $i <= $maxValue; $i++) {
            foreach ($nodes as $node) {
                if ($node->leftValue == $i) {
                    $level++;
                    //За каждый уровень добавляем -
                    for ($j = 1; $j < $level; $j++) {
                        $fileResult .= "-";
                    }
                    $fileResult .= $node->name . "\n";
                    break;
                } else if ($node->rightValue == $i) {
                    $level--;
                    break;
                }
            }
        }
    }
    echo "Тест $num: <br><br>";
    echo "Ответ: $right_answer<br><br>Результат программы: $fileResult<br><br>";
    if ($right_answer == $fileResult) { //сравниваем правильный и полученный результаты

        echo "Result: Ок<br><br>";
    } else {
        echo "Result: Not Ok<br><br>";
    }
    $num++;
}

//Класс Пункт Меню с параметрами name - название пункта меню, leftValue - номер левого флага, rightValue - номер правого флага
class Node
{
    public $id;
    public $name;
    public $leftValue;
    public $rightValue;

    function __construct($id, $name, $leftValue, $rightValue)
    {
        $this->id = $id;
        $this->name = $name;
        $this->leftValue = $leftValue;
        $this->rightValue = $rightValue;
    }
}
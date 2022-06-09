<?php
echo '<h2>Задание A</h2><br>';
//Загрузка из файла
$inputFiles = glob('A/*.dat');
$outputFiles = glob('A/*.ans');
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
    $file = fopen($input, 'r'); //открываем файл на чтение
    $banners = array();
    //Считывание входных данных
    while (!feof($file)) {
        $line = fgets($file);
        $data = explode("\t", $line);
        $data[1] = trim($data[1]);
        $date = date_create_from_format("d.m.Y H:i:s", $data[1]);
        //Считывание индификатора рекламы и времени
        $name = $data[0];
        $time = date_create_from_format("d.m.Y H:i:s", $data[1]);
        $uniqueFlag = true;
        foreach ($banners as $banner) {
            //Если уже есть данный индификатор рекламы
            if ($banner->name == $name) {
                $uniqueFlag = false;
                $banner->count++;
                $newDate = $time;
                //Обновление времени
                if ($newDate > $banner->time) {
                    $banner->time = $newDate;
                }
                break;
            }
        }
        //Запись новго индификатора
        if ($uniqueFlag == true) {
            $banners[] = new Banner($name, 1, $time);
        }
    }
    $fileResult = "";
    foreach ($banners as $banner) {
        $fileResult .= $banner->count . " " . $banner->name . " " . date_format($banner->time, 'd.m.Y H:i:s' . "\n");
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
//Класс Баннер с параметрами name - индификатор банера, count - количество появлений, time последнее время появления
class Banner
{
    public $name;
    public $count;
    public $time;

    function __construct($name, $count, $time)
    {
        $this->name = $name;
        $this->count = $count;
        $this->time = $time;
    }
}
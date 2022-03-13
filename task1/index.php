<?php
function calculate($fileName): int // Функция рассчета баланса игрока
{
    $input = fopen($fileName, 'r');
    $n = fgets($input); // Колличество ставок
    $balance = 0; // Заведение переменной для баланса
    $bets = array(); // Заведение переменной для хранения ставок и выбранных результатов
    $games = array();
    for ($i = 0; $i < $n; $i++) {
        list($bets_id_game, $bets_sum, $bets_result) = explode(" ", fgets($input)); // Считывание строки с идетнефикатором ставки, ставкой и выбранным результатом
        $bets_result = trim($bets_result); // Удаления пробелов из начала и конца строки
        $bets[$bets_id_game][$bets_result] = $bets_sum; // Присвоение 
        $balance -= $bets_sum;
    }
    $m = fgets($input); // Колличество игр
    for ($i = 0; $i < $m; $i++) {
        list($game_id, $game_coeff_left, $game_coeff_right, $game_coeff_draw, $game_result) = explode(" ", fgets($input)); // Считывание строки с идентификатором игры, коэффициентами ставок и результатом
        $game_result = trim($game_result); // Удаления пробелов из начала и конца строки
        $games[$game_id][$game_result] = $game_coeff_left.' '.$game_coeff_right.' '.$game_coeff_draw;
    }
    for ($i = 0; $i < count($bets); $i++){ // Цикл идущий по массиву ставок игрока
        $game_id = array_keys($bets)[$i]; // Присвоенние переменной айди игры
        $game_bet =  key(array_values($bets)[$i]); // Присвоение переменной ставки игрока
        $coef = NULL; // Создание переменной для присвоение коэффициента
        if (isset($games[$game_id][$game_bet])){ // определяет, установлена ли переменная
            $coef = $games[$game_id][$game_bet];
            switch ($game_bet) { // просвоенние переменной coef значения в зависимости от сделанной ставки игроком
                case 'L':
                    $coef = explode(" ", $coef)[0];
                    break;
                case 'R':
                    $coef = explode(" ", $coef)[1];
                    $coef = trim($coef);
                    break;
                case 'D':
                    $coef = explode(" ", $coef)[2];
                    break;
            }
            $balance += $coef * $bets[$game_id][$game_bet]; // Переприсвоение переменной отвечающей за баланс игрока 
        }
    }
    return $balance; // Возврафт функцией баланса игрока
}
function task_A($inputData, $inputAns) // Функция
{
    echo('Результат: '.PHP_EOL);
    for ($i = 0; $i < sizeof($inputData); $i++) {
        $output = fopen($inputAns[$i], 'r');
        $answer = fgets($output);
        $result = calculate($inputData[$i]);
        echo('Тест ' . ($i + 1) . ':');
        if ($answer == $result) {
            echo(' Ок'.PHP_EOL);
        } else {
            echo(' Ошибка'.PHP_EOL);
        }
        echo('Вывод программы: ' . $result .PHP_EOL. 'Правильный ответ: ' . $answer);
    }
}

task_A(glob('A/*.dat'), glob('A/*.ans'));
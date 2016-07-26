<?php

defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
// Функция очистки строки URL
function clear_string ($cl_ctr)
{
    // Удаляем html и php теги
    $cl_ctr = strip_tags($cl_ctr);
    // Экранируем спец символы из бд
    $cl_ctr = mysql_real_escape_string($cl_ctr);
    // Удаляем пробелы
    $cl_ctr = trim($cl_ctr);
    //возвращаем после очистки
    return $cl_ctr;
}

?>


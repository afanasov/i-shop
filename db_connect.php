<?php
//    defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
    $db_host		= 'localhost';
    $db_user		= 'x6635224_test';
    $db_pass		= '5k3[s?Zo';
    $db_database            = 'x6635224_test'; 
    $link = mysql_connect($db_host,$db_user,$db_pass);
    mysql_select_db($db_database,$link) or die("Нет соединения с БД ".mysql_error());
    mysql_query("SET names utf8");
?>
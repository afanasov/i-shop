<?php
//Проверяем каким методом подключились 
if($_SERVER["REQUEST_METHOD"] == "POST")
{   
    define('myeshop', true);
    include("../db_connect.php");
    include("../functions/functions.php");

    $login = clear_string($_POST['reg_login']);
    //запрос в БД и проверяем есть ли совпадения
    $result = mysql_query("SELECT login FROM reg_user WHERE login = '$login'",$link) or die(mysql_error($link));
    If (mysql_num_rows($result) > 0)
    {
        echo 'false';
    }else
        {
            echo 'true'; 
        }
}
?>
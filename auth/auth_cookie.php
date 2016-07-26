<?php
defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
//Проверяем как обратились к файлу
if ($_SESSION['auth'] != 'yes_auth' && $_COOKIE["rememberme"])
{ 
    $str = $_COOKIE["rememberme"];
    // Считаем длину строки
    $all_len = strlen($str);
    // Определяем кол-во симвалов до +
    $login_len = strpos($str,'+'); 
    //Очищаем строку и обрезаем  до плюса и получаем логин
    $login = clear_string(substr($str,0,$login_len));  
    //Очищаем строку и получаем пароль 
    $pass = clear_string(substr($str,$login_len+1,$all_len));  
    $result = mysql_query("SELECT * FROM reg_user WHERE (login = '$login' or email = '$login') AND pass = '$pass'",$link) or die(mysql_error($link));
    If (mysql_num_rows($result) > 0)
        {
        $row = mysql_fetch_array($result);
        session_start();
        $_SESSION['auth'] = 'yes_auth'; 
        $_SESSION['auth_pass'] = $row["pass"];
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_address'] = $row["address"];
        $_SESSION['auth_phone'] = $row["phone"];
        $_SESSION['auth_email'] = $row["email"];
        }      
}
?>


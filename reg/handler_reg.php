<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    session_start();
    define('myeshop', true); 
    include("../db_connect.php");
    include("../functions/functions.php");
    $error = array();
         
    $login = strtolower(clear_string($_POST['reg_login'])); 
    $pass = strtolower(clear_string($_POST['reg_pass'])); 
    $surname = clear_string($_POST['reg_surname']);         
    $name = clear_string($_POST['reg_name']); 
    $patronymic = clear_string($_POST['reg_patronymic']); 
    $email = clear_string($_POST['reg_email']);         
    $phone = clear_string($_POST['reg_phone']); 
    $address = clear_string($_POST['reg_address']); 
  
    if (strlen($login) < 5 or strlen($login) > 15)
    {
        $error[] = "Логин должен быть от 5 до 15 символов!"; 
    }else
    {   
        $result = mysql_query("SELECT login FROM reg_user WHERE login = '$login'",$link) or die(mysql_error($link));
        If (mysql_num_rows($result) > 0)
        {
            $error[] = "Логин занят!";
        }
            
    }
     
    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "Укажите пароль от 7 до 15 символов!";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Укажите Фамилию от 3 до 20 символов!";
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Укажите Имя от 3 до 15 символов!";
    if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "Укажите Отчество от 3 до 25 символов!";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email))) $error[] = "Укажите корректный email!";
    if (!$phone) $error[] = "Укажите номер телефона!";
    if (!$address) $error[] = "Необходимо указать адрес доставки!";
    
    if($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "Неверный код с картинки!";
    unset($_SESSION['img_captcha']);
    
    if (count($error))
    {
    
        echo implode('<br />',$error);
     
    }else
    {    //Хешируем пароль 
        $pass   = md5($pass);
        //Переварачиваем его наоборот
        $pass   = strrev($pass);
        //Добовляем набор хаотичных букв
        //$pass   = "9nm2rv8q".$pass."2yo6z";
        //Считываем ip
        $ip = $_SERVER['REMOTE_ADDR'];
	
	$reg = mysql_query("	INSERT INTO reg_user(login,pass,surname,name,patronymic,email,phone,address,datetime,ip)
						VALUES(					
							'".$login."',
							'".$pass."',
							'".$surname."',
							'".$name."',
							'".$patronymic."',
                                                        '".$email."',
                                                        '".$phone."',
                                                        '".$address."',
                                                        NOW(),
                                                        '".$ip."'							
                                                        )",$link) or die(mysql_error($link));
        echo '<p id="form-success">Вы успешно зарегистрированы!</p>';
    }        
}
?>
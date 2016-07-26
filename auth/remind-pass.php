<?php
//Проверяем как обратились к файлу
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    define('myeshop', true); 
    include("../db_connect.php");
    include("../functions/functions.php");
    //Кладем в переменную и очищаем
    $email = clear_string($_POST["email"]);
    //проверка на пустоту 
    if ($email != "")
    {
        //Запрос в БД    
        $result = mysql_query("SELECT email FROM reg_user WHERE email='$email'",$link) or die(mysql_error($link)) or die(mysql_error($link));
        If (mysql_num_rows($result) > 0)
        {
            // Генерация нового пароля.
            $newpass = fungenpass();
    
            // Шифрование пароля.
            $pass = md5($newpass);
            $pass = strrev($pass);
            $pass   = strtolower($pass);    
            //Добавить в будущем $pass   = strtolower("9nm2rv8q".$pass."2yo6z");    
    
            // Обновление пароля на новый.
            $update = mysql_query ("UPDATE reg_user SET pass='$pass' WHERE email='$email'",$link) or die(mysql_error($link));
    
            // Отправка нового пароля.
            //Вопрос по отправки мыла
	         send_mail( $email,//от кого
			    'tema-87@inbox.ru',//кому
                            'Новый пароль для сайта ',//Тема сообщения
                            'Ваш пароль: '.$newpass);   //Сообщение   
            echo 'yes';    
        }else
        {
            echo 'Данный E-mail не найден!';
        }
    }
    else
    {
        echo 'Укажите свой E-mail';
    }

}



?>

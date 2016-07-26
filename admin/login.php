<?php
    
    session_start();
    define('myeshop', true);
    require '../db_connect.php';
    require 'functions/functions.php';

    
    
    //ini_set('display_errors',1);
    //error_reporting(E_ALL);
    
    if ($_POST["submit_enter"])
    {
        $login = clear_string($_POST["input_login"]);
        $pass  = clear_string($_POST["input_pass"]);
    
        if ($login && $pass)
        {   
            $pass   = md5($pass);
            $pass   = strrev($pass);
            $pass   = strtolower($pass);
            
            $result = mysql_query("SELECT * FROM reg_admin WHERE login = '$login' AND pass = '$pass'",$link) or die(mysql_error($link));
            If (mysql_num_rows($result) > 0)
            {
                $row = mysql_fetch_array($result);
            
                $_SESSION['auth_admin']='yes_auth';
                //Имя
                $_SESSION['name']=$row["fio"];
                //Должность
                $_SESSION['role']=$row["role"];
                // Привилегии
                // Заказы
                $_SESSION['accept_orders'] = $row["accept_orders"];
                $_SESSION['delete_orders'] = $row["delete_orders"];
                $_SESSION['view_orders'] = $row["view_orders"];
                // Товары  
                $_SESSION['delete_tovar'] = $row["delete_tovar"];
                $_SESSION['add_tovar'] = $row["add_tovar"];
                $_SESSION['edit_tovar'] = $row["edit_tovar"];
                // Отзывы
                $_SESSION['accept_reviews'] = $row["accept_reviews"];
                $_SESSION['delete_reviews'] = $row["delete_reviews"];    
               /// Клиенты
                $_SESSION['view_clients'] = $row["view_clients"];
                $_SESSION['delete_clients'] = $row["delete_clients"]; 
                // Новости
                $_SESSION['add_news'] = $row["add_news"]; 
                $_SESSION['delete_news'] = $row["delete_news"];
                $_SESSION['edit_news'] = $row["edit_news"];
                // Категории
                $_SESSION['add_category'] = $row["add_category"]; 
                $_SESSION['delete_category'] = $row["delete_category"];  
                // Администраторы
                $_SESSION['view_admin'] = $row["view_admin"];

                
                
   
                
                //var_dump($_SESSION);
                //header("Location: http://x6635224.bget.ru/admin/index.php");
                //header('Location: http://www.example.com/');
                //header( 'Location: http://www.example.com/', true, 301 );
                
                
                
                
                header( 'Location: index.php', true, 301 );
            }else
            {
                $msgerror = "Неверный Логин и(или) Пароль."; 
            }
        
        }else
        {
            $msgerror = "Заполните все поля!";
        }
 
    }
 
?>


<!DOCTYPE html>
<!--    -->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style-login.css" rel="stylesheet" type="text/css" />
        <link href="images/key.jpg" rel="shortcut icon" type="image/x-icon">
        <title>Вход в админ панель</title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <!-- Блок авторизации   -->
        <div id="block-pass-login" >
            
            <?php	
                if ($msgerror)
                {
                    echo '<p id="msgerror" >'.$msgerror.'</p>';        
                }    
            ?>
                        
            <form method="post" >
                <ul id="pass-login">
                    <li><label>Логин</label><input type="text" name="input_login" /></li>
                    <li><label>Пароль</label><input type="password" name="input_pass" /></li>
                </ul>
                <p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="Вход" /></p>
            </form>

        </div>
    </body>
</html>

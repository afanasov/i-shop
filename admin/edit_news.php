<?php
    session_start();
    //ini_set('display_errors',1);
    //error_reporting(E_ALL);
    if ($_SESSION['auth_admin'] == "yes_auth")
    {
	define('myeshop', true);       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }

    $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> / <a href='news.php' >Новости</a> / <a href='#' >Редакор новостей</a>";    
    require "../db_connect.php";
    require "functions/functions.php";
        
    //Принимаем из GET
    $id = clear_string($_GET["id"]);
    if ($_POST["submit_save"])
    {
        if($_SESSION['edit_news'] == 1)
            {   
                $error = array(); 
                if (!$_POST["form_title"]) $error[] = "Укажите название новости!";
                if (!$_POST["form_text"]) $error[] = "Укажите текст новости!";
                if (count($error))
                {
                    $_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";        
                }else
                {            
                    $querynew = "title='{$_POST["form_title"]}',text='{$_POST["form_text"]}',date=NOW()";                   
                    $update = mysql_query("UPDATE news SET $querynew WHERE id = '$id'",$link) or die(mysql_error($link));
                    $_SESSION['message'] = "<p id='form-success'>Данные успешно изменены!</p>";            
                }
            }else 
            { $msgerror = 'У вас нет прав на изменения данной новости!';}
    }                 
?>
<!DOCTYPE html>
<!--   -->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />                         
        <link href="images/admin.png" rel="shortcut icon"  type="image/x-icon">
        <title>Панель управления - Редактор новостей </title>
    </head>
    <body>
        <div id="block-body">
            <?php
                require 'include/block-header.php';
                require 'include/block-menu.php';
                  
               
            ?>
<div id="block-content">
<div id="block-parameters">
<p id="title-page" >Редактор новостей</p>
</div>
<?php
          
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

		 if(isset($_SESSION['message']))
		{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
		}
        
     if(isset($_SESSION['answer']))
		{
		echo $_SESSION['answer'];
		unset($_SESSION['answer']);
		} 
?>
<?php
	$result = mysql_query("SELECT * FROM news WHERE id='$id'",$link) or die(mysql_error($link));
    
        If (mysql_num_rows($result) > 0)
        {
            $row = mysql_fetch_array($result);
            do
            {    
                echo '
                    <form  method="POST">
                        <ul id="edit-tovar">
                            <li>
                                <label>Название Новости</label>
                                <input type="text" name="form_title" value="'.$row["title"].'" />
                            </li>
                            <li>
                                <label>Текст новости</label>
                                <textarea name="form_text">'.$row["text"].'</textarea>
                            </li>
                            <li>
                                <p id="edit_news_date" align="right">Дата последнего изменения / '.$row["date"].'</p>
                            </li> 
                        </ul>
                        <p align="right" ><input type="submit" id="submit_form" name="submit_save" value="Сохранить"/></p>
                    </form>        
                ';        
                
            }while ($row = mysql_fetch_array($result));
        }
    ?> 
</div>
        </div>
        <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="js/script.js"></script> <!-- мой скрипт -->
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script> <!-- Редактор --> 
    </body>
</html>
<?php
    }else
    {
        header("Location: login.php");
    }
?>


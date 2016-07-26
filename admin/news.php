<?php
    session_start();
    if ($_SESSION['auth_admin'] == "yes_auth")
    {
	define('myeshop', true);       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
    $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> / <a href='news.php' >Новости</a>";
   
    require '../db_connect.php';
    require "functions/functions.php";
      
    /*Добавление новости*/    
    if ($_POST["submit_news"])
    {   
        if($_SESSION['add_news'] == '1')
        {
            if ($_POST["news_title"] == "" || $_POST["news_text"] == "")
            {
                $message = "<p id='form-error' >Заполните все поля!</p>";
            }
            else
            {
                mysql_query("INSERT INTO news(title,text,date)
                                VALUES(	
                                '".$_POST["news_title"]."',
                                '".$_POST["news_text"]."',					
                                NOW()                                                                     
                                )",$link)or die(mysql_error($link)); 
                $message = "<p id='form-success' >Новость добавлена!</p>";                     
            }
        }else{ $msgerror = 'У вас нет прав на добавление новостей!';}
    }
    
    $id = clear_string($_GET["id"]);
    $action = $_GET["action"];
    /*Свич удаления*/
    if (isset($action))
    {
       switch ($action) 
        {
            case 'delete':
                if($_SESSION['delete_news'] == '1')
                {
                    $delete = mysql_query("DELETE FROM news WHERE id = '$id'",$link)or die(mysql_error($link));
                }else{ $msgerror = 'У вас нет прав на удаление новостей!';}
            break;        
        } 
    }   
?>

<!DOCTYPE html>
<!--   -->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" /> <!-- плагин для вывода модального окна   -->
        <link href="images/admin.png" rel="shortcut icon"  type="image/x-icon">
        <link href="/jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />  <!-- плагин подтверждения удаления   -->                    
        <title>Панель управления - Новости </title>
    </head>
    <body>
        <div id="block-body">
            <?php
                require 'include/block-header.php';
                require 'include/block-menu.php';
                
                //запрос кол-во новостей
                $all_count = mysql_query("SELECT * FROM news",$link)or die(mysql_error($link));
                $result_count = mysql_num_rows($all_count);                
            ?>
            <div id="block-content">
                <div id="block-parameters">
                    <p id="count-client">Всего новостей - <strong><?php echo $result_count;?></strong></p>
                    <?php
                        if($_SESSION['add_news'] == '1')
                        {
                            echo '<p align="right" id="add-style"><a class="news" href="#news">Добавить новость</a></p>';
                        }
                    ?>
                </div>
                <?php
                    if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
	
                    $num = 2;

                    $page = strip_tags($_GET['page']);              
                    $page = mysql_real_escape_string($page);

                    $count = mysql_query("SELECT COUNT(*) FROM news",$link) or die(mysql_error($link));
                    $temp = mysql_fetch_array($count);
                    $post = $temp[0];
                    // Находим общее число страниц
                    $total = (($post - 1) / $num) + 1;
                    $total =  intval($total);
                    // Определяем начало сообщений для текущей страницы
                    $page = intval($page);
                    // Если значение $page меньше единицы или отрицательно
                    // переходим на первую страницу
                    // А если слишком большое, то переходим на последнюю
                    if(empty($page) or $page < 0) $page = 1;
                      if($page > $total) $page = $total;
                    // Вычисляем начиная с какого номера
                    // следует выводить сообщения
                    $start = $page * $num - $num;
                   
                    if ($message != "") echo $message;
                    
                    $result = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT $start, $num",$link)or die(mysql_error($link));

                    If (mysql_num_rows($result) > 0)
                        {
                            $row = mysql_fetch_array($result);
                            do
                            {  
                                echo '    
                                    <div class="block-news">
                                        <h3>'.$row["title"].'</h3>
                                        <span>'.$row["date"].'</span>
                                        <p>'.$row["text"].'</p>
                                        <p></p>                                        
                                        <a class="green" href="edit_news.php?id='.$row["id"].'">Изменить</a> | <a class="delete" rel="news.php?id='.$row["id"].'&action=delete" >Удалить</a>
                                    </div>    
                                ';        
                            } while ($row = mysql_fetch_array($result));
                        }                    
                    ?>
                    
                    <div id="news">
                        <form method="POST">
                            <div id="block-input">
                                <label>Заголовок <input type="text" name="news_title" /></label>
                                <label>Описание <textarea name="news_text" ></textarea></label>
                            </div>
                            <p align="right">
                                <input type="submit" name="submit_news" id="submit_news" value="Добавить" />
                            </p>
                        </form>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    <?php
                    
                        if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="news.php?page='. ($page - 1) .'" />Назад</a></li>';

                        if ($page != $total) $nextpage = '<li><a class="pstr-next" href="news.php?page='. ($page + 1) .'"/>Вперёд</a></li>';

                        // Находим две ближайшие станицы с обоих краев, если они есть
                        if($page - 5 > 0) $page5left = '<li><a href="news.php?page='. ($page - 5) .'">'. ($page - 5) .'</a></li>';
                        if($page - 4 > 0) $page4left = '<li><a href="news.php?page='. ($page - 4) .'">'. ($page - 4) .'</a></li>';
                        if($page - 3 > 0) $page3left = '<li><a href="news.php?page='. ($page - 3) .'">'. ($page - 3) .'</a></li>';
                        if($page - 2 > 0) $page2left = '<li><a href="news.php?page='. ($page - 2) .'">'. ($page - 2) .'</a></li>';
                        if($page - 1 > 0) $page1left = '<li><a href="news.php?page='. ($page - 1) .'">'. ($page - 1) .'</a></li>';

                        if($page + 5 <= $total) $page5right = '<li><a href="news.php?page='. ($page + 5) .'">'. ($page + 5) .'</a></li>';
                        if($page + 4 <= $total) $page4right = '<li><a href="news.php?page='. ($page + 4) .'">'. ($page + 4) .'</a></li>';
                        if($page + 3 <= $total) $page3right = '<li><a href="news.php?page='. ($page + 3) .'">'. ($page + 3) .'</a></li>';
                        if($page + 2 <= $total) $page2right = '<li><a href="news.php?page='. ($page + 2) .'">'. ($page + 2) .'</a></li>';
                        if($page + 1 <= $total) $page1right = '<li><a href="news.php?page='. ($page + 1) .'">'. ($page + 1) .'</a></li>';

                        if ($page+5 < $total)
                        {
                            $strtotal = '<li><p class="nav-point">...</p></li><li><a href="news.php?page='.$total.'">'.$total.'</a></li>';
                        }else
                        {
                            $strtotal = ""; 
                        }

                        if ($total > 1)
                        {
                            echo '
                                <center>
                                    <div class="pstrnav">
                                        <ul>
                                ';
                                echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='news.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
                                echo '
                                        </ul>
                                    </div>
                                </center>    
                            ';
                        }
                ?>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>         
    <script type="text/javascript" src="js/script.js"></script> <!-- мой скрипт -->
    <script type="text/javascript" src="/jquery_confirm/jquery_confirm.js"></script> <!-- плагин подтверждения удаления   -->
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script> <!-- плагин для вывода модального окна   -->   
    <script type="text/javascript">
        $(document).ready(function(){
            $(".news").fancybox();  
        });
    </script>
</html>
<?php 
}  else {
    header("Location: login.php");
}    
?>


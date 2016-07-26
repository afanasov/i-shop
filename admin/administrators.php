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

    $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> / <a href='administrators.php' >Администраторы</a>";
    
    require '../db_connect.php';
    require "functions/functions.php";
    
    
    $id = clear_string($_GET["id"]);
    $action = $_GET["action"];
    /*Свич удаления*/
    if (isset($action))
    {
       switch ($action) 
        {
            case 'delete':
                $delete = mysql_query("DELETE FROM reg_admin WHERE id = '$id'",$link) or die(mysql_error($link));                          
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
        <link href="images/admin.png" rel="shortcut icon"  type="image/x-icon">
        <link href="/jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />  <!-- плагин подтверждения удаления   -->               
        <title>Панель управления - Администраторы </title>
    </head>
    <body>
        <div id="block-body">
            <?php
                require 'include/block-header.php';
                require 'include/block-menu.php';
                
                //запрос кол-во клиентов
                $all_client = mysql_query("SELECT * FROM reg_admin",$link) or die(mysql_error($link));
                $result_count = mysql_num_rows($all_client);
            ?>
            <div id="block-content">
                <div id="block-parameters">
                    <p id="count-client">Администраторы - <strong><?php echo $result_count;?></strong></p>
                    <p align="right" id="add-style-a"><a href="add_administrators.php">Добавить Администратора</a></p>
                </div>
                <?php
                    if ($_SESSION['view_admin'] == '1')
                    {                   
                        $num = 2;

                        $page = strip_tags($_GET['page']);              
                        $page = mysql_real_escape_string($page);

                        $count = mysql_query("SELECT COUNT(*) FROM reg_admin",$link) or die(mysql_error($link));
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

                        if ($temp[0] > 0)   
                        { 
                            $result = mysql_query("SELECT * FROM reg_admin ORDER BY id DESC LIMIT $start, $num",$link) or die(mysql_error($link));
                            If (mysql_num_rows($result) > 0)
                            {
                                $row = mysql_fetch_array($result);
                                do
                                {  
                                    echo '
                                        <ul id="list-admin" >
                                            <li>
                                                <h3>'.$row["fio"].'</h3>
                                                <p><strong>Должность</strong> - '.$row["role"].'</p>
                                                <p><strong>E-mail</strong> - '.$row["email"].'</p>
                                                <p><strong>Телефон</strong> - '.$row["phone"].'</p>
                                                <p class="links-actions" align="right" ><a class="green" href="edit_administrators.php?id='.$row["id"].'" >Изменить</a> | <a class="delete" rel="administrators.php?id='.$row["id"].'&action=delete" >Удалить</a></p>
                                            </li>
                                        </ul>   
                                    ';
                                } while ($row = mysql_fetch_array($result));
                            }                        
                        }    
                            if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="administrators.php?page='. ($page - 1) .'" />Назад</a></li>';

                            if ($page != $total) $nextpage = '<li><a class="pstr-next" href="administrators.php?page='. ($page + 1) .'"/>Вперёд</a></li>';

                            // Находим две ближайшие станицы с обоих краев, если они есть
                            if($page - 5 > 0) $page5left = '<li><a href="administrators.php?page='. ($page - 5) .'">'. ($page - 5) .'</a></li>';
                            if($page - 4 > 0) $page4left = '<li><a href="administrators.php?page='. ($page - 4) .'">'. ($page - 4) .'</a></li>';
                            if($page - 3 > 0) $page3left = '<li><a href="administrators.php?page='. ($page - 3) .'">'. ($page - 3) .'</a></li>';
                            if($page - 2 > 0) $page2left = '<li><a href="administrators.php?page='. ($page - 2) .'">'. ($page - 2) .'</a></li>';
                            if($page - 1 > 0) $page1left = '<li><a href="administrators.php?page='. ($page - 1) .'">'. ($page - 1) .'</a></li>';

                            if($page + 5 <= $total) $page5right = '<li><a href="administrators.php?page='. ($page + 5) .'">'. ($page + 5) .'</a></li>';
                            if($page + 4 <= $total) $page4right = '<li><a href="administrators.php?page='. ($page + 4) .'">'. ($page + 4) .'</a></li>';
                            if($page + 3 <= $total) $page3right = '<li><a href="administrators.php?page='. ($page + 3) .'">'. ($page + 3) .'</a></li>';
                            if($page + 2 <= $total) $page2right = '<li><a href="administrators.php?page='. ($page + 2) .'">'. ($page + 2) .'</a></li>';
                            if($page + 1 <= $total) $page1right = '<li><a href="administrators.php?page='. ($page + 1) .'">'. ($page + 1) .'</a></li>';

                            if ($page+5 < $total)
                            {
                                $strtotal = '<li><p class="nav-point">...</p></li><li><a href="administrators.php?page='.$total.'">'.$total.'</a></li>';
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
                                    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='administrators.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
                                    echo '
                                            </ul>
                                        </div>
                                    </center>    
                                ';
                            }
                    }else{ echo '<p id="form-error" align="center">У вас нет прав на просмотр администраторов!</p>'; }
                ?>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>         
        <script type="text/javascript" src="js/script.js"></script> <!-- мой скрипт -->
        <script type="text/javascript" src="/jquery_confirm/jquery_confirm.js"></script> <!-- плагин подтверждения удаления   -->
    </body>
</html>
<?php 
}  else {
    header("Location: login.php");
}    
?>


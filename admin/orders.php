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

    $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> / <a href='orders.php' >Заказы</a>";    
    require "../db_connect.php";
    require "functions/functions.php";
    
    $sort = $_GET["sort"];
    switch ($sort) 
        {
	    case 'all-orders':
                $sort = "order_id DESC";
                $sort_name = 'От А до Я';
	    break;

	    case 'confirmed':
                $sort = "order_confirmed = 'yes' DESC";
                $sort_name = 'Обработаные';
	    break;

	    case 'no-confirmed':
                $sort = "order_confirmed = 'no' DESC";
                $sort_name = 'Не обработаные';
	    break;
        
	    default:
                $sort = "order_id DESC";
                $sort_name = 'От А до Я';
	    break;
	}
?>
<!DOCTYPE html>
<!--   -->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="/jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />  <!-- плагин подтверждения удаления   -->            
        <link href="images/admin.png" rel="shortcut icon"  type="image/x-icon">
        <title>Панель управления - Заказы</title>
    </head>
    <body>
        <div id="block-body">
            <?php
                require 'include/block-header.php';
                require 'include/block-menu.php';
                
                $all_count = mysql_query("SELECT * FROM orders",$link) or die(mysql_error($link));
                $all_count_result = mysql_num_rows($all_count);


                 
                $buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'yes'",$link) or die(mysql_error($link));
                $buy_count_result = mysql_num_rows($buy_count);
 
                 
                $no_buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'no'",$link) or die(mysql_error($link));
                $no_buy_count_result = mysql_num_rows($no_buy_count);        
                 
            ?>
            <div id="block-content">
                <div id="block-parameters">
                    
                    
                <!-- Вывод выпадающего меню  -->    
                    <ul id="options-list">
                        <li>Сортировать</li>
                        <li><a id="select-links" href="#"><?php echo $sort_name; ?></a>
                            <ul id="list-links-sort">
                                <li><a href="orders.php?sort=all-orders">От А до Я</a></li>
                                <li><a href="orders.php?sort=confirmed">Обработаные</a></li>
                                <li><a href="orders.php?sort=no-confirmed">Не обработаные</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                    <!-- конец блока параметр   -->
                    
                
                    <!-- Блок с кол-во отзывов   -->
                <div id="block-info">
                    <ul id="review-info-count">
                        <li>Всего заказов - <strong><?php echo $all_count_result; ?></strong></li>
                        <li>Обработаных - <strong><?php echo $buy_count_result; ?></strong></li>
                        <li>Не обработаных - <strong><?php echo $no_buy_count_result; ?></strong></li>
                    </ul>
                </div>                                                                        
                    <?php                    
                        $num = 4;

                        $page = strip_tags($_GET['page']);              
                        $page = mysql_real_escape_string($page);

                        $count = mysql_query("SELECT COUNT(*) FROM orders",$link) or die(mysql_error($link));
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
                            $result = mysql_query("SELECT * FROM orders ORDER BY $sort LIMIT $start, $num",$link);

                            If (mysql_num_rows($result) > 0)
                            {
                                $row = mysql_fetch_array($result);
                                do
                                {
                                    if ($row["order_confirmed"] == 'yes')
                                    {
                                        $status = '<span class="green">Обработан</span>';
                                    } else
                                    {
                                        $status = '<span class="red">Не обработан</span>';    
                                    }

                                    echo '
                                        <div class="block-order">
                                            <p class="order-datetime" >'.$row["order_datetime"].'</p>
                                            <p class="order-number" >Заказ № '.$row["order_id"].' - '.$status.'</p>
                                            <p class="order-link" ><a class="green" href="view_order.php?id='.$row["order_id"].'" >Подробнее</a></p>
                                        </div>
                                    ';   
                                } while ($row = mysql_fetch_array($result));
                            }                           
                        }    
                        if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="orders.php?page='. ($page - 1) .'" />Назад</a></li>';

                            if ($page != $total) $nextpage = '<li><a class="pstr-next" href="orders.php?page='. ($page + 1) .'"/>Вперёд</a></li>';

                            // Находим две ближайшие станицы с обоих краев, если они есть
                            if($page - 5 > 0) $page5left = '<li><a href="orders.php?page='. ($page - 5) .'">'. ($page - 5) .'</a></li>';
                            if($page - 4 > 0) $page4left = '<li><a href="orders.php?page='. ($page - 4) .'">'. ($page - 4) .'</a></li>';
                            if($page - 3 > 0) $page3left = '<li><a href="orders.php?page='. ($page - 3) .'">'. ($page - 3) .'</a></li>';
                            if($page - 2 > 0) $page2left = '<li><a href="orders.php?page='. ($page - 2) .'">'. ($page - 2) .'</a></li>';
                            if($page - 1 > 0) $page1left = '<li><a href="orders.php?page='. ($page - 1) .'">'. ($page - 1) .'</a></li>';

                            if($page + 5 <= $total) $page5right = '<li><a href="orders.php?page='. ($page + 5) .'">'. ($page + 5) .'</a></li>';
                            if($page + 4 <= $total) $page4right = '<li><a href="orders.php?page='. ($page + 4) .'">'. ($page + 4) .'</a></li>';
                            if($page + 3 <= $total) $page3right = '<li><a href="orders.php?page='. ($page + 3) .'">'. ($page + 3) .'</a></li>';
                            if($page + 2 <= $total) $page2right = '<li><a href="orders.php?page='. ($page + 2) .'">'. ($page + 2) .'</a></li>';
                            if($page + 1 <= $total) $page1right = '<li><a href="orders.php?page='. ($page + 1) .'">'. ($page + 1) .'</a></li>';

                            if ($page+5 < $total)
                            {
                                $strtotal = '<li><p class="nav-point">...</p></li><li><a href="orders.php?page='.$total.'">'.$total.'</a></li>';
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
                                    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='orders.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
                                    echo '
                                            </ul>
                                        </div>
                                    </center>    
                                ';
                            }                        
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





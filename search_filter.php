<?php 
    define('myeshop', true);
    session_start(); 
    require 'db_connect.php'; 
    require 'functions/functions.php';
    require 'auth/auth_cookie.php';
    
    //ini_set('display_errors',1);
    //error_reporting(E_ALL);
// подхватываем переменную из индексной строки    
    $cat = clear_string($_GET["cat"]);
// подхватываем переменную из индексной строки
    $type = clear_string($_GET["type"]);    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" /><!--  стиль плагин для "прокрутки" выбора цены -->
        <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
        <title>Поиск по параметрам</title>
    </head>
    <body>
        <div id="block-body">
            <?php //Шапка сайта
                require_once 'include/block-header.php'; 
            ?>   
                <div id="block-right">
                    <?php // Боковой блок
                        require_once 'include/block-category.php';
                        require_once 'include/block-parameter.php';
                        require_once 'include/block-news.php';
                    ?>
                </div>
            
            <!-- Блок контент -->
            <div id="block-content">
                               
                
                <?php
                                    
                    // подхватываем переменную из индексной строки  
                    if($_GET["brand"])
                    {
                        //приобразуем массив в сторку
                        $check_brand = implode(',',$_GET["brand"]);                        
                    }
                    // в переменную допускаем только цифры из индексной строки    
                    $start_price = (int)$_GET["start_price"];
                    $end_price = (int)$_GET["end_price"];
                
                
                    //Существует ли одна из переменных по бренду или по макс цене
                    if(!empty($check_brand)OR !empty($end_price))
                        {
                            if(!empty($check_brand))
                                $query_brand = " AND brand_id IN ($check_brand)";
                            if(!empty($end_price))
                                $query_price = " AND price BETWEEN $start_price AND $end_price";
                        }
                        //Пагинация
                        $num = 6; // кол-во товаров.
                        //Праверяем чтоб в GET было число
                        $page = (int)$_GET['page'];              
                        //запрос в БД на подсчет кол-во товаров
                        $count = mysql_query("SELECT COUNT(*) FROM table_products WHERE visible = '1'",$link) or die(mysql_error($link));
                        //сохраняем результат 
                        $temp = mysql_fetch_array($count);
                        //проверяем есть ли товары 
                        If ($temp[0] > 0)
                        {  
                            //Сохраняем общ. кол-во товаров
                            $tempcount = $temp[0];

                            // Находим общее число страниц
                            $total = (($tempcount - 1) / $num) + 1;
                            // Округляем результат кол-во страниц
                            $total =  intval($total);
                            // Округляем значение из GET
                            $page = intval($page);
                            // Проверяем чтоб там было только полажительное число в пративном случие равно 1
                            if(empty($page) or $page < 0) $page = 1;  

                            if($page > $total) $page = $total;

                            // Вычисляем начиная с какого номера следует выводить товары 
                            $start = $page * $num - $num;
                            //Выодим переменную для запроса в БД
                            $qury_start_num = " LIMIT $start, $num"; 
                        }      
                        // запрос в БД 
                        $query = "SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC";
                        $result = mysql_query($query, $link) or die(mysql_error($link));

                        // проверяем есть ли товары >0
                        if (mysql_num_rows($result) > 0)
                        {
                            $row = mysql_fetch_array($result); 

                                echo '
                                    <div id="block-sorting">
                                        <p id="nav-breadcrumbs">
                                            <a href="index.php" >Главная страница</a> \ <span>Все товары</span>
                                        </p>
                                        <ul id="options-list">
                                            <li>Вид: </li>
                                            <li><img id="style-grid" src="/images/icon-grid.png" /></li>
                                            <li><img id="style-list" src="/images/icon-list.png" /></li>
                                            <li>Сортировать:</li>
                                            <li><a id="select-sort">'.$sort_name.'</a>
                                            <ul id="sorting-list">
                                            <li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=price-asc" >От дешевых к дорогим</a></li>
                                            <li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=price-desc" >От дорогих к дешевым</a></li>
                                            <li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=popular" >Популярное</a></li>
                                            <li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=news" >Новинки</a></li>
                                            <li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=brand" >От А до Я</a></li>
                                        </ul>
                                        </li>
                                        </ul>
                                    </div>

                                    <ul id="block-tovar-grid" >

                                ';
                                // выводим циклом   
                                do
                                {
                                // обрезка изображениия                
                                //проверякем пусто ли в $row["image"] и файл существует
                                    if  ($row["image"] != "" && file_exists("uploads_images/".$row["image"]))
                                    {
                                        $img_path = 'uploads_images/'.$row["image"];
                                        $max_width = 200; 
                                        $max_height = 200; 
                                        list($width, $height) = getimagesize($img_path); 
                                        $ratioh = $max_height/$height; 
                                        $ratiow = $max_width/$width; 
                                        $ratio = min($ratioh, $ratiow); 
                                        $width = intval($ratio*$width); 
                                        $height = intval($ratio*$height);    
                                    }
                                    else
                                    { 
                                        $img_path = "images/no-image.png";
                                        $width = 100;
                                        $height = 200;
                                    }

                                    // Количество отзывов 
                                    $query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat='1'",$link) or die(mysql_error($link));  
                                    $count_reviews = mysql_num_rows($query_reviews);


                                        echo '                            
                                    <li>
                                        <div class="block-images-grid">
                                            <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
                                        </div>
                                        <p class="style-title-grid" >
                                             <a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a>
                                        </p>
                                        <ul class="reviews-and-counts-grid"> 
                                            <li><img src="/images/eye-icon.png" /><p>'.$row["count"].'</p></li>
                                            <li><img src="/images/comment-icon.png" /><p>'.$count_reviews.'</p></li>
                                        </ul>
                                        <a class="add-cart-style-grid" tid="'.$row['products_id'].'"></a>
                                        <p class="style-price-grid">
                                            <strong>'.group_numerals($row["price"]).'</strong> грн.
                                        </p>
                                        <div class="mini-features" >'.$row["mini_features"].'</div>
                                    </li>                    
                                        ';

                                    }
                                    while ($row = mysql_fetch_array($result));
                                ?>                
                                </ul>
              
                <!-- Вывод товаров в контент в виде списков -->                
                <ul id="block-tovar-list">
                <?php
                
                    // запрос в БД
                    $result = mysql_query("SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC",$link) or die(mysql_error($link));

                    // проверяем есть ли товары >0
                    if (mysql_num_rows($result) >0 )
                    {// сохраняем в $row
                        $row = mysql_fetch_array($result);
                        // выводим циклом
                        do
                        {
                            // обрезка изображениия                  
                            //проверякем пусто ли в $row["image"] и файл существует
                            if  ($row["image"] != "" && file_exists("uploads_images/".$row["image"]))
                            {
                                $img_path = 'uploads_images/'.$row["image"];
                                $max_width = 150; 
                                $max_height = 150; 
                                list($width, $height) = getimagesize($img_path); 
                                $ratioh = $max_height/$height; 
                                $ratiow = $max_width/$width; 
                                $ratio = min($ratioh, $ratiow); 
                                $width = intval($ratio*$width); 
                                $height = intval($ratio*$height);    
                            }else
                            { 
                                $img_path = "images/noimages80x70.png";
                                $width = 80;
                                $height = 70;
                            }
                            // Количество отзывов 
                            $query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat='1'",$link) or die(mysql_error($link));  
                            $count_reviews = mysql_num_rows($query_reviews);
                            echo '                            
                                <li>
                                    <div class="block-images-list">
                                        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
                                    </div>
                                    <ul class="reviews-and-counts-list"> 
                                        <li><img src="/images/eye-icon.png" /><p>'.$row["count"].'</p></li>
                                        <li><img src="/images/comment-icon.png" /><p>'.$count_reviews.'</p></li>
                                    </ul>                        
                                    <p class="style-title-list" >
                                         <a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a>
                                    </p>
                                    <a class="add-cart-style-list" tid="'.$row['products_id'].'"></a>                        
                                    <p class="style-price-list">
                                        <strong>'.group_numerals($row["price"]).'</strong> грн.
                                    </p>                        
                                    <div class="style-text-list" >'.$row["mini_description"].'</div>
                                </li>                    
                            ';                        
                        }
                        while ($row = mysql_fetch_array($result));
                    }
                    }  else {
                        echo "<h2>Категория не доступна или не создана</h2>";
                            }
                ?>                
                </ul>                
            </div>               
                       <!--Конец Блока контент  -->
                    
                       
            <?php       
                //кнопки вперед и назад 
                if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="index.php?page='.($page - 1).'">&lt;</a></li>';}
                if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="index.php?page='.($page + 1).'">&gt;</a></li>';


                // Формируем ссылки со страницами
                //левый вывод
                if($page - 5 > 0) $page5left = '<li><a href="index.php?page='.($page - 5).'">'.($page - 5).'</a></li>';
                if($page - 4 > 0) $page4left = '<li><a href="index.php?page='.($page - 4).'">'.($page - 4).'</a></li>';
                if($page - 3 > 0) $page3left = '<li><a href="index.php?page='.($page - 3).'">'.($page - 3).'</a></li>';
                if($page - 2 > 0) $page2left = '<li><a href="index.php?page='.($page - 2).'">'.($page - 2).'</a></li>';
                if($page - 1 > 0) $page1left = '<li><a href="index.php?page='.($page - 1).'">'.($page - 1).'</a></li>';
                //Правый вывод
                if($page + 5 <= $total) $page5right = '<li><a href="index.php?page='.($page + 5).'">'.($page + 5).'</a></li>';
                if($page + 4 <= $total) $page4right = '<li><a href="index.php?page='.($page + 4).'">'.($page + 4).'</a></li>';
                if($page + 3 <= $total) $page3right = '<li><a href="index.php?page='.($page + 3).'">'.($page + 3).'</a></li>';
                if($page + 2 <= $total) $page2right = '<li><a href="index.php?page='.($page + 2).'">'.($page + 2).'</a></li>';
                if($page + 1 <= $total) $page1right = '<li><a href="index.php?page='.($page + 1).'">'.($page + 1).'</a></li>';
                //Проверка для вывода многоточий если кол-во стр. слишком большое(10)
                if ($page+5 < $total)
                {
                    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="index.php?page='.$total.'">'.$total.'</a></li>';
                }else
                {
                    $strtotal = ""; 
                }
                // Проверка если страниц больше чем одна то выодим навигацию
                if ($total > 1)
                {
                    echo '
                        <div class="pstrnav">
                        <ul>
                        ';
                echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='index.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
                echo '
                 </ul>    
                    </div>
                ';
                }                     
                // Блок рендом
                require_once 'include/block-random.php'; 
                // Блок футер
                require_once 'include/block-footer.php'; 
            ?>
        </div>
        <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.cookie.min.js"></script> <!-- джей квери куки -->
        <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script> <!-- плагин для прокрутки -->
        <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script> <!-- плагин для "прокрутки" выбора цены --><!-- мой код -->
        <script type="text/javascript" src="/js/TextChange.js"></script> <!-- Плагин поиска -->
        <script type="text/javascript" src="/js/shop-script.js"></script><!-- мой код -->
    </body>
</html>


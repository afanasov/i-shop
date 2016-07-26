
<?php 
//пример джойна SELECT p.products_id, p.title, p.price, c.brand FROM `table_products` as p left join category as c on p.brand_id = c.id
//перенести скрипты в низ страниц
//phpinfo();    
define('myeshop', true);
session_start(); 
require 'db_connect.php';
require 'functions/functions.php';
require 'auth/auth_cookie.php';
    
    //ini_set('display_errors',1);
    //error_reporting(E_ALL);  
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/order-style.css" rel="stylesheet" type="text/css" />
        <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" /><!--  стиль плагин для "прокрутки" выбора цены -->                
        <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
        <title>Интернет магазин оплата</title>
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
                <center><h2>Оплата</h2></center>                    
                <div id="process">
                    <div id="step">
                        <p><strong>Вы можете оплатить покупку такими способами:<br/></strong></p>                            
                        <p>Наличный расчет с курьером по факту доставки вашего заказа.</p>
                        <p>Оплата по безналичному расчету (для юридических лиц).</p>
                        <p>Оплата по WebMoney. После получения средств на счет, мы доставляем товар.</p>
                        <p>Оплата товара зачислением денежных средств на наш карточный счет в Банке.</p>
                        <p>Оплата на складе Почты после получения и осмотра товара.</p>
                    </div> 
                    <div id="step">
                        <p><strong>При оформлении б/н заказа на юридическое лицо нужно предоставить:<br/></strong></p> 
                        <p>Свидетельство регистрации предприятия</p>
                        <p>Свидетельство плательщика НДС</p>
                        <p>Стационарный номер предприятия (для налоговой)</p>
                        <p>Название или код товара с нашего сайта(то что вы желаете у нас заказать)</p>
                        <p>Ваш мобильный</p>
                    </div>                                      
                </div>                                                             
            </div>               
                       <!--Конец Блока контент  -->                       
                <?php 
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
<?php mysql_close();?>
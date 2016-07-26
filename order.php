
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
        <title>Интернет магазин оформление заказа</title>
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
                <center><h2>Оформление заказа</h2></center>                    
                <div id="process">
                    <div id="step">
                        <p><strong>Вы можете оформить заказ в нашем Интернет магазине такими способами:<br/></strong> позвоните нам по телефону указанному вверху сайта и наши квалифицированные менеджеры помогут вам подобрать товар, уточнить наличие товара на складе, оформить доставку по адресу в удобное для вас время и место</p>                            
                    </div> 
                    <p id="title">Закажите через сайт, для этого:</p>
                    <div id="step">
                        <p><strong>Вы можете оформить заказ в нашем Интернет магазине такими способами:<br/></strong> позвоните нам по телефону указанному вверху сайта и наши квалифицированные менеджеры помогут вам подобрать товар, уточнить наличие товара на складе, оформить доставку по адресу в удобное для вас время и место</p>
                        <p>а) нажмите кнопку «Купить» возле интересующего вас товара </p>
                        <p>б) проверьте правильный ли товар (его количество) указан в корзине </p>
                        <p>в) нажмите ссылку "Оформить заказ"</p>
                        <p>г) заполните свои контактные данные</p>
                        <p> д) выберите удобный для вас способ доставки и оплаты товара.</p>
                    </div> 
                    <div id="step">
                        <p>Если вы оформили заказ с 8:00 до 22:00, то в течении 2 часов после оформления заказа с вами свяжется наш менеджер для уточнения времени и способа доставки товара.</p>
                    </div>
                    <div id="step">
                        <p>Если вы оформили заказ после 22:00, то наш менеджер свяжется с вами с 10:00 до 12:00 на следующий день после оформления заказа.</p>
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
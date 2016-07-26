<?php 
define('myeshop', true);   
session_start(); 
require 'db_connect.php';
require 'functions/functions.php';
require 'auth/auth_cookie.php';
    //ini_set('display_errors',1);
    //error_reporting(E_ALL);    
if ($_POST["send_message"])
{    
    $error = array();
    
    if (!$_POST["feed_name"]) $error[] = "Укажите своё имя";  
  
    if(!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["feed_email"])))
    {
        $error[] = "Укажите корректный E-mail"; 
    }   
    if (!$_POST["feed_subject"]) $error[] = "Укажите тему письма!";  
    if (!$_POST["feed_text"]) $error[] = "Укажите текст сообщения!";  
  
    if (strtolower($_POST["reg_captcha"]) != $_SESSION['img_captcha'])
    {
        $error[] = "Неверный код с картинки!";
    }         
    if (count($error))
    {
        $_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";        
    }else
    {
    	        send_mail($_POST["feed_email"],
		'admin@shop.ru',
		$_POST["feed_subject"],
		'От: '.$_POST["feed_name"].'<br/>'.$_POST["feed_text"]);     
     $_SESSION['message'] = "<p id='form-success'>Ваше сообщение успешно отправлено!</p>";     
    }
}
//Email поменять местами
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" /><!--  стиль плагин для "прокрутки" выбора цены -->                
        <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
        <title>Форма обратной связи</title>
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
                <p id="feedback-p">Форма обратной связи</p> 
                <?php
                if(isset($_SESSION['message']))
                {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
                <!-- Форма обратной связи -->
                <form method="POST">
                    <div id="block-feedback">
                        <ul id="feedback">
                            <li><label>Ваше Имя *</label><input type="text" name="feed_name"  value="<?php echo $_POST["feed_name"];?>"   /></li>
                            <li><label>Ваш E-mail *</label><input type="text" name="feed_email" value="<?php echo $_POST["feed_email"];?>" /></li>
                            <li><label>Тема *</label><input type="text" name="feed_subject" value="<?php echo $_POST["feed_subject"];?>" /></li>
                            <li><label>Текст сообщения *</label><textarea name="feed_text"  ><?php echo $_POST["feed_text"];?></textarea></li>
                            <li>
                                <label for="reg_captcha">Защитный код</label>
                                <div id="block-captcha">
                                    <img src="/reg/reg_captcha.php" />
                                    <input type="text" name="reg_captcha" id="reg_captcha" />
                                    <p id="reloadcaptcha">Обновить</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <p align="right"><input type="submit" name="send_message" id="form_submit" /></p>
                </form>
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
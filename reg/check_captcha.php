<?php
//Проверяем обращение через Пост
 if($_SERVER["REQUEST_METHOD"] == "POST")
{       //стартуем сессию
    session_start();  
        //Сравниваем ввод польз. в нижнем регистре
    if($_SESSION['img_captcha'] == strtolower($_POST['reg_captcha']))
    {
        echo 'true';
    } else { echo 'false'; }
}  

?>
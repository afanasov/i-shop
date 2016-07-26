<?php
//Проверяем как обратились к файлу
if($_SERVER["REQUEST_METHOD"] == "POST")
{
      session_start();
      unset($_SESSION['auth']);
      setcookie('rememberme','',-3600,'/');
      echo 'logout'; 
} 

?>

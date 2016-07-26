<?php
    defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
?>
<div id="block-header">

    <div id="block-header1" >
        <h3><a href="index.php">E-SHOP<br /> Панель Управления</a></h3>
        <p id="link-nav" ><?php echo $_SESSION['urlpage']; ?></p> 
    </div>
    <div id="block-header2" >
        <p align="right"><a href="administrators.php" ><?php echo $_SESSION['role'];?></a> | <a href="?logout">Выход</a></p>
        <p align="right">Вы - <span><?php echo $_SESSION['name']; ?></span></p>
    </div>

</div>

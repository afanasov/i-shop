<?php
    defined('myeshop') or die('Доступ запрещён!');
    
    $result1 = mysql_query("SELECT * FROM orders WHERE order_confirmed='no'",$link);
    $count1 = mysql_num_rows($result1);
    
    if ($count1 > 0) { $count_str1 = '<p>+'.$count1.'</p>'; } else { $count_str1 = ''; }
 
    $result2 = mysql_query("SELECT * FROM table_reviews WHERE moderat='0'",$link);
    $count2 = mysql_num_rows($result2);
    
    if ($count2 > 0) { $count_str2 = '<p>+'.$count2.'</p>'; } else { $count_str2 = ''; }
 
?>
<div id="left-nav">
    <ul>
        <li><a href="orders.php">Заказы</a><?php echo $count_str1; ?></li>
        <li><a href="tovar.php">Товары</a></li>
        <li><a href="reviews.php">Отзывы</a><?php echo $count_str2; ?></li>
        <li><a href="category.php">Категории</a></li>
        <li><a href="clients.php">Клиенты</a></li>
        <li><a href="administrators.php">Администраторы</a></li>
        <li><a href="news.php">Новости</a></li>
    </ul>
</div>
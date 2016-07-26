<?php
    defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
?>
<!-- Блок новостей в боковом меню -->
<div id="block-news">
    
    <img id="news-prev" src="/images/img-prev.png" />
    <div id="newsticker">        
        <ul> 
            <?php
            $result = mysql_query("SELECT * FROM news ORDER BY id DESC",$link) or die(mysql_error($link));
                               
                // проверяем есть ли товары >0
                if (mysql_num_rows($result) > 0)
                {
                    $row = mysql_fetch_array($result); 
                do
                {
                    echo '<li>
                            <span>'.$row["date"].'</span>
                            <a href="#">'.$row["title"].'</a>
                            <p>'.$row["text"].'</p>
                        </li>                
                    ';   
                }
                    while ($row = mysql_fetch_array($result));
                }
                                
            ?>
                          
        </ul>
      
    </div>
    
    
    <img id="news-next" src="/images/img-next.png" />   
    
</div>
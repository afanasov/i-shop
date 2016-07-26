<?php
    defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
?>
<!--Код для запуска плагина прокрутки цен -->
<script type="text/javascript">
$(document).ready(function() {
	    $('#blocktrackbar').trackbar({
	onMove : function() {
    document.getElementById("start-price").value = this.leftValue;
	document.getElementById("end-price").value = this.rightValue;	
	},
	// ширина "ползунка"
        width : 160,
	//минимальная сумма
        leftLimit : 1,
	leftValue : <?php 
                        //Проверяем на ввод цыфр
                        if((int)$_GET["start_price"] >= 1 and (int)$_GET["start_price"] <= 100000)
                        {
                            echo (int)$_GET["start_price"];
                        }  else {
                                    echo "1";
                                }
                    ?>,
	rightLimit : 100000,
	rightValue : <?php 
                        //Проверяем на ввод цыфр
                        if ((int)$_GET["end_price"] >=1 AND (int)$_GET["end_price"] <= 100000)  
                        {
                            echo (int)$_GET["end_price"];   
                        }else
                        {
                            echo "100000";
                        }
                    ?>,
        // значение перемещения
        roundUp : 500
    });
});
</script>


<!-- Поиск по параметрам -->
<div id="block-parameter">
    <p class="header-title">Поиск по параметрам</p>
    
    <p class="title-filter">Стоимость</p>
    <form method="GET" action="search_filter.php"> 
        <div id="block-input-price">
            <ul>
                <li><p>от</p></li>
                <li><input type="text" id="start-price" name="start_price" value="1000" /></li>
                <li><p>до</p></li>
                <li><input type="text" id="end-price" name="end_price" value="30000" /></li>
                <li><p>грн</p></li>
            </ul>                
        </div>
    
        <!-- Трек бар Полоска прокрутки на джей квери -->
        <div id="blocktrackbar"> </div>
        
        <!-- Бренды чек бокс  -->
        <p class="title-filter">Производители</p>
        <ul class="checkbox-brand">
           <?php 
           
                // запрос в БД
                 $result = mysql_query("SELECT * FROM category WHERE type='mobile'",$link)or die(mysql_error($link));              
                // проверяем есть ли товары >0
                if (mysql_num_rows($result) >0 )
                {// сохраняем в $row
                $row = mysql_fetch_array($result);
                
                do
                {
                $checked_brand = "";     
                 //Провеяем GET
                if ($_GET["brand"])
                {
                    //Ищем совпадение в массиве 
                    if (in_array($row["id"],$_GET["brand"]))
                    {
                        //Помещаем в переменную 
                        $checked_brand = "checked";
                    }
                }
                    
                    
                // выводим циклом    
                echo '

<li><input '.$checked_brand.' type="checkbox"name="brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'" /><label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label></li>
  
  
                ';
           
                }
                    while ($row = mysql_fetch_array($result));
                }
                ?>
            
        </ul>
        <!-- Кнопка поиск  -->
        <center><input type="submit" name="submit" id="button-param-search" value=" " /></center>
    </form>
</div>

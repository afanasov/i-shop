<?php
//defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
// Добавить  filter_var!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// Функция очистки строки URL
function clear_string ($cl_ctr)
{
    // Удаляем html и php теги
    $cl_ctr = strip_tags($cl_ctr);
    // Экранируем спец символы из бд
    $cl_ctr = mysql_real_escape_string($cl_ctr);
    // Удаляем пробелы
    $cl_ctr = trim($cl_ctr);
    //возвращаем после очистки
    return $cl_ctr;
}

// Функция генерации пароля
function fungenpass(){
// Длина пароля
    $number = 7;
// Массив значений пароля
        $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 '1','2','3','4','5','6',
                 '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
            // Вычисляем случайный индекс массива при помощи rand
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
    return $pass;
}



//Функция отправки сообщения
function send_mail($from,$to,$subject,$body)
{
	$charset = 'utf-8';
	mb_language("ru");
	$headers  = "MIME-Version: 1.0 \n" ;
	$headers .= "From: <".$from."> \n";
	$headers .= "Reply-To: <".$from."> \n";
	$headers .= "Content-Type: text/html; charset=$charset \n";
	
	$subject = '=?'.$charset.'?B?'.base64_encode($subject).'?=';

	mail($to,$subject,$body,$headers);
}


// Группировка цен по разрядам.
function group_numerals($int){
    
       switch (strlen($int)) {
       //Считаем длину строки
	    case '4':
        //Вырезаем первую цифру ставим пробел
        $price = substr($int,0,1).' '.substr($int,1,4);

	    break;

	    case '5':
        
        $price = substr($int,0,2).' '.substr($int,2,5);

	    break;

	    case '6':
        
        $price = substr($int,0,3).' '.substr($int,3,6);

	    break;

	    case '7':
        
        $price = substr($int,0,1).' '.substr($int,1,3).' '.substr($int,4,7);

	    break;
        
	    default:
        
        $price = $int;
        
	    break;

	}
    return $price; 
}
?>
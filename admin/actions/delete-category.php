<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
define('myeshop', true); 
 
require '../../db_connect.php';
          $delete = mysql_query("DELETE FROM category WHERE id = '{$_POST["id"]}'",$link) or die(mysql_error($link)); 
          echo "delete";   

}
?>
<?php


$recepient = "afanasov.artem@gmail.com";
$sitename = "Leather";

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$email = trim($_POST["email"]);
$subject = trim($_POST["subject"]);
$text = trim($_POST["text"]);
$message = "Имя: $name \nТелефон: $phone \nEmail:$email  \nТема:$subject  \nТекст: $text";

$pagetitle = "Новое сообщение из сайта \"$sitename\"";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");

?>
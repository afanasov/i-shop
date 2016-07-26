<?php
//require_once 'mail.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Отправка форм AJAX</title>
</head>
<body>
	<form id="form">
		<input type="text" name="name" placeholder="Ваше имя" required /><br />
		<input type="text" name="phone" placeholder="Ваш телефон" required /><br />
                <input type="text" name="email" placeholder="Ваш email" required /><br />
                <input type="text" name="subject" placeholder="Вашу тему" required /><br />
		<textarea type="text" name="text" placeholder="Ваш текст сообщения" cols="30" rows="20" required></textarea><br />
                <button>Отправить</button>
	</form>
	<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="common.js"></script>


</body>
</html>

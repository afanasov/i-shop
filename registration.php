<?php 
    define('myeshop', true);
    session_start(); 
    require 'db_connect.php'; 
    require 'functions/functions.php';
    require 'auth/auth_cookie.php';

    //ini_set('display_errors',1);
    //error_reporting(E_ALL);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" /><!--  стиль плагин для "прокрутки" выбора цены -->        
        <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
        <title>Регистрация</title>
    </head>
    <body>
        <div id="block-body">
            <?php //Шапка сайта
                require_once 'include/block-header.php'; 
            ?>   
                <div id="block-right">
                    <?php // Боковой блок
                        require_once 'include/block-category.php';
                        require_once 'include/block-parameter.php';
                        require_once 'include/block-news.php';
                    ?>
                </div>
            
            <!-- Блок контент -->
            <div id="block-content">
                <h2 class="h2-title">Регистрация</h2>
                <!-- Блок регистрации общий -->
                <form method="POST" id="form_reg" action="reg/handler_reg.php">                   
                <!-- Сообщение о ошибке -->
                <p id="reg_message"></p>
                <!-- Форма регистрации -->
                    <div id="block-form-refistration">
                        <ul id="form-registration">
                            <li>
                                <label>Логин</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_login" id="reg_login" />
                            </li>
                            <li>
                                <label>Пароль</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_pass" id="reg_pass" />
                                <span id="genpass">Сгенерировать</span>
                            </li>
                            <li>
                                <label>Фамилия</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_surname" id="reg_surname" />
                            </li>
                            <li>
                                <label>Имя</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_name" id="reg_name" />
                            </li>
                            <li>
                                <label>Отчество</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_patronymic" id="reg_patronymic" />
                            </li>
                            <li>
                                <label>E-mail</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_email" id="reg_email" />
                            </li>
                            <li>
                                <label>Мобильный телефон</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_phone" id="reg_phone" />
                            </li>
                            <li>
                                <label>Адрес доставки</label>
                                <span class="star">*</span>
                                <input type="text" name="reg_address" id="reg_address" />
                            </li>
                            <li>
                                <!-- Каптча -->
                                <div id="block-captcha">
                                    <img src="/reg/reg_captcha.php"/>
                                    <!-- Поле ввода -->
                                    <input type="text" name="reg_captcha" id="reg_captcha"/>
                                    <!-- Поле ввода -->
                                    <p id="reloadcaptcha">Обновить</p>
                                </div>
                            </li>
                        </ul> 
                    </div>
                <!-- Кнопка регистрации -->
                <p align="right">
                    <input type="submit" name="reg_submit" id="form_submit" value="Регистрация" />
                </p>
                </form>
            </div>               
                       <!--Конец Блока контент  -->
                    
                <?php 
                    // Блок рендом
                    require_once 'include/block-random.php'; 
                    // Блок футер
                    require_once 'include/block-footer.php'; 
                    mysql_close()
                ?>
        </div>
        <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.cookie.min.js"></script> <!-- джей квери куки -->
        <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script> <!-- плагин для прокрутки -->
        <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script> <!-- плагин для "прокрутки" выбора цены -->        
        <script type="text/javascript" src="/js/jquery.form.js"></script> <!-- плагин формы -->
        <script type="text/javascript" src="/js/jquery.validate.js"></script> <!-- плагин валидации -->
        <script type="text/javascript" src="/js/TextChange.js"></script> <!-- Плагин поиска -->
        <script type="text/javascript" src="/js/shop-script.js"></script><!-- мой код -->
        <script type="text/javascript">//скрипт валидации
$(document).ready(function() {	
      $('#form_reg').validate(// Указываем id формы
				{	
                            // правила для проверки
                            rules:{
                            "reg_login":{// Указываем id поля
                            required:true,//проверка на заполнение
                            minlength:5,
                            maxlength:15,
                            remote: {//Проверяем занят ли логин 
                            type: "post",    
		            url: "/reg/check_login.php"
		                    }
                                        },
                            "reg_pass":{// Указываем id поля
                            required:true,//проверка на заполнение
                            minlength:7,
                            maxlength:15
                                        },
                            "reg_surname":{// Указываем id поля
                            required:true,//проверка на заполнение
                            minlength:3,
                            maxlength:15
                                        },
                            "reg_name":{// Указываем id поля
                            required:true,//проверка на заполнение
                            minlength:3,
                            maxlength:15
					},
                            "reg_patronymic":{// Указываем id поля
                            required:true,//проверка на заполнение
                            minlength:3,
                            maxlength:25
                                            },
                            "reg_email":{// Указываем id поля
			    required:true,//проверка на заполнение
                            email:true
					},
                            "reg_phone":{// Указываем id поля
                            required:true//проверка на заполнение
                                        },
                            "reg_address":{// Указываем id поля
                            required:true//проверка на заполнение
                                            },
                            "reg_captcha":{// Указываем id поля
                            required:true,//проверка на заполнение
                            remote: {//проверка на совподение капчи
                            type: "post",    
		            url: "/reg/check_captcha.php"
		                    
		                    }
                            
                                            }
					},

                            // выводимые сообщения при нарушении соответствующих правил
                            messages:{
                            "reg_login":{// Указываем id поля
                            required:"Укажите Логин!",
                            minlength:"От 5 до 15 символов!",
                            maxlength:"От 5 до 15 символов!",
                            remote: "Логин занят!"
					},
                            "reg_pass":{// Указываем id поля
                            required:"Укажите Пароль!",
                            minlength:"От 7 до 15 символов!",
                            maxlength:"От 7 до 15 символов!"
					},
                            "reg_surname":{// Указываем id поля
                            required:"Укажите вашу Фамилию!",
                            minlength:"От 3 до 20 символов!",
                            maxlength:"От 3 до 20 символов!"                            
                                            },
                            "reg_name":{// Указываем id поля
                            required:"Укажите ваше Имя!",
                            minlength:"От 3 до 15 символов!",
                            maxlength:"От 3 до 15 символов!"                               
                                        },
                            "reg_patronymic":{// Указываем id поля
                            required:"Укажите ваше Отчество!",
                            minlength:"От 3 до 25 символов!",
                            maxlength:"От 3 до 25 символов!"  
                                            },
                            "reg_email":{// Указываем id поля
                            required:"Укажите свой E-mail",
                            email:"Не корректный E-mail"
					},
                            "reg_phone":{// Указываем id поля
                            required:"Укажите номер телефона!"
					},
                            "reg_address":{// Указываем id поля
                            required:"Необходимо указать адрес доставки!"
						},
                            "reg_captcha":{// Указываем id поля
                            required:"Введите код с картинки!",
                            remote: "Не верный код проверки!"
						}
					},
					
	submitHandler: function(form){
	$(form).ajaxSubmit({
	success: function(data) { 
								 
        if (data == 'true')
    {
       $("#block-form-registration").fadeOut(300,function() {
        
        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");
        $("#form_submit").hide();
        
       });
         
    }
    else
    {
       $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data); 
    }
		} 
			}); 
			}
			});
    	});
     
</script>        
    </body>
</html>
    

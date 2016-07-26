<?php
    defined('myeshop') or header("Location: http://x6635224.bget.ru/forbidden.php");
?>
<!-- Основной верхний блок -->
<div id="block-header">   
<!-- верх с навигацией блок -->
    <div id="heder-top-block">
        <!-- список навигации -->
        <ul id="heder-top-menu">
            <li><a href="offero.php">О нас</a></li>
            <li><a href="offero.php">Магазины</a></li>
            <li><a href="feedback.php">Контакты</a></li>
        </ul>        
        <!-- верх. кнопки вход и рег -->
        <?php
            if($_SESSION['auth'] == 'yes_auth')
            {
                echo '<p id="auth-user-info" align="right"><img src="/images/user.png" />Здравствуйте,'.$_SESSION['auth_name'].'</p>';
            }else 
            {
                echo '<p id="reg-auth-title" align="right"> <a class="top-auth">Вход</a><a href="registration.php">Регистрация</a></p>';
            }
        ?>
               
        <div id="block-top-auth">
            <div class="corner"></div>
            <form method="POST">
                <ul id="input-email-pass">
                    <h3>Вход</h3>
                    <p id="message-auth">Не верный логин или пароль</p>
                    <li><centr><input type="text" id="auth_login" placeholder="Логин или E-mail" /></centr></li>
                    <li><centr><input type="password" id="auth_pass" placeholder="Пароль" /><span img id="button-pass-show-hide" class="pass-show" /></centr></span></li>
                    <ul id="list-auth">
                        <li>
                            <input type="checkbox" name="rememberme" id="rememberme" /> <label for="rememberme">Запомнить меня</label> 
                        </li>
                        <li>
                            <a id="remindpass" href="#">Забыли пароль?</a>
                        </li>
                    </ul>
                    <p align="right" id="button-auth"><a>Вход</a></p>
                    <p align="right" class="auth-loading"><img src="/images/loading.gif"/></p>
                </ul>
            </form>            
                <div id="block-remind">
                    <h3>Восстановление<br /> пароля</h3>
                    <p id="message-remind" class="message-remind-success" ></p>
                    <center><input type="text" id="remind-email" placeholder="Ваш E-mail" /></center>
                    <p align="right" id="button-remind" ><a>Готово</a></p>
                    <p align="right" class="auth-loading" ><img src="/images/loading.gif" /></p>
                    <p id="prev-auth">Назад</p>
                </div>            
        </div>    
    </div>    
    <!-- верхняя линия хедер -->
    <div id="top-line"></div>
    <!-- Блок юзера  -->
    <div id="block-user" >
        <div class="corner2"></div>
        <ul>
        <li><img src="/images/user_info.png" /><a href="profile.php">Профиль</a></li>
        <li><img src="/images/logout.png" /><a id="logout" >Выход</a></li>
        </ul>
    </div>
    
    <!-- логотип хедер -->
    <a href="index.php"><img id="img-logo" src="/images/logo.png"/></a>    
    <!-- инфо блок в хедере с контактами -->
    <div id="personal-info"> 
        <p align="right">Звонок бесплатный.</p>
        <h3 align="right">(123)456-789-0</h3>    
        <img src="/images/phone-icon.png" />        
        <p align="right">Режим работы:</p>
        <p align="right">Будние дни: с 9-00 до 21-00</p>
        <p align="right">Суббота, Воскресенье - Выходные</p>        
        <img src="/images/time-icon.png" />
    </div>    
    <!-- Поиск блок в хедер -->
    <div id="block-search">        
        <form method="GET" action="search.php?q=">            
             <!--Поиск поле ввода-->
             <span> </span>
             <input type="text" id="input-search" name="q" placeholder="Поиск среди более 100 000 товаров" value="<?php echo $search; ?>" />
            <input type="submit" id="button-search" value="Поиск" />            
        </form>
        <!--выпадающий список-->
        <ul id="result-search">
            
        </ul>
    </div>
</div>
<!-- Верхнее меню -->
<div id="top-menu">
<!-- меню -->
    <ul>
        <li><img src="/images/shop.png" /><a href="index.php">Главная</a></li>
        
    </ul>
    <!-- Корзина -->
    <p align="right" id="block-basket"><img src="/images/cart-icon.png" /><a href="cart.php?action=oneclick">Корзина пуста</a></p>
    <!-- Линия меню -->
    <div id="nav-line"> </div>
</div>


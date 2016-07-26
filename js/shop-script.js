/* 
скрипт перебора новостей в боковом меню
*/

$(document).ready(function(){
    
    $("#newsticker").jCarouselLite({
       
        vertical: true,
        hoverPause: true,
        btnPrev: "#news-prew",
        btnNext: "#news-next",
        visible: 3,
        auto:3000,
        speed:500
        
    });
/* 
Функция добавления товара в карзину 
*/    
loadcart();    
/* 
скрипт перебора новостей в боковом меню
*/
  
$("#style-grid").click(function(){
    $("#block-tovar-list").hide();
    $("#block-tovar-grid").show();
    // изменяем значок
    $("#style-grid").attr("src","/images/icon-grid-active.png");
    $("#style-list").attr("src","/images/icon-list.png");
    
    //куки выбоа меню главной странице
    $.cookie('select_style','grid');
    
    });

    
$("#style-list").click(function(){
    $("#block-tovar-grid").hide();
    $("#block-tovar-list").show();
    // изменяем значок
    $("#style-list").attr("src","/images/icon-list-active.png");
    $("#style-grid").attr("src","/images/icon-grid.png");
    
    //куки выбоа меню главной странице
    $.cookie('select_style','list');
    
    });    
    
//Проверка существует ли файл select_style

    if($.cookie('select_style') == 'grid')
    {
    $("#block-tovar-list").hide();
    $("#block-tovar-grid").show();

    $("#style-grid").attr("src","/images/icon-grid-active.png");
    $("#style-list").attr("src","/images/icon-list.png");   
    }
    else
    {
    $("#block-tovar-grid").hide();
    $("#block-tovar-list").show();
    
    $("#style-list").attr("src","/images/icon-list-active.png");
    $("#style-grid").attr("src","/images/icon-grid.png");
    }
   
   
   
 /*
выпадающие меню сортировки   
*/
$("#select-sort").click(function(){   
    $("#sorting-list").slideToggle(200);    
    });    
    

    
 /*
"Акардион" складывающееся боковое меню    
*/

$('#block-category > ul > li > a').click(function(){
               	        
            if ($(this).attr('class') != 'active'){
                
			$('#block-category > ul > li > ul').slideUp(400);
            $(this).next().slideToggle(400);
            
                    $('#block-category > ul > li > a').removeClass('active');
					$(this).addClass('active');
                    $.cookie('select_cat', $(this).attr('id'));
                    
				}else
                {
                                   
                    $('#block-category > ul > li > a').removeClass('active');
                    $('#block-category > ul > li > ul').slideUp(400);
                    $.cookie('select_cat', '');   
                }                                  
    });

if ($.cookie('select_cat') != '')
{
$('#block-category > ul > li > #'+$.cookie('select_cat')).addClass('active').next().show();
}


/*
Генератор пароля  
*/
//Указываем id ссылки
$('#genpass').click(function(){
$.ajax({
type: "POST",
url: "/functions/genpass.php",
//тип данных
dataType: "html",
//не кешировать
cache: false,
success: function(data) {
//Указываем id input куда поместить пароль
$('#reg_pass').val(data);
  }
});
});

/*
Генератор капчи 
*/
//Указываем id капча для отслеживания по нажатию
$('#reloadcaptcha').click(function(){//подменяем отребут на нашу капчу
$('#block-captcha > img').attr("src","/reg/reg_captcha.php?r="+ Math.random());
});

/*
 Кнопка авторизации*/
//Указываем класс ссылки
$('.top-auth').toggle(
       function() {
           $(".top-auth").attr("id","active-button");
           $("#block-top-auth").fadeIn(200);
       },
       function() {
           $(".top-auth").attr("id","");
           $("#block-top-auth").fadeOut(200);  
                  }
                    );
            
/*Авторизация проверка логина и пароля*/            
$("#button-auth").click(function() {
        
 var auth_login = $("#auth_login").val();
 var auth_pass = $("#auth_pass").val();

 
 if (auth_login == "" || auth_login.length > 30 )
 {
    $("#auth_login").css("borderColor","RED");
    send_login = 'no';
 }else {
   $("#auth_login").css("borderColor","#DBDBDB");
   send_login = 'yes'; 
      }

 
if (auth_pass == "" || auth_pass.length > 15 )
 {
    $("#auth_pass").css("borderColor","RED");
    send_pass = 'no';
 }else { $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes'; }

 if ($("#rememberme").prop('checked'))
 {
    auth_rememberme = 'yes';

 }else { auth_rememberme = 'no'; }

 if ( send_login == 'yes' && send_pass == 'yes' )
 { 
  $("#button-auth").hide();
  $(".auth-loading").show();
    
    $.ajax({
  type: "POST",
  url: "/auth/auth.php",
  data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
  dataType: "html",
  cache: false,
  success: function(data) {
  if (data === 'yes_auth')
  {
      location.reload();
  }else
  {
      $("#message-auth").slideDown(400);
      $(".auth-loading").hide();
      $("#button-auth").show();      
  }
 
 
}
});  
}
});        
            
/*Вспомнить пароль*/
$('#remindpass').click(function(){
    $('#input-email-pass').fadeOut(200, function() {  
    $('#block-remind').fadeIn(300);
			});
});

$('#prev-auth').click(function(){
    $('#block-remind').fadeOut(200, function() {  
    $('#input-email-pass').fadeIn(300);
			});
});


$('#button-remind').click(function(){
    var recall_email = $("#remind-email").val();
    if (recall_email == "" || recall_email.length > 50 )
    {
        $("#remind-email").css("borderColor","RED");

    }else 
    {
        $("#remind-email").css("borderColor","#DBDBDB");  
        $("#button-remind").hide();
        $(".auth-loading").show();
    
        $.ajax({
        type: "POST",
        url: "/auth/remind-pass.php",
        data: "email="+recall_email,
        dataType: "html",
        cache: false,
        success: function(data) {

  if (data == 'yes')
  {
     $(".auth-loading").hide();
     $("#button-remind").show();
     $('#message-remind').attr("class","message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);     
     setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 3000); 
  }else
        {
            $(".auth-loading").hide();
            $("#button-remind").show();
            $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);
      
        }
  }
}); 
  }
  }); 

/*Блок юзер*/

$('#auth-user-info').toggle(
    function() {
        $("#block-user").fadeIn(100);
    },
    function() {
        $("#block-user").fadeOut(100);
       }
    );  
  
/*Кнопка выхода*/  
  $('#logout').click(function(){
    
    $.ajax({
  type: "POST",
  url: "/auth/logout.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'logout')
  {
      location.reload();
  }
  
}
}); 
});
  
/*Вывод товаров*/  
$('#input-search').bind('textchange', function () {
                 
 var input_search = $("#input-search").val();

if (input_search.length >= 3 && input_search.length < 150 )
{
 $.ajax({
  type: "POST",
  url: "/search/search.php",
  data: "text="+input_search,
  dataType: "html",
  cache: false,
  success: function(data) {

 if (data > '')
 {
     $("#result-search").show().html(data); 
 }else{
    
    $("#result-search").hide();
 }

      }
}); 

}else
{
  $("#result-search").hide();    
}

});

/* Скрипт валидации корзины*/ 

//Шаблон проверки email на правильность
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
 // Контактные данные
$('#confirm-button-next').click(function(e){   
    var order_fio = $("#order_fio").val();
    var order_email = $("#order_email").val();
    var order_phone = $("#order_phone").val();
    var order_address = $("#order_address").val();
   
if (!$(".order_delivery").is(":checked"))
{
     $(".label_delivery").css("color","#E07B7B");
     send_order_delivery = '0';

}else { $(".label_delivery").css("color","black"); send_order_delivery = '1';

  
  // Проверка ФИО 
 if (order_fio == "" || order_fio.length > 50 )
{
    $("#order_fio").css("borderColor","#FDB6B6");
    send_order_fio = '0';
   
}else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}

  
//проверка email
if (isValidEmailAddress(order_email) == false)
{
    $("#order_email").css("borderColor","#FDB6B6");
    send_order_email = '0';   
 }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}
  
// Проверка телефона
 
  if (order_phone == "" || order_phone.length > 50)
{
    $("#order_phone").css("borderColor","#FDB6B6");
    send_order_phone = '0';   
}else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}
 
// Проверка Адресса
 
  if (order_address == "" || order_address.length > 150)
{
    $("#order_address").css("borderColor","#FDB6B6");
    send_order_address = '0';   
}else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}
  
} 
// Глобальная проверка
if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
{
  // Отправляем форму
    return true;
}

e.preventDefault();

});

/* Добавление товара в корзину*/
$('.add-cart-style-list,.add-cart-style-grid,.add-cart,.random-add-cart').click(function(){
              
 var  tid = $(this).attr("tid");

 $.ajax({
  type: "POST",
  url: "/cart/addtocart.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) { 
  loadcart();
      }
});

});


/* Добавление товара в корзину с обозначение кол-во товара*/
function loadcart(){
     $.ajax({
  type: "POST",
  url: "/cart/loadcart.php",
  dataType: "html",
  cache: false,
  success: function(data) {
    
  if (data == "0")
  {
  
    $("#block-basket > a").html("Корзина пуста");
	
  }else
  {
    $("#block-basket > a").html(data);

  }  
    
      }
});    
       
}


/* Группировка цифр по разрядам */
function fun_group_price(intprice) {  
    
  var result_total = String(intprice);
  var lenstr = result_total.length;
  
    switch(lenstr) {
  case 4: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
    break;
  }
  case 5: {
  groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
    break;
  }
  case 6: {
  groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6); 
    break;
  }
  case 7: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7); 
    break;
  }
  default: {
  groupprice = result_total;  
  }
}  
    return groupprice;
    }



/*Отнять кол-во товаров в карзину */
$('.count-minus').click(function(){

  var iid = $(this).attr("iid");      
 
 $.ajax({
  type: "POST",
  url: "/cart/count-minus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  loadcart();
  
  // переменная с ценной продукта
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Цену умножаем на колличество
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" грн");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
      }
});
  
});


/*Добавить кол-во товаров в карзину */
$('.count-plus').click(function(){

  var iid = $(this).attr("iid");      
  
 $.ajax({
  type: "POST",
  url: "/cart/count-plus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  loadcart();
  
  // переменная с ценной продукта
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Цену умножаем на колличество
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" грн");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
      }
});
  
});
/*Функция ввода кол-ва в инпут в корзине*/
 $('.count-input').keypress(function(e){
 //Код кнопки Enter   
 if(e.keyCode==13){
	   
 var iid = $(this).attr("iid");
 var incount = $("#input-id"+iid).val();        
 
 $.ajax({
  type: "POST",
  url: "/cart/count-input.php",
  data: "id="+iid+"&count="+incount,
  dataType: "html",
  cache: false,
  success: function(data) {
  $("#input-id"+iid).val(data);  
  loadcart();
    
  // переменная с ценной продукта
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  // Цену умножаем на колличество
  result_total = Number(priceproduct) * Number(data);


  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" грн");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  itog_price();

      }
}); 
  }
});

function  itog_price(){
 
 $.ajax({
  type: "POST",
  url: "/cart/itog_price.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  $(".itog-price > strong").html(data);

}
}); 
       
}



/* Функция проверки отправки отзывов и комментов*/

$('#button-send-review').click(function(){
                
    var name = $("#name_review").val();
    var good = $("#good_review").val();
    var bad = $("#bad_review").val();
    var comment = $("#comment_review").val();
    var iid = $("#button-send-review").attr("iid");

    if (name != "")
    {
        name_review = '1';
          $("#name_review").css("borderColor","#DBDBDB");
        }else {
            name_review = '0';
            $("#name_review").css("borderColor","#FDB6B6");
        }
                  
        if (good != "")
        {
            good_review = '1';
            $("#good_review").css("borderColor","#DBDBDB");
        }else {
            good_review = '0';
            $("#good_review").css("borderColor","#FDB6B6");
        }
            
        if (bad != "")
        {
            bad_review = '1';
            $("#bad_review").css("borderColor","#DBDBDB");
        }else {
            bad_review = '0';
            $("#bad_review").css("borderColor","#FDB6B6");
        } 
                                         
            
    // Глобальная проверка и отправка отзыва        
    if ( name_review == '1' && good_review == '1' && bad_review == '1')
    {
        $("#button-send-review").hide();
        $("#reload-img").show();
                  
        $.ajax({
        type: "POST",
        url: "/review/add_review.php",
        data: "id="+iid+"&name="+name+"&good="+good+"&bad="+bad+"&comment="+comment,
        dataType: "html",
        cache: false,
        success: function() {
        setTimeout("$.fancybox.close()", 1000);
         }
         });  
         }

         

/*Лайки*/    
$('#likegood').click(function(){
    alert('1');
    var tid = $(this).attr("tid");
 
    $.ajax({
    type: "POST",
    url: "/like/like.php",
    data: "id="+tid,
    dataType: "html",
    cache: false,
    success: function(data) {  
  
    if (data == 'no')
    {
        alert('Вы уже голосовали!');
    }  
    else
    {
        $("#likegoodcount").html(data);
    }

}
});
});             
});












});







<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE>@pageTitl@</TITLE>
<META http-equiv="Content-Type" content="text-html; charset=windows-1251">
<META name="description" content="@pageDesc@">
<META name="keywords" content="@pageKeyw@">
<META name="copyright" content="@pageReg@">
<META name="engine-copyright" content="PHPSHOP.RU, @pageProduct@">
<META name="domen-copyright" content="@pageDomen@">
<META content="General" name="rating">
<META name="ROBOTS" content="ALL">
<LINK rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<LINK rel="icon" href="favicon.ico" type="image/x-icon">
<LINK href="@pageCss@" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript1.2" src="java/java2.js"></SCRIPT>
<SCRIPT language="JavaScript" src="tagcloud/swfobject.js"></SCRIPT>
<SCRIPT language="JavaScript" src="phpshop/templates/byt_teh1/js/jquery-1.4.3.min.js"></SCRIPT>
<SCRIPT language="JavaScript" src="phpshop/templates/byt_teh1/js/jquery.equalheights.js"></SCRIPT>
<SCRIPT language="JavaScript" src="phpshop/templates/byt_teh1/js/roundabout.js"></SCRIPT>
<SCRIPT language="JavaScript" src="phpshop/templates/byt_teh1/js/roundabout_shapes.js"></SCRIPT>
<SCRIPT language="JavaScript" src="phpshop/templates/byt_teh1/js/js.js"></SCRIPT>
<!--[if lt IE 7]>
<![if gte IE 5.5]>
<script type="text/javascript" src="java/fixpng.js"></script>
<style type="text/css"> 
.iePNG, IMG { filter:expression(fixPNG(this)); } 
.iePNG A { position: relative; }/* стиль для нормальной работы ссылок в элементах с PNG-фоном */
</style>
<![endif]>
<![endif]-->

</HEAD>
<BODY>
<div id="bodyWrapper">
	<div>
 	<div class="row_menu ofh">
           <div class="container_48"> 
<div class="grid_48">
<div class="menu">  
<ul>
<li><a href="/" title="Главная">Главная</a></li>
@topMenu@
</ul>
</div>            	

</div>
            </div>
	</div>            
<div class="row_2 ofh"> 
           <div class="container_48"> 
                <div class="grid_48">
					
		<script type="text/javascript">
			$(document).ready(function() {
				$('#myRoundabout').roundabout({
					shape:'lazySusan'
				});
			});
		</script>
	   	<div class="myRoundabout"">
<ul id="myRoundabout">
<li class="item1"><a href="/"><img src="images/banner_slider_01.jpg" alt="" width="345" height="262"></a></li>
<li class="item2"><a href="/"><img src="images/banner_slider_02.jpg" alt="" width="345" height="262"></a></li>
<li class="item3"><a href="/"><img src="images/banner_slider_03.jpg" alt="" width="345" height="262"></a></li>
<li class="item4"><a href="/"><img src="images/banner_slider_04.jpg" alt="" width="345" height="262"></a></li>
<li class="item5"><a href="/"><img src="images/banner_slider_05.jpg" alt="" width="345" height="262"></a></li>
<li class="item6"><a href="/"><img src="images/banner_slider_06.jpg" alt="" width="345" height="262"></a></li>
<li class="item7"><a href="/"><img src="images/banner_slider_07.jpg" alt="" width="345" height="262"></a></li>
<li class="item8"><a href="/"><img src="images/banner_slider_08.jpg" alt="" width="345" height="262"></a></li>
</ul>
		</div>      
<div class="cl_both"></div>
                    <div class="container_48"> 
                        <div class="grid_48">            
                                            </div>
                    </div>
                </div>
            </div>        
		</div>        
                  
   
        <div class="wrapper-padd wrapper">                            

        </div>    
		<div class="row_4 ofh">
			<div class="container_48">
<div id="bodyContent" class="grid_39 push_9 ">
<div>
<div class="title-t"><div class="title-b"><div class="title-icon"></div><h4 style="font-size: 15px;color: #000000">@mainContentTitle@</h4>
</div></div><div class="contentContainer">
  <div class="contentPadd">
 <div class="contentContainer">
<div style="padding:10px">@mainContent@</div>
<h4 style="font-size: 15px;color: #000000">Последние новости</h4>
          
		  <!-- Вывод новостей [news/news_main_mini.tpl] -->
          @miniNews@
          <!-- Вывод новостей -->
          
		  <!-- Вывод баннера [banner/baner_list_forma.tpl] -->
          @banersDisp@
          <!-- Вывод баннера -->

          @php echo $GLOBALS["PHPShopPhotoElement"]->ListPhoto(9); php@
                </div>
			 <!-- bodyContent //-->
 </div>
</div>  

                	</div>
                </div>
			 <!-- bodyContent //-->
           
                <div id="columnLeft" class="grid_9 pull_39">
                  <div>
<div class="infoBoxWrapper">@skinSelect@</div>
<div class="infoBoxWrapper list first"><div class="box_wrapper">  <div class="infoBoxHeading"><div class="title-icon"></div>Каталог товаров
</div>  <div class="infoBoxContents"><ul class="categories">
@mainMenuPage@
</ul>
</div></div>
</div>
<div class="infoBoxWrapper box2"><div class="box_wrapper">  <div class="infoBoxHeading"><div class="title-icon"></div>Каталог статей
</div>  <div class="infoBoxContents">
@mainMenuPhoto@

</div></div>
</div>
<div class="infoBoxWrapper box2"><div class="box_wrapper">  <div class="infoBoxHeading"><div class="title-icon"></div>Навигация
</div>  <div class="infoBoxContents">
<ul style="padding: 0px; margin: 0px; list-style-type: none;">
              <li><a href="/news/" title="Новости">Новости</a></li>
              <li><a href="/gbook/" title="Новости">Отзывы</a></li>
              <li><a href="/opros/" title="Новости">Опрос</a></li>
              <li><a href="/links/" title="Полезные ссылки">Полезные ссылки</a></li>
              <li><a href="/map/" title="Карта сайта">Карта сайта</a></li>
              <li><a href="/forma/" title="Форма связи">Форма связи</a></li>
            </ul>

</div></div>
</div>

 <!-- Вывод левого текстового блока [main/left_menu.tpl] -->
            @leftMenu@
            <!-- Вывод левого текстового блока -->
            
            <!-- Вывод опроса [opros/opros_forma.tpl, opros/opros_list.tpl] -->
            @oprosDisp@
            <!-- Вывод опроса -->
            
            <!-- Вывод облака тегов [main/left_menu.tpl] -->
            @cloud@
            <!-- Вывод облака тегов -->

</div>
                </div>

    		


    		
    	</div>
    </div>    
            
                  
    	<div class="row_5 ofh">     
        	<div class="container_48">



        <div class="grid_48">
		<div class="footer">
                
        	<div class="Footer_BoxWrapper footer_menu"> 
	<p>
              Copyright &copy; @company@.<br>
              Телефон: @telNum@<br>
              <a href="/rss/" title="RSS">RSS</a>
            </p>
</div>           <p class="art-page-footer"><a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a></p>
            
            
        </div>   
		</div>
<script type="text/javascript">
$('.productListTable tr:nth-child(even)').addClass('alt');
</script>
</div>
       </div>
       
        
	<div class="row_1">
                        		<div id="header">
           <div class="container_48"> 
                <div class="grid_48">


<div class="search ofh"><div class="box_wrapper">
<form method="post" name="forma_search" action="/search/" onSubmit="return SearchChek()">
  	<label class="fl_left">Поиск: </label>
	 	<div class="input-width fl_left">
 		<div class="width-setter">
<input type="text" value="" size="10" maxlength="300" class="go fl_left" name="words" maxLength="30" value="">
	  		</div>
	   	</div>
		<input type="image" src="images/button_header_search.png" alt="" class="button_header_search fl_left">
</form>
</div>
</div>

							</div>
            	</div>
			</div>






    </div>                       
   
<h1><a class="logo" href="http://www.phpshopcms.ru/">
Мой сайт</h1><br><h2>Описание возможностей PHPShop CMS</h2></a>
</div>
</div>
</body></html>
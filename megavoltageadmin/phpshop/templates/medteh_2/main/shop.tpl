<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>@pageTitl@</title>
<meta http-equiv="Content-Type" content="text-html; charset=windows-1251" />
<meta name="description" content="@pageDesc@" />
<meta name="keywords" content="@pageKeyw@" />
<meta name="copyright" content="@pageReg@" />
<meta name="engine-copyright" content="PHPSHOP.RU, @pageProduct@" />
<meta name="domen-copyright" content="@pageDomen@" />
<meta content="General" name="rating" />
<meta name="ROBOTS" content="ALL" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link href="@pageCss@" type="text/css" rel="stylesheet" />
<script language="JavaScript1.2" src="java/java2.js"></script>
<script language="JavaScript" src="/tagcloud/swfobject.js"></script>
<script language="JavaScript1.2" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/XHTMLpressbutt.js"></script>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({
		effect:'fade', //Specify sets like: 'fold,fade,sliceDown'
		slices:9,
		animSpeed:500, //Slide transition speed
		pauseTime:5000,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:false, //Next & Prev
		directionNavHide:false, //Only show on hover
		controlNav:true, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
      	controlNavThumbsFromRel:false, //Use image rel for thumbs
		controlNavThumbsSearch: '.jpg', //Replace this with...
		controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
		keyboardNav:true, //Use left & right arrows
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:0.8, //Universal caption opacity
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){} //Triggers after all slides have been shown
	});
});
</script>
</head>

<body id="index" onload="pressbutt_load('@pageNameId@')">

<div id="wrapper1">
<div id="wrapper2">
<div id="wrapper3">

	<div id="header">
		<a id="header_logo" href="http://www.phpshopcms.ru">
		<h2>@name@</h2><br />@pageDesc@
		</a>

		<div id="header_right">
			
<div id="currencies_block_top">

</div>

<div id="header_user">

</div>

<div id="search_block_top">
	<form method="post" name="forma_search" action="/search/" onsubmit="return SearchChek()" id="searchbox">
<input name="words" id="mod_search_searchword" maxlength="20" alt="Search" class="inputbox" type="text" size="20" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
              <input type="submit" value="Поиск" class="button" onclick="this.form.searchword.focus();"/>
	</form>
</div>
<ul id="tmheaderlinks">
	<li><a href="/" title="Главная">Главная</a></li>
	@topMenu@
</ul>
		</div>
	</div>
	<div id="columns">
	<div id="columns2">

		<div id="left_column" class="column">

<div id="categories_block_left" class="block">
	<h4>Каталог</h4>
<div class="block_content">
<ul class="tree dhtml">
@mainMenuPage@
</ul>
</div>
<br />
<h4>Навигация</h4>
<div class="block_content">
<ul class="tree dhtml">
<li class="item40" id="current"><a href="/news/"><span>Новости</span></a></li>
                          <li class="item40" id="current"><a href="/gbook/"><span>Отзывы</span></a></li>
                          <li class="item40" id="current"><a href="/links/"><span>Полезные ссылки</span></a></li>
                          <li class="item40" id="current"><a href="/forma/"><span>Форма связи</span></a></li>
                          <li class="item40" id="current"><a href="/map/"><span>Карта сайта</span></a></li>
                          @mainMenuPhoto@
</ul>
</div>
<br />
@oprosDisp@
@leftMenu@
@cloud@
</div>

<div id="manufacturers_block_left" class="block blockmanufacturer">
@skinSelect@@rightMenu@	
</div>
</div>

		<div id="center_column" class="center_column">



<div id="slide_holder"> 	
    <div id="slider">
        
                            
                    <a href="/" ><img src="images/slide_00.jpg" alt="" title="" /></a>
                
                            
                    <a href="/"><img src="images/slide_01.jpg" alt="" title="" /></a>
                
                            
                    <a href="/" ><img src="images/slide_02.jpg" alt="" title="" /></a>
</div>
</div>    

<div id="featured-products_block_center" class="home_products">

		<div class="block_content">
@DispShop@
	</div>
	</div>


		</div>
		<div class="clearblock"></div>
	</div>
</div>

	<div id="footer">
		<div id="tmfooterlinks">

	<p>Copyright &copy; @company@ Все права защищены. Работает под управлением <a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a>.</p>
</div>
</div>
</div>
</div>
</div>
</body></html>

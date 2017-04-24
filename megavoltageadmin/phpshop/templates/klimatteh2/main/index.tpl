<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- saved from url=(0053)http://livedemo00.template-help.com/prestashop_34027/ -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<TITLE>@pageTitl@</TITLE>
<META http-equiv="Content-Type" content="text-html; charset=windows-1251">
<meta http-equiv="Content-Style-Type" content="text/css">
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
<script language="JavaScript" src="/tagcloud/swfobject.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@scripts/ja.script.js"></script>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@scripts/opacity.js"></script>
</head>

<body id="index">
<div id="wrapper1">
<div id="wrapper2">
<div id="wrapper3">
<div id="header">
<h1><a id="header_logo" href="http://www.phpshopcms.ru/" title="@name@">
@name@<br>@pageDesc@</a>

</h1>
		<div id="header_right">

<div id="search_block_top">
	<form id="search_mini_form" method="post" name="forma_search" action="/search/" onsubmit="return SearchChek()">
<input name="words" id="mod_search_searchword" maxlength="20" alt="Я ищу..." class="search_query ac_input" type="text" size="22" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
		<a href="javascript:document.getElementById('search_mini_form').submit();"></a>
	</form>
</div>
	
<ul id="header_links">
	<li><a href="/">Главная</a></li>
@topMenu@
</ul>
		</div>
	</div>
	<div id="columns">

		<div id="left_column" class="column">

<div class="block">
	<h4>Навигация</h4>
	<div class="block_content">
		<ul class="dynamized">
									
@mainMenuPage@
<li><a href="/news/" title="Новости" class="mainlevel"><span>Новости</span></a></li>
<li><a href="/gbook/" title="Отзывы" class="mainlevel"><span>Отзывы</span></a></li>
<li><a href="/links/" title="Полезные ссылки" class="mainlevel"><span>Полезные ссылки</span></a></li>
<li><a href="/forma/" title="Полезные ссылки" class="mainlevel"><span>Форма связи</span></a></li>
<li><a href="/map/" title="Карта сайта" class="mainlevel"><span>Карта сайта</span></a></li>
<li>@mainMenuPhoto@</li>
							</ul>
	</div>
</div>
@skinSelect@
@leftMenu@
<div class="block">
	<h4>Голосования</h4>
	<div class="block_content">
@oprosDisp@
	</div>
</div>
@cloud@
</div>

		<div id="center_column" class="center_column">
		<div id="center_column_inner">

<div class="tmbanner1">
	<a href="/"><img src="images/bn1.jpg" alt="Advertising"></a>
</div>

<div class="tmbanner2">
	<a href="/"><img src="images/bn2.jpg" alt="Advertising"></a>
</div>

<div id="featured-products_block_center">
		<div class="block_content">
		<h4>@mainContentTitle@</h4>
@mainContent@
<br><h3>Последние новости</h3>
<br>
@miniNews@
<br>
@banersDisp@
	</div>
	</div>
</div>
		</div>

		<div id="right_column" class="column">

@rightMenu@

</div>
	</div>

	<div id="footer">

<ul id="footer_links">
		
			
						
								
				<li class="last_item"><p id="ja-bottomline"> Наш телефон: <b>@telNum@</b><br>
      Copyright &copy; @company@. 
      Все права защищены. Работает под управлением <a href="http://www.phpshopcms.ru/" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a> </p></li>
</ul>

	</div>
</div>
</div>
</div>
	

</body></html>
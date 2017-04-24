<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
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
<script language="JavaScript" src="/tagcloud/swfobject.js"></SCRIPT>
</HEAD>
<BODY  onload="pressbutt_load('@pageNameId@');NavActive('@php echo $GLOBALS[SysValue][nav][longname];php@')" class="bg_all">

<div id="bg_header">
<div id="all">
	
		<div id="topmenu">
			<div id="foot_navi">
			<div class="topmenu_pad">
<div>
		<div id="act"><img class="act_1" src="images/act_left.gif"></div>
		<div id="act" class="act_2"><a href="/" class="navigation" >Главная</a></div>
		<div id="act"><img class="act_1" src="images/act_right.gif"></div>
	</div>
</div>
				@topMenu@
			</div>
		</div>
		
		<div id="header">
			<div id="leftmenu">
				<div class="name"><a href="/">@name@</a></div>
				<div>@skinSelect@</div>
			</div>
				<div id="search">
					<FORM method="post" name="forma_search" action="/search/" onSubmit="return SearchChek()">						
						<input name="words" class="search" maxLength=30 onFocus="this.value=''">
						<input id="search_but" type="image" src="images/but_search.gif" title="Искать">
					</FORM>
				
				</div>
		</div>


		<div id="content">
			
			<div id="left">	
				<div class="plashka_zag">Каталог</div>
					<ul class="catalog">
						@mainMenuPage@
					</ul>
				<div id="bg_nav_1">
					<div class="bg_nav_1">
					<div class="plashka_zag_2">Навигация</div>
                         <ul class="catalog">
                         	<li class="catalog_page"><a href="/news/" title="Новости">Новости</a>
                         	<li class="catalog_page"><a href="/gbook/" title="Отзывы">Отзывы</a>
                         	<li class="catalog_page"><a href="/links/" title="Полезные ссылки">Полезные ссылки</a>
                            <li class="catalog_page"><a href="/forma/" title="Форма связи">Форма связи</a>
                			<li class="catalog_page"><a href="/map/" title="Карта сайта">Карта сайта</a>
                        	 @mainMenuPhoto@
                         </ul>
					</div>
					</div>
				<div id="bg_nav_2"></div>
				@oprosDisp@
				@leftMenu@	
				@cloud@
			</div>
			
<div id="right">
	<div class="pad_10">


@miniCart@
@rightMenu@

@php
	  if($GLOBALS['SysValue']['nav']['path'] != "news"){
      echo '
	  <div class="leftmenu_name">Новости</div>
      <div class="leftmenu_cont">@miniNews@</div>

';
	 }
 php@

<div class="leftmenu_name">Рассылка</div>
<div class="leftmenu_cont">
  <FORM name="forma_news"  method="post" action="/news/">
      <table cellpadding="0" cellspacing="0">

  <TR>
  <td>
<INPUT style="WIDTH: 150px;" onfocus="this.value=''" value="E-mail..." name="mail" mailmaxlength="50"> 
            <input type="button" value="Отправить" onclick="NewsChek()"><br>
			<INPUT type=radio CHECKED value=1 
                        name=status>Подписаться <INPUT type=radio value=0 
                        name=status>Отказаться <INPUT type=hidden value=ok 
                        name=news_plus>
           </TD>
  </table>
  </FORM>
</div>

</div>
</div>

<div id="center">
	@DispShop@@getPhotos@
	@banersDisp@
</div>
			
		</div>
		
		<div id="content_2"></div>


<div id="footer">
	<div>&copy; @company@. Все права защищены.<br>Работает под управлением <a href="http://www.phpshopcms.ru/" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a></div>
	<div class="pad_5"><img src="images/feed.gif" alt="" width="16" height="16" border="0" align="absmiddle"> <a href="/rss/" title="RSS">RSS</a><span>|</span><a href="/map/">Карта сайта</a></div>
</div>		
			
	</div>
	
	</div>

</div>
<br><br>
</BODY>
</html>
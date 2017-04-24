<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>@pageTitl@</TITLE>
<META http-equiv="Content-Type" content="text-html; charset=windows-1251" />
<META name="description" content="@pageDesc@" />
<META name="keywords" content="@pageKeyw@" />
<META name="copyright" content="@pageReg@" />
<META name="engine-copyright" content="PHPSHOP.RU, @pageProduct@" />
<META name="domen-copyright" content="@pageDomen@" />
<META content="General" name="rating" />
<META name="ROBOTS" content="ALL" />
<LINK rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<LINK rel="icon" href="favicon.ico" type="image/x-icon" />
<LINK href="@pageCss@" type="text/css" rel="stylesheet" />
<SCRIPT language="JavaScript1.2" src="java/java2.js"></SCRIPT>
<SCRIPT language="JavaScript" src="tagcloud/swfobject.js"></SCRIPT>
<SCRIPT type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/script.js"></SCRIPT>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/ga.js" charset="utf-8"></script>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/injected.js" charset="utf-8"></script>
</HEAD>
<BODY>

		<div class="main"><div class="main-width">
	
		<div class="header">
				
			<div class="main-menu"><div class="bgr01"><div class="bgr02">
				<div class="menu"><ul><li><a href="/" title="Главная"><span><span>Главная</span></span></a></li>
@topMenu@

</ul></div>
				<div class="clear"></div>
				<div class="search">
					<div class="indent">
						<form method="post" name="forma_search" action="/search/" onSubmit="return SearchChek()">
	<input type="text" class="text" value="" name="words" id="mod_search_searchword" maxlength="20" alt="Поиск"><input class="but" type="image" src="images/search.gif" value="submit">
</form>
					</div>
				</div>
				
			</div></div></div>
			
			<div class="logo">
				<div class="indent">
					<h1><a href="http://www.phpshopcms.ru/" title="@name@">@name@</a></h1>
<div id="slogan-text" class="art-logo-text">@pageDesc@</div>
				</div>
			</div>
			
		</div>
		
		<div class="content"><div class="content-bgr"><div class="corner-left-bot"><div class="corner-right-bot"><div class="column-left">
	@skinSelect@	
<div class="widget"><div class="widget-bg">

					<div class="title">

						<h2>Каталог статей</h2>
					</div>
<ul>
                      @mainMenuPage@
                    </ul>
	</div></div>
<div class="widget"><div class="widget-bg">
<div class="title">
<h2>Навигация</h2>
</div>
<ul>
<li><a href="/news/" title="Новости"><span>Новости</span></a></li>
<li><a href="/gbook/" title="Отзывы"><span>Отзывы</span></a></li>
<li><a href="/links/" title="Полезные ссылки"><span>Полезные ссылки</span></a></li>
<li><a href="/forma/" title="Форма связи"><span>Форма связи</span></a></li>
<li><a href="/map/" title="Карта сайта"><span>Карта сайта</span></a></li>
@mainMenuPhoto@
</ul>
</div></div>
@leftMenu@
@oprosDisp@
@cloud@



					
</div>
<div class="column-right">
@rightMenu@
</div>

<div class="column-center">

							<div class="post-1 post hentry category-adipiscing-aliquet category-aliquam-dapibus-tincid category-dignissim-pulvinar-ac category-euismod-in-auctor-ut category-lobortis-quis-lobortis category-mi-aliquet-sit-amet category-nulla-venenatis-in-pede category-praesent-justo-dolor category-sed-in-lacus-ut-enim category-vestibulum-sed-ante" id="post-1">
					
					<div class="indent">
						
						<div class="title"><div class="bgr">
@mainContentTitle@
						
						</div></div>
						
						<div class="text-box">
@mainContent@
<h2 class="art-postheader"> Новости</h2>
<div class="art-postcontent">
<!-- article-content -->
@miniNews@
<span class="article_separator">&nbsp;</span>
<!-- /article-content -->
</div>
@banersDisp@
</div>	

									
						<div class="link-edit"></div>
					</div>
					
				</div>

		
			
			</div>
		
		</div></div></div></div>
		
	</div></div>
	
	<div class="footer">
		<div class="indent">
<p>Copyright &copy; @company@ Все права защищены.<br />
              Работает под управлением <a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a>.</p>
<p class="art-page-footer"><a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a></p>
		</div>
	</div>

</body></html>

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
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link href="@pageCss@" type="text/css" rel="stylesheet" />
<script language="JavaScript1.2" src="java/java2.js"></script>
<script language="JavaScript" src="/tagcloud/swfobject.js"></script>
<script language="JavaScript1.2" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/XHTMLpressbutt.js"></script>
<script language="JavaScript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jscript_jquery-1.4.min.js"></script>
<script language="JavaScript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jscript_xdarkbox.js"></script>
<script language="JavaScript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jscript_zhover-image.js"></script>
<script language="JavaScript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@javascript/jscript_zjquery.faded.js"></script>
<style type="text/css">
	.wrapp,
	.navSplitPagesLinks a,
	.navSplitPagesLinks strong,
	.tie2,
	.tie,
	.tie3,
	.image,
	.stock,
	.box-body,
	.cart .inner,
	.cart,
	.cart .one,
	#cartEmptyText,
	.menu,
	#header .menu ul{ behavior:url(includes/templates/theme524/PIE.php)}
</style>
<script type="text/javascript">
	$(function(){
		$("#faded").faded({
		speed: 800,
		bigtarget: false,
		autoplay: 6000,
		autorestart: false,
		autopagination:true,
		crossfade:true
		});
	});
</script>
<script type="text/javascript" src="chrome-extension://nhgcieglcpdegkhamigiokdphfhhnlhh/js/injected.js" charset="utf-8"></script>
</head>
<body id="indexBody">
<div class="main-width">
	<div class="wrapp">
<div id="header">
		<div class="wrapper box1">
			<div class="logo">

					<a href="http://www.phpshopcms.ru">@name@</a>
<div>@pageDesc@</div>
		
			</div>
			<div class="fright">
				<div class="navigation">
					
				</div>
				<div class="clear"></div>
				<div class="search">

					<form method="post" name="forma_search" action="/search/" onsubmit="return SearchChek()">
<div>

<input name="words" id="mod_search_searchword" maxlength="20" alt="Search" class="input1" type="text" size="20" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
<input type="image" src="images/search.gif" alt="Search" title=" Search " class="input2">
</div>
</form>

</div>
			</div>
		</div>
		<div class="wrapper box2">
			<div class="menu">
<div id="navEZPagesTop"> 
  <ul> 
     
<li> 
<a href="/" title="Главная"><span><span>Главная</span></span></a> 
</li> 
@topMenu@
  </ul> 
</div>
</div>
		</div>
	</div>   

<table border="0" cellspacing="0" cellpadding="0" width="100%" id="contentMainWrapper">
	<tbody><tr>
    
				
<td id="column-left" style="width:220px;">
<div style="width:220px;">

 <div class="box"  style="width:220px;">
<div class="box-head">
<div class="box-left"></div>
<div class="box-right"></div>
Каталог
</div>
<div class="box-body">
<ul>@mainMenuPage@</ul>
</div> 
</div>
<div class="box"  style="width:220px;">
<div class="box-head">
<div class="box-left"></div>
<div class="box-right"></div>
Навигация
</div>
<div class="box-body">
<div class="sideBoxContent">
<ul>
<li class="item40" id="current"><a href="/news/"><span>Новости</span></a></li>
<li class="item40" id="current"><a href="/gbook/"><span>Отзывы</span></a></li>
<li class="item40" id="current"><a href="/links/"><span>Полезные ссылки</span></a></li>
<li class="item40" id="current"><a href="/forma/"><span>Форма связи</span></a></li>
<li class="item40" id="current"><a href="/map/"><span>Карта сайта</span></a></li>
@mainMenuPhoto@
</ul>
</div>
</div> 
</div>
@oprosDisp@
@leftMenu@
@cloud@

                </div>
            </td>
            
			
		
            <td id="column-center" valign="top">
				            	<div class="bnrs">
 	<div class="banners" id="faded">
			<div class="inner">	
						<div >

												
							<div id="bannerOne" class="ban"><a href="/"><img src="images/banner1.jpg" alt="BrightView SPECT" title=" BrightView SPECT " width="460" height="378"></a></div>

						</div>
						<div >

															<div id="bannerTwo" class="ban"><a href="/"><img src="images/banner2.jpg" alt="GE Dash 3000 Pro" title=" GE Dash 3000 Pro " width="460" height="378"></a></div>

						</div>
						<div >

															<div id="bannerThree" class="ban"><a href="/"><img src="images/banner3.jpg" alt="Mindray BC-2800" title=" Mindray BC-2800 " width="460" height="378"></a></div>

						</div>
			</div>


</div>
	
 </div>
				                
                
            
                <div class="column-center-padding">

						<div class="centerColumn" id="indexDefault">



<div id="indexDefaultMainContent"></div>

<div class="centerBoxWrapper" id="featuredProducts">

	  <h2 class="centerBoxHeading">@mainContentTitle@</h2>
	  
    <div class="centerBoxContentsFeatured centeredContent back" style="width:100%;"><div class="product-col">
				<div class="inner">
@mainContent@
<br />
<h2>Новости</h2>
@miniNews@
<br />
@banersDisp@ 
</div>
</div></div>
<br class="clearBoth">

</div>
</div>                    
<div class="clear"></div>
</div>
</td>
			
<td id="column_right" style="width:220px">
    
<div style="width:220px;">
@skinSelect@@rightMenu@
</div>
</td>
</tr>
</tbody></table>

	<div id="footer">
		<div class="wrapper">
			<div class="fleft">

				<div class="copyright">
Copyright &copy; @company@ Все права защищены. Работает под управлением <a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a>.
				</div>
			</div>

		</div>
		<div><!-- {%FOOTER_LINK} --></div>
	</div>


    </div>
</div>
</body></html>

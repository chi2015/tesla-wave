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
<LINK rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<LINK rel="icon" href="/favicon.ico" type="image/x-icon" />
<LINK href="@pageCss@" type="text/css" rel="stylesheet" />
<SCRIPT language="JavaScript1.2" src="java/java2.js"></SCRIPT>
<SCRIPT language="JavaScript" src="/tagcloud/swfobject.js"></SCRIPT>
<!--[if IE 6]><LINK rel="stylesheet" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/template.ie6.css" type="text/css" media="screen" /><![endif]-->
<!--[if IE 7]><LINK rel="stylesheet" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/template.ie7.css" type="text/css" media="screen" /><![endif]-->
<SCRIPT type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@js/script.js"></SCRIPT>
</HEAD>
<body class="home blog" onLoad="pressbutt_load('@pageNameId@')">
<div id="art-page-background-glare" style="zoom: 1; ">
    <div id="art-page-background-glare-image"> </div>
</div>
<div id="art-main">
    <div class="art-header">
        <div class="art-header-clip">
        <div class="art-header-center">
            <div class="art-header-png"></div>
            <div class="art-header-jpeg"></div>
        </div>
        </div>
    <div class="art-header-wrapper">
    <div class="art-header-inner">
        <div class="art-logo">

            <h1 id="name-text" class="art-logo-name"><a href="http://www.phpshopcms.ru/" title="@name@">@name@</a></h1> 
                 <h2 class="art-logo-text">@pageDesc@</h2>
                </div>
    </div>
    </div>
    </div>
    <div class="cleared reset-box"></div>
    <div class="art-nav">
    	<div class="art-nav-l"></div>
    	<div class="art-nav-r"></div>
        <div class="art-nav-outer">
        <div class="art-nav-wrapper">
        <div class="art-nav-inner">

 <ul class="art-hmenu">
          <li class="item28"><a href="/" title="Главная"><span class="l"> </span><span class="r"> </span><span class="t">Главная</span></a></li>
<li class="art-hmenu-li-separator"><span class="art-hmenu-separator"> </span></li>
@topMenu@
        </ul>

        </div>
        </div>
        </div>
    </div>
    <div class="cleared reset-box"></div>
    <div class="art-sheet">
        <div class="art-sheet-tl"></div>
        <div class="art-sheet-tr"></div>
        <div class="art-sheet-bl"></div>
        <div class="art-sheet-br"></div>
        <div class="art-sheet-tc"></div>
        <div class="art-sheet-bc"></div>
        <div class="art-sheet-cl"></div>
        <div class="art-sheet-cr"></div>
        <div class="art-sheet-cc"></div>
        <div class="art-sheet-body">
<div class="art-content-layout">
    <div class="art-content-layout-row">
        <div class="art-layout-cell art-sidebar1">
         <div class="art-layout-glare">
          <div class="art-layout-glare-image"></div>
         </div>
          
<div class="art-block">
    <div class="art-block-tl"></div>
    <div class="art-block-tr"></div>
    <div class="art-block-bl"></div>
    <div class="art-block-br"></div>
    <div class="art-block-tc"></div>
    <div class="art-block-bc"></div>
    <div class="art-block-cl"></div>
    <div class="art-block-cr"></div>
    <div class="art-block-cc"></div>
    <div class="art-block-body"><div class="art-blockheader">
    <div class="l"></div>
    <div class="r"></div>
    <h3 class="t">Поиск</h3>
</div><div class="art-blockcontent">
    <div class="art-blockcontent-tl"></div>
    <div class="art-blockcontent-tr"></div>
    <div class="art-blockcontent-bl"></div>
    <div class="art-blockcontent-br"></div>
    <div class="art-blockcontent-tc"></div>
    <div class="art-blockcontent-bc"></div>
    <div class="art-blockcontent-cl"></div>
    <div class="art-blockcontent-cr"></div>
    <div class="art-blockcontent-cc"></div>
    <div class="art-blockcontent-body">
  <form method="post" name="forma_search" action="/search/" onSubmit="return SearchChek()">
                      <div class="search">
                        <input name="words" id="mod_search_searchword" maxlength="20" alt="Поиск" class="inputbox" type="text" size="23" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
<span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input class="art-button" type="submit" name="search" value="Искать">
        </span>
                      </div>
                    </form>
		<div class="cleared"></div>
    </div>
</div>		<div class="cleared"></div>
    </div>
</div>
@skinSelect@
<div class="art-block">
    <div class="art-block-tl"></div>
    <div class="art-block-tr"></div>
    <div class="art-block-bl"></div>
    <div class="art-block-br"></div>
    <div class="art-block-tc"></div>
    <div class="art-block-bc"></div>
    <div class="art-block-cl"></div>
    <div class="art-block-cr"></div>
    <div class="art-block-cc"></div>
    <div class="art-block-body"><div class="art-blockheader">
    <div class="l"></div>
    <div class="r"></div>
    <h3 class="t">Каталог статей</h3>
</div>
                <div class="art-blockcontent">
                  <div class="art-blockcontent-tl"></div>
                  <div class="art-blockcontent-tr"></div>
                  <div class="art-blockcontent-bl"></div>
                  <div class="art-blockcontent-br"></div>
                  <div class="art-blockcontent-tc"></div>
                  <div class="art-blockcontent-bc"></div>
                  <div class="art-blockcontent-cl"></div>
                  <div class="art-blockcontent-cr"></div>
                  <div class="art-blockcontent-cc"></div>
                  <div class="art-blockcontent-body">
                    <!-- block-content -->
                    <ul class="menu">
                      @mainMenuPage@
                    </ul>
                    <!-- /block-content -->
                    <div class="cleared"></div>
                  </div>
                </div>
          <div class="cleared"></div>
        </div>
</div>
<div class="art-block">
    <div class="art-block-tl"></div>
    <div class="art-block-tr"></div>
    <div class="art-block-bl"></div>
    <div class="art-block-br"></div>
    <div class="art-block-tc"></div>
    <div class="art-block-bc"></div>
    <div class="art-block-cl"></div>
    <div class="art-block-cr"></div>
    <div class="art-block-cc"></div>
    <div class="art-block-body"><div class="art-blockheader">
    <div class="l"></div>
    <div class="r"></div>
    <h3 class="t">Навигация</h3>
</div>
     <div class="art-blockcontent">
                  <div class="art-blockcontent-tl"></div>
                  <div class="art-blockcontent-tr"></div>
                  <div class="art-blockcontent-bl"></div>
                  <div class="art-blockcontent-br"></div>
                  <div class="art-blockcontent-tc"></div>
                  <div class="art-blockcontent-bc"></div>
                  <div class="art-blockcontent-cl"></div>
                  <div class="art-blockcontent-cr"></div>
                  <div class="art-blockcontent-cc"></div>
                  <div class="art-blockcontent-body">
                    <!-- block-content -->
                    <ul class="menu">
					  <li class="parent item11"><a href="/news/" title="Новости"><span>Новости</span></a></li>
                      <li class="parent item11"><a href="/gbook/" title="Отзывы"><span>Отзывы</span></a></li>
                      <li class="parent item11"><a href="/links/" title="Полезные ссылки"><span>Полезные ссылки</span></a></li>
                      <li class="parent item11"><a href="/forma/" title="Форма связи"><span>Форма связи</span></a></li>
                      <li class="parent item11"><a href="/map/" title="Карта сайта"><span>Карта сайта</span></a></li>
                      @mainMenuPhoto@
                    </ul>
                    <!-- /block-content -->
                    <div class="cleared"></div>
                  </div>
                </div>
                <div class="cleared"></div>
              </div>
            </div>
@leftMenu@
@oprosDisp@
@cloud@

          <div class="cleared"></div>
        </div>

        <div class="art-layout-cell art-content">
		


			<div class="art-post post-27 post type-post status-publish format-standard hentry category-rubrika-6 tag-wordpress tag-shablony" id="post-27">
	    <div class="art-post-tl"></div>
	    <div class="art-post-tr"></div>
	    <div class="art-post-bl"></div>
	    <div class="art-post-br"></div>
	    <div class="art-post-tc"></div>
	    <div class="art-post-bc"></div>
	    <div class="art-post-cl"></div>
	    <div class="art-post-cr"></div>
	    <div class="art-post-cc"></div>
	    <div class="art-post-body">
	            <div class="art-post-inner art-article">
	            <!-- article-content -->
                    <span class="breadcrumbs pathway"><a class="pathway" href="/" title="Главная">Главная</a></span>
                    <!-- /article-content -->
	@DispShop@
@getPhotos@
@banersDisp@
	               	            </div>
			<div class="cleared"></div>
	    </div>

 
	</div>
	
          <div class="cleared"></div>

   </div>
        <div class="art-layout-cell art-sidebar2">
      
          <div class="cleared"></div>
@rightMenu@
        </div>
    </div>
</div>
<div class="cleared"></div>
    <div class="art-footer">
                <div class="art-footer-t"></div>
                <div class="art-footer-l"></div>
                <div class="art-footer-b"></div>
                <div class="art-footer-r"></div>
                <div class="art-footer-body">
                


                   <a href="/rss/" class="art-rss-tag-icon" title="RSS"></a>
                            <div class="art-footer-text">
<p><a href="http://demo.skinwp.ru/?wptheme=business_for_sale_1#">
 <p>Copyright &copy; @company@ Все права защищены.<br />
              Работает под управлением <a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a>.</p>
                            </div>
                    <div class="cleared"></div>
                </div>
            </div>
    		<div class="cleared"></div>
        </div>
    </div>
    <div class="cleared"></div>
    <p class="art-page-footer"><a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a></p>
</div>
</body></html>
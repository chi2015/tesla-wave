<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
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
<link rel="stylesheet" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/template_css.css" type="text/css" />
<link href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@ja_splitmenu/ja-splitmenu.css" rel="stylesheet" type="text/css" />
<SCRIPT language="JavaScript1.2" src="java/java2.js"></SCRIPT>
<script language="JavaScript" src="/tagcloud/swfobject.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@scripts/ja.script.js"></script>
<script type="text/javascript" src="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47); php@scripts/opacity.js"></script>
</head>
<body class=" cms-index-index cms-home">
<div class="right-taling"></div>
<div class="main-container">
    <div class="header-container"><div class="header">
    <div class="page">        
        <div class="header-top-block">
        	<div class="right-col ">
<form id="search_mini_form" method="post" name="forma_search" action="/search/" onsubmit="return SearchChek()">
    <div class="form-search">
        <label for="search">Поиск:</label>
<input name="words" id="mod_search_searchword" maxlength="20" alt="Я ищу..." class="input-text" type="text" size="22" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
        <button type="submit" title="Искать" class="button"><span><span>Искать</span></span></button>
    </div>
</form>
                                 
            </div>
            <div class="left-col">
            	                <h1 class="logo"><strong>@name@</strong><a href="/" title="@name@" class="logo">@name@</a>
<br>@pageDesc@
</h1>
                            </div>			
            <div class="clear"></div>
        </div>               
    </div>
    <div class="header-wrapper">
        <div class="page">
            <div class="header-indent">
                <div class="menu-block">
                    <div class="border-left">
                        <div class="border-right">
                            <div class="corner-left-top">
                                <div class="corner-right-top">
                                    <div class="nav-container">
    <ul id="nav">
<li><a href="/"><span>Главная</span></a></li>
@topMenu@
</ul>
</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="message-block">
                    <div class="border-bot">
                        <div class="border-left">
                            <div class="border-right">
                                <div class="corner-left-top">
                                    <div class="corner-right-top">
                                        <p class="welcome-msg"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>			
        </div>
    </div>
    </div></div>
    <div class="content-wrapper">    
        <div class="page">        
            <div class="main-container col2-right-layout">
                <div class="main">
                    <div class="content-block">
                     <div class="border-right">
                         <div class="corner-left-top">
                            <div class="corner-right-top">                        
                                <div class="full-width">
									                                    <div class="contant-indent">
                                        <div class="col-main">
                                                                                        <div class="std"><div class="clear"></div>
<a href="/"><img src="images/banner_1.jpg" alt="" class="banner-indent"></a></div><div class="products-new">
    <div class="content-block-3">  
						<div class="page-title">
							<div class="border-left">
							  <div class="border-right">
								<div class="corner-left-top">
									<div class="corner-right-top">
										<div class="border-bot">    	<h2 class="subtitle">@mainContentTitle@</h2>
    </div>
									</div>
								</div>
							</div>
						</div>        
					  </div>
					<div class="block-content">
					  <div class="border-bot">
						  <div class="border-left">
							   <div class="border-right">
								   <div class="left-bot">
									  <div class="right-bot"> 
    <div class="full-width">
<div class="cont">@mainContent@
<br><h3>Последние новости</h3>
<br>
@miniNews@
<br>
@banersDisp@
</div>
                         </div> 
     </div>
									   </div>
								   </div>
							   </div>
						   </div>
					   </div>
					</div>
         
</div>    
                                        </div>
                                        
<div class="col-right sidebar">
<div class="block">
        <div class="block-title">
    	<div class="border-left">
						<div class="border-right">
							<div class="corner-left-top">
								<div class="corner-right-top">                            

<div class="border-bot"><strong><span>Навигация</span></strong></div>
								</div>
							</div>
						</div>
					</div>    </div>
    <div class="block-content">
    	<div class="border-left">
						<div class="border-right">
							<div class="left-bot">
								<div class="right-bot">
@mainMenuPage@
<a href="/news/" title="Новости" class="mainlevel"><span>Новости</span></a>
<br><a href="/gbook/" title="Отзывы" class="mainlevel"><span>Отзывы</span></a>
<br><a href="/links/" title="Полезные ссылки" class="mainlevel"><span>Полезные ссылки</span></a>
<br><a href="/forma/" title="Полезные ссылки" class="mainlevel"><span>Форма связи</span></a>
<br><a href="/map/" title="Карта сайта" class="mainlevel"><span>Карта сайта</span></a>
<br>@mainMenuPhoto@
                	</div>
							</div>
						</div>
					</div>    </div>
</div>

@skinSelect@
@leftMenu@
@rightMenu@

<div class="block">
<div class="block-title">
<div class="border-left">
<div class="border-right">
<div class="corner-left-top">
<div class="corner-right-top">                            
<div class="border-bot"><strong><span>Голосования</span></strong></div>
</div>
</div>
</div>
</div>
</div>
<div class="block-content">
<div class="border-left">
<div class="border-right">
<div class="left-bot">
<div class="right-bot">
@oprosDisp@
</div>
</div>
</div>
</div>
</div>
</div>
@cloud@

</div>
                                        <br class="clear">
                                    </div>
                   				 </div>                            
                             </div>
                         </div>
                      </div>
                  </div>                    
                </div>
            </div>            
        </div>
    </div>
    <div class="footer-wrapper">
        <div class="page">
        	<div class="footer">
    <div class="footer-block">
        <div class="border-left">
            <div class="border-right">
                <div class="corner-left-top">	
                    <div class="corner-right-top">                
<div class="left-col">
<p id="ja-bottomline"> Наш телефон: <b>@telNum@</b><br>
      Copyright &copy; @company@. 
      Все права защищены. Работает под управлением <a href="http://www.phpshopcms.ru/" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a> </p></div>
                        <div class="clear"></div>                                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    </div>
    </div>    
</div>


</body></html>

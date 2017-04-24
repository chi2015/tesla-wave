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
<!--[if lte IE 6]>
<link rel="stylesheet" href="@php echo $GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin']; php@css/ie6.css" type="text/css" />
<![endif]-->
</head>
<body onload="pressbutt_load('@pageNameId@')" id="wrapper">
<div id="wrapper">
  <div id="wrapper_content">
    <div id="header">
      <div class="logo">
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td><h1><a href="http://www.phpshopcms.ru/" title="@name@">@name@</a></h1></td>
          </tr>
        </table>
      </div>
      <div id="pillmenu">
        <ul id="mainlevel-nav">
          <li><a href="/" class="mainlevel-nav" >Главная</a></li>
          @topMenu@
        </ul>
      </div>
      <div class="clr"></div>
      <div class="search_holder">
        <div id="search">
          <form method="post" name="forma_search" action="/search/" onsubmit="return SearchChek()">
            <div class="search">
              <input name="words" id="mod_search_searchword" maxlength="20" alt="Search" class="inputbox" type="text" size="20" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
              <input type="submit" value="Search" class="button" onclick="this.form.searchword.focus();"/>
            </div>
          </form>
        </div>
      </div>
      <div class="clr"></div>
      <div class="newsflash">
        <div class="module">
          <div>
            <div>
              <div>
                <h3>@name@</h3>
                <table class="contentpaneopen">
                  <tr>
                    <td valign="top" ><p>Перед тем, как чего-нибудь пугаться, нужно сначала посмотреть – действительно ли оно такое страшное, а то - зачем зря стараться...</p></td>
                  </tr>
                  <tr>
                    <td valign="top" ></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clr"></div>
    </div>
    <div id="content">
      <div class="middle">
        <div class="bottom">
          <div class="top">
            <div id="holder">
              <div id="leftcolumn">
                <div class="module_menu">
                  <div>
                    <div>
                      <div>
                        <h3>Каталог</h3>
                        <ul class="menu">
                          @mainMenuPage@
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="module_menu">
                  <div>
                    <div>
                      <div>
                        <h3>Навигация</h3>
                        <ul class="menu">
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
                </div>
                @oprosDisp@
                @leftMenu@
                @cloud@ <br />
                <br />
              </div>
              <div id="maincolumn"> @DispShop@ </div>
              <div id="rightcolumn">@skinSelect@@rightMenu@</div>
              <div class="clr"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="footer">Copyright &copy; @company@ Все права защищены. Работает под управлением <a href="http://www.phpshopcms.ru/" class="sgfooter" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a>.</div>
  </div>
</div>
</body>
</html>

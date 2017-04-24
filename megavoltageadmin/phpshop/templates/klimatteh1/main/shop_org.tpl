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
<script type="text/javascript">
var currentFontSize = 3;
</script>
<!--[if lte IE 6]>
<style type="text/css">
.clearfix {	height: 1%;}
</style>
<![endif]-->
<!--[if gte IE 7.0]>
<style type="text/css">
.clearfix {	display: inline-block;}
</style>
<![endif]-->
<!--[if IE]>
<style type="text/css">
div#ja-leftcol .moduletable .catalog {text-indent: -15px;}
</style>
<![endif]-->
<!--[if lt IE 7]>
<![if gte IE 5.5]>
<script type="text/javascript" src="java/fixpng.js"></script>
<style type="text/css">
div#ja-leftcol .moduletable .catalog {text-indent: -15px;}
.iePNG, IMG { filter:expression(fixPNG(this)); } 
.iePNG A { position: relative; }/* стиль для нормальной работы ссылок в элементах с PNG-фоном */
</style>
<![endif]>
<![endif]-->
</head>
<body id="bd" class="wide fs3" onload="pressbutt_load('@pageNameId@')">
<div id="ja-wrapper">
  <div id="ja-mainnav">
    <ul id="ja-splitmenu" class="mainlevel">
      <li><a href="/"><span>Главная</span></a></li>
      @topMenu@
    </ul>
  </div>
  <div id="ja-header" class="clearfix">
    <h1> <a href="../">
      <script type="text/javascript">
od_displayImage('sitelogo', 'images/logo-bellatrix', 930, 70, '', '@pageTitl@');
</script>
      </a> </h1>
  </div>
  <div id="ja-pathway"></div>
  <div id="ja-container" class="clearfix">
    <div id="ja-mainbody">
      <div id="ja-contentwrap">
        <div id="ja-content">
          <table class="blog" cellpadding="0" cellspacing="0">
            <tr>
              <td valign="top"><div>
                  <table class="contentpaneopen">
                    <tr>
                      <td valign="top" colspan="2"> @DispShop@@getPhotos@ <br>
                        @banersDisp@ </td>
                    </tr>
                  </table>
                </div></td>
            </tr>
          </table>
        </div>
      </div>
      <div id="ja-leftcol">
        <div class="moduletable">
          <h3>Поиск</h3>
          <form method="post" name="forma_search" action="/search/" onsubmit="return SearchChek()">
            <table cellpadding="0" cellspacing="0" border="0" class="moduletable2" width="100%">
              <tr>
                <td valign="top"><input name="words" id="mod_search_searchword" maxlength="20" alt="Я ищу..." class="inputbox" type="text" size="22" value="Я ищу..."  onblur="if(this.value=='') this.value='Я ищу...';" onfocus="if(this.value=='Я ищу...') this.value='';" />
                </td>
                <td valign="middle"><input type="image" src="images/search.png" name="go"></td>
              </tr>
            </table>
          </form>
        </div>
        <div class="moduletable">
          <h3>Навигация</h3>
          @mainMenuPage@
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr align="left">
              <td><a href="/news/" title="Новости" class="mainlevel"><span>Новости</span></a></td>
            </tr>
            <tr align="left">
              <td><a href="/gbook/" title="Отзывы" class="mainlevel"><span>Отзывы</span></a></td>
            </tr>
            <tr align="left">
              <td><a href="/links/" title="Полезные ссылки" class="mainlevel"><span>Полезные ссылки</span></a></td>
            </tr>
            <tr align="left">
              <td><a href="/forma/" title="Полезные ссылки" class="mainlevel"><span>Форма связи</span></a></td>
            </tr>
            <tr align="left">
              <td><a href="/map/" title="Карта сайта" class="mainlevel"><span>Карта сайта</span></a></td>
            </tr>
          </table>
          <div style="padding-top:6px">@mainMenuPhoto@</div>
        </div>
        @skinSelect@
        
        @leftMenu@
        <div class="moduletable">
          <h3>Новости</h3>
          @miniNews@ </div>
      </div>
    </div>
    <div id="ja-rightcol"> @rightMenu@
      <div class="moduletable">
        <h3>Голосования</h3>
        @oprosDisp@ </div>
      @cloud@
      <div class="moduletable">
        <h3>Подписка</h3>
        <p>
        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="moduletable3">
          <FORM name=forma_news action="../news/" method=post>
            <TR>
              <td><INPUT class=search style="FONT-SIZE: 11px; WIDTH: 150px; COLOR: #4f4f4f; FONT-FAMILY: tahoma; HEIGHT: 18px" onfocus="this.value=''" value=E-mail... name=mail mailmaxlength="50">
              </TD>
              <TD><input type="button" value="Ok" onclick="NewsChek()"></TD>
            </TR>
            <TR>
              <TD class=text_3 vAlign=center colSpan=2 height=30><INPUT type=radio CHECKED value=1 name=status>
                Подписаться
                <INPUT type=radio value=0 name=status>
                Отказаться
                <INPUT type=hidden value=ok name=news_plus>
              </TD>
            </TR>
          </FORM>
        </table>
        </p>
      </div>
    </div>
    <br>
  </div>
  <div id="ja-footer">
    <p id="ja-bottomline"> Наш телефон: <b>@telNum@</b><br>
      Copyright &copy; @company@. 
      Все права защищены. Работает под управлением <a href="http://www.phpshopcms.ru/" target="_blank" title="PHPShop CMS Free">PHPShop CMS Free</a> </p>
  </div>
</div>
<br>
</body>
</html>

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
<SCRIPT language="JavaScript" src="tagcloud/swfobject.js"></SCRIPT>

<!--[if lt IE 7]>
<![if gte IE 5.5]>
<script type="text/javascript" src="java/fixpng.js"></script>
<style type="text/css"> 
.iePNG, IMG { filter:expression(fixPNG(this)); } 
.iePNG A { position: relative; }/* ����� ��� ���������� ������ ������ � ��������� � PNG-����� */
</style>
<![endif]>
<![endif]-->

</HEAD>
<BODY>
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="1">
  <tr>
    <td><table width="1000" height="60" cellpadding="10" cellspacing="0" border="1">
        <tr>
          <td width="34%"><div style="padding-bottom: 10px"><a href="http://@serverName@" title="@name@">@name@</a></div></td>
          <td width="34%"><div style="padding-bottom: 10px"><a href="mailto:@mail@" title="@mail@">��� �����</a></div></td>
          <td width="34%">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="1000" cellpadding="0" cellspacing="0" border="1">
        <tr>
          <td>
            <table align="left" cellpadding="0" cellspacing="0" border="1">
              <tr>
                <td style="padding: 5px"><a href="/" title="�������">�������</a></td>
              </tr>
            </table>
			<!-- ����� �������� ���� ����� [main/top_menu.tpl] -->
			@topMenu@
            <!-- ����� �������� ���� ����� -->
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="1000" cellpadding="0" cellspacing="0" border="0">
        <tr>
		  <td width="10" bgcolor="#a0a0a0">&nbsp;</td>
          <td valign="top" width="215">
			<!-- ����� ����� ������� [main/left_menu.tpl] -->
			@skinSelect@
            <!-- ����� ����� ������� -->
            <h4 style="font-size: 15px;color: #000000">����� �� �����:</h4>
            <form method="post" name="forma_search" action="/search/" onSubmit="return SearchChek()">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td>
					<input name="words" maxLength="30" onfocus="this.value=''" value="� ���..." style="margin-right: 6px; width: 120px">
                  </td>
                  <td>
					<input type="submit" value="������" name="submit">
                  </td>
                </tr>
              </table>
            </form>
            
            <h4 style="font-size: 15px;color: #000000">������� �������</h4>
            
            <ul style="padding: 0px; margin: 0px; list-style-type: none;">
            <!-- ����� �������� ������� [catalog/catalog_forma.tpl, catalog/catalog_forma_2.tpl, catalog/catalog_forma_3.tpl, catalog/podcatalog_forma.tpl] -->
			@mainMenuPage@
			<!-- ����� �������� ������� -->
            </ul>
            
            <h4 style="font-size: 15px;color: #000000">������� ������</h4>
            
            <ul style="padding: 0px; margin: 0px; list-style-type: none;">
            <!-- ����� �������� ������ [catalog/catalog_photo_1.tpl, catalog/catalog_photo_2.tpl, catalog/catalog_photo_2_point.tpl] -->
            @mainMenuPhoto@
            <!-- ����� �������� ������ -->
            </ul>
            
            <h4 style="font-size: 15px;color: #000000">���������</h4>
            
            <ul style="padding: 0px; margin: 0px; list-style-type: none;">
              <li><a href="/news/" title="�������">�������</a></li>
              <li><a href="/gbook/" title="�������">������</a></li>
              <li><a href="/opros/" title="�������">�����</a></li>
              <li><a href="/links/" title="�������� ������">�������� ������</a></li>
              <li><a href="/map/" title="����� �����">����� �����</a></li>
              <li><a href="/forma/" title="����� �����">����� �����</a></li>
            </ul>
            
            <!-- ����� ������ ���������� ����� [main/left_menu.tpl] -->
            @leftMenu@
            <!-- ����� ������ ���������� ����� -->
            
            <!-- ����� ������ [opros/opros_forma.tpl, opros/opros_list.tpl] -->
            @oprosDisp@
            <!-- ����� ������ -->
            
            <!-- ����� ������ ����� [main/left_menu.tpl] -->
            @cloud@
            <!-- ����� ������ ����� -->
            </td>
  <td width="15" bgcolor="#a0a0a0">&nbsp;</td>
          <td valign="top" width="520">

          <!-- ����� �������� ��������� �������� -->
          <h4 style="font-size: 15px;color: #000000">@mainContentTitle@</h4>
          <!-- ����� �������� ��������� �������� -->
            
          <!-- ����� ����������� ��������� �������� -->
          <div style="padding:10px">@mainContent@</div>
          <!-- ����� ����������� ��������� �������� -->
          
          <h4 style="font-size: 15px;color: #000000">��������� �������</h4>
          
		  <!-- ����� �������� [news/news_main_mini.tpl] -->
          @miniNews@
          <!-- ����� �������� -->
          
		  <!-- ����� ������� [banner/baner_list_forma.tpl] -->
          @banersDisp@
          <!-- ����� ������� -->

          @php echo $GLOBALS["PHPShopPhotoElement"]->ListPhoto(9); php@



          </td>
		  <td width="15" bgcolor="#a0a0a0">&nbsp;</td>
          <td valign="top" width="215">
            
			<!-- ����� ������� [main/right_menu.tpl] -->
            @rightMenu@
			<!-- ����� ������� -->
            
          </td>
		  <td width="10" bgcolor="#a0a0a0">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="1000" height="100" cellpadding="10" cellspacing="0" border="1">
        <tr>
          <td>
          	<p>
              Copyright &copy; @company@.<br>
              �������: @telNum@<br>
              <a href="/rss/" title="RSS">RSS</a>
            </p>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
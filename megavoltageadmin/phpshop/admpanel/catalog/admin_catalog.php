<?
$TitlePage=__("Каталог");

function actionStart() {
    global $PHPShopLang;
    echo '
   <form method="post" name="search">
   <table  cellpadding="0" cellpadding="0" class="iconlist">
<tr>
<td>

<table cellpadding="0" cellspacing="0">
<tr>
   <td width="5"></td>
<td><span name=txtLang id=txtLang>'.__('Поиск страницы').'</span>:
	<input type=text name="words" id="words" size=50>
	<input type=button value="'.__('Показать').'" class=but3 onclick="SearchPage();">
	</td>
	<td width="10"></td>
	<td width="1" bgcolor="#ffffff"></td>
	<td width="1" class="menu_line"></td>
   <td width="5"></td>
  <td id="but360"  class="butoff" onmouseover="PHPShopJS.button_on(this)" onmouseout="PHPShopJS.button_off(this)">
  <img src="icon/folder_add.gif" alt="'.__('Новый каталог').'" title="'.__('Новый каталог').'" width="16" height="16" border="0"  onclick="NewCatalogPages()"></td>
<td width="3"></td>
  <td id="but370" class="butoff" onmouseover="PHPShopJS.button_on(this)" onmouseout="PHPShopJS.button_off(this)">
  <img src="icon/folder_edit.gif" alt="'.__('Редактировать каталог').'" title="'.__('Редактировать каталог').'" width="16" height="16" border="0" onclick="EditCatalogPages()"></td>
   <td width="5"></td>
  <td width="1" bgcolor="#ffffff"></td>
  <td width="1" class="menu_line"></td>
   <td width="3"></td>
  <td id="but350" class="butoff" onmouseover="PHPShopJS.button_on(this)" onmouseout="PHPShopJS.button_off(this)">
  <img src="icon/page_new.gif" alt="'.__('Новая страница').'" title="'.__('Новая страница').'" width="16" height="16" border="0" onclick="NewPage()">
    </td>
   <td width="3"></td>
      <td id="but380" class="butoff" onmouseover="PHPShopJS.button_on(this)" onmouseout="PHPShopJS.button_off(this)">
      <img src="icon/layout_content.gif" title="'.__('Вывод всех страниц').'" alt="'.__('Вывод всех страниц').'" width="16" height="16" border="0" onclick="AllPage()"></td>
   <td width="5"></td>
   <td>
   </td>
</tr>
</table>

</td>
</td>
</tr>
</table>
</form>
'."
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
<tr>
  <td width=\"300\" valign=\"top\" height=\"500\">
    <button class=\"pane\"><img src=img/arrow_d.gif width=7 height=7 border=0 hspace=5>".__('Каталоги')."</button>
<iframe id=interfacesWin1 src=\"catalog/tree.php\" width=\"300\" height=\"100%\"  scrolling=\"Auto\" name=\"frame1\"></iframe>

<!--табличка с управлением каталогом-->
<div align=\"center\" style=\"padding:5px\">
<table cellpadding=\"0\" cellspacing=\"0\">
  <tr>
  <td id=\"but381\" class=\"butoff\" onmouseover=\"PHPShopJS.button_on(this)\" onmouseout=\"PHPShopJS.button_off(this)\">
  <img src=\"icon/chart_organisation_add.gif\" alt=\"".__('Открыть все')."\" title=\"".__('Открыть все')."\"  width=\"16\" height=\"16\" border=\"0\"  onclick=\"window.frame1.d.openAll()\">
    </td>
    <td width=\"10\"></td>
  <td width=\"1\" bgcolor=\"#ffffff\"></td>
  <td width=\"1\" bgcolor=\"#808080\"></td>
   <td width=\"5\"></td>
  <td id=\"but382\" class=\"butoff\" onmouseover=\"PHPShopJS.button_on(this)\" onmouseout=\"PHPShopJS.button_off(this)\">
  <img src=\"icon/chart_organisation_delete.gif\" alt=\"".__('Закрыть все')."\" title=\"".__('Закрыть все')."\" width=\"16\" height=\"16\" border=\"0\" onclick=\"window.frame1.d.closeAll()\"></td>
  </tr>
</table>
</div>
<!--табличка с управлением каталогом-->


   </td>
   <td rowspan=2 valign=\"top\">
<iframe id=interfacesWin1 src=\"catalog/admin_cat_content.php\"
width=\"100%\" height=\"570\"  name=\"frame2\" frameborder=\"0\" scrolling=\"Auto\"></iframe>

</td>
</tr>
</table>
";

    writeLangFile();
}
?>
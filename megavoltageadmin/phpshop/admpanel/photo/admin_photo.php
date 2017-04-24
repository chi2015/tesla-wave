<?
$TitlePage=__("Фотогалерея");

function actionStart() {
    echo '
   <form method="post" name="search">
   <table  cellpadding="0" cellpadding="0" class="iconlist">
<tr>
<td>

<table cellpadding="0" cellspacing="0">
<tr>
   <td width="5"></td>
    <td id="but350"  class="butoff"><img name="imgLang" src="icon/photo_add.png" alt="" width="1" height="1" border="0"><img name="imgLang" src="icon/photo_add.png" alt="Новая фотография" title="Новая фотография" width="16" height="16" border="0" onmouseover="ButOn(350)" onmouseout="ButOff(350)" onclick="NewPhoto()">
    </td>
	<td width="5"></td>
  <td width="1" bgcolor="#ffffff"></td>
  <td width="1" bgcolor="#808080"></td>
   <td width="5"></td>

  <td id="but360"  class="butoff"><img name="imgLang" src="icon/picture_add.png" alt="Новый каталог" title="Новый каталог" width="16" height="16" border="0" onmouseover="ButOn(360)" onmouseout="ButOff(360)" onclick="NewPhotoCatalog()"></td>
    <td width="3"></td>
  <td id="but370" class="butoff"><img name="imgLang" src="icon/picture_edit.png" alt="Редактировать каталог фотографий" title="Редактировать каталог фотографий" width="16" height="16" border="0" onmouseover="ButOn(370)" onmouseout="ButOff(370)" onclick="EditCatalogPhoto()"></td>
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
<iframe id=interfacesWin1 src=\"photo/tree.php\" width=\"300\" height=\"100%\"  scrolling=\"Auto\" name=\"frame1\"></iframe>

<!--табличка с управлением каталогом-->
<div align=\"center\" style=\"padding:5\">
<table cellpadding=\"0\" cellspacing=\"0\">
  <tr>
  <td id=\"but381\"  class=\"butoff\"><img  name=imgLang src=\"icon/chart_organisation_add.gif\" alt=\"Открыть все\" width=\"16\" height=\"16\" border=\"0\"  onclick=\"window.frame1.d.openAll()\" onmouseover='ButOn(381)' onmouseout='ButOff(381)'>
    </td>
    <td width=\"10\"></td>
  <td width=\"1\" bgcolor=\"#ffffff\"></td>
  <td width=\"1\" bgcolor=\"#808080\"></td>
   <td width=\"5\"></td>
  <td id=\"but382\"  class=\"butoff\"><img name=imgLang src=\"icon/chart_organisation_delete.gif\" alt=\"Закрыть все\" width=\"16\" height=\"16\" border=\"0\" onclick=\"window.frame1.d.closeAll()\" onmouseover='ButOn(382)' onmouseout='ButOff(382)'></td>
  </tr>
</table>
</div>
<!--табличка с управлением каталогом-->


   </td>
   <td rowspan=2 valign=\"top\">
<iframe id=interfacesWin1 src=\"photo/admin_photo_content.php\"
width=\"100%\" height=\"570\"  name=\"frame2\" frameborder=\"0\" scrolling=\"Auto\"></iframe>

</td>
</tr>
</table>
";
}
?>
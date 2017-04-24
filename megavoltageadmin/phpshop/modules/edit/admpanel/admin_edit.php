<?
$TitlePage=__("Редактор шаблонов");

function actionStart() {
    global $PHPShopLang;
    echo  "
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" height=\"80%\">
<tr>
  <td width=\"300\" valign=\"top\" height=\"100%\">
    <button class=\"pane\"><img src=img/arrow_d.gif width=7 height=7 border=0 hspace=5>".__('Шаблоны')."</button>
<iframe id=interfacesWin1 src=\"../modules/edit/admpanel/tree.php\" width=\"300\" height=\"95%\"  scrolling=\"Auto\" name=\"frame1\"></iframe>

<div align=\"center\" style=\"padding:5px\">
<table cellpadding=\"0\" cellspacing=\"0\">
  <tr>
  <td id=\"but381\" class=\"butoff\" onmouseover=\"PHPShopJS.button_on(this)\" onmouseout=\"PHPShopJS.button_off(this)\"><img src=\"icon/chart_organisation_add.gif\" alt=\"".__('Открыть все')."\" title=\"".__('Открыть все')."\" width=\"16\" height=\"16\" border=\"0\"  onclick=\"window.frame1.d.openAll()\">
    </td>
    <td width=\"10\"></td>
  <td width=\"1\" bgcolor=\"#ffffff\"></td>
  <td width=\"1\" bgcolor=\"#808080\"></td>
   <td width=\"5\"></td>
  <td id=\"but382\"  class=\"butoff\" onmouseover=\"PHPShopJS.button_on(this)\" onmouseout=\"PHPShopJS.button_off(this)\"><img src=\"icon/chart_organisation_delete.gif\" alt=\"".__('Закрыть все')."\" title=\"".__('Закрыть все')."\" width=\"16\" height=\"16\" border=\"0\" onclick=\"window.frame1.d.closeAll()\"></td>
  </tr>
</table>
</div>
   </td>
   <td rowspan=2 valign=\"top\" height=\"100%\">".'
<script src="../modules/edit/admpanel/code.js"></script>
   <table cellpadding="0" cellpadding="0" class="iconlist" id="code_button" style="display:none">
<tr>
<td>
<table cellpadding="0" cellspacing="0">
<tr>
<td>
   <td width="3"></td>
  <td id="but383" class="butoff" onmouseover="PHPShopJS.button_on(this)" onmouseout="PHPShopJS.button_off(this)"><img src="../modules/edit/img/arrow_undo.png" alt="'.__('Правка назад').'" title="'.__('Правка назад').'" width="16" height="16" border="0" onclick="codeUndo()"></td>
<td width="3"></td>
  <td id="but383" class="butoff" onmouseover="PHPShopJS.button_on(this)" onmouseout="PHPShopJS.button_off(this)"><img src="../modules/edit/img/arrow_redo.png" alt="'.__('Правка вперед').'" title="'.__('Правка вперед').'" width="16" height="16" border="0" onclick="codeRedo()"></td>
   <td width="5"></td>
  <td width="1" bgcolor="#ffffff"></td>
  <td width="1" class="menu_line"></td>
   <td width="3"></td>
   <td id="but371" class="butoff"><img name="imgLang" src="../modules/edit/img/disk.png" alt="'.__('Сохранить').'" title="'.__('Сохранить').'" width="16" height="16" border="0" onmouseover="ButOn(371)" onmouseout="ButOff(371)" onclick="codeSave()"></td>
      <td width="5"></td>
  <td width="1" bgcolor="#ffffff"></td>
  <td width="1" class="menu_line"></td>
   <td width="3"></td>
   <td align="right" width="100%"><img align="absmiddle" src="../modules/edit/img/lightbulb.png"  width="16" height="16" border="0"> Ctrl+G - поиск в файле</td>
  
</tr>
</table>

</td>
</td>
</tr>
</table>'."
<iframe id=interfacesWin1 src=\"../modules/edit/admpanel/admin_cat_content.php\"
width=\"100%\" height=\"95%\"  name=\"frame2\" frameborder=\"0\" scrolling=\"Auto\"></iframe>

</td>

	 </div>
</tr>
</table>
";
}
?>
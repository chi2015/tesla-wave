<P align=left>
<form method="post" name="forma_gbook" onsubmit="Fchek2()">
<TABLE cellPadding=3 align=center border=0>
<TBODY>
<TR>
<TD vAlign=top>
<DIV align=left><strong>*</strong> Ваше имя:</DIV></TD>
<TD>
<DIV align=left><INPUT size=52 name=nameP></DIV></TD></TR>
<TR>
<TD vAlign=top>
<DIV  align=left<strong>*</strong> Тема:</DIV></TD>
<TD>
<DIV align=left><INPUT size=52 name=subject></DIV></TD></TR>
<TR>
<TD vAlign=top>
<DIV  align=left><strong>*</strong> Ваш e-mail:</DIV></TD>
<TD>
<DIV align=left><INPUT size=52 name=mail></DIV></TD></TR>
<TR>
<TD vAlign=top>
<DIV align=left>Телефон:</DIV></TD>
<TD>
<DIV align=left><INPUT size=52 name=tel></DIV></TD></TR>
<TR>
<TD vAlign=top>
<DIV align=left><strong>*</strong> Сообщение:</DIV></TD>
<TD>
<DIV align=left><TEXTAREA name=message rows=8 cols=40></TEXTAREA></DIV>
<DIV class="gbook_otvet"><IMG height=16 alt="" hspace=5 src="images/shop/comment.gif" width=16 align=absMiddle border=0>Данные, отмеченные <B>*</B> обязательны для заполнения.<br>
<font color="#FF0000"><strong>@Error@</strong></font>
</DIV>
<p><br></p>
<table>
<tr>
	<td><img src="phpshop/captcha2.php" alt="" border="0"></td>
</tr>
<tr>
	<td><strong>*</strong> Введите только буквы и цифры  @capColor@ цвета<br><input type="text" name="key" size="20"></td>
</tr>
</table>
<p><br></p>

</TD></TR>
<TR>
<TD></TD>
<TD>
<DIV align=right>
<INPUT style="FONT-SIZE: 90%" type=reset value=" Очистить ">
<INPUT type=button value="Отправить сообщение"  onclick="Fchek2()">
<input type="Hidden" name="send_f" value="ok">
 </DIV></TD></TR></TBODY></TABLE></FORM></P>





<div class="box"  style="width:220px;">
<div class="box-head">
<div class="box-left"></div>
<div class="box-right"></div>Голосование</div>
<div class="box-body-menu">
<div  class="sideBoxContent2">
<div class="center">
<form action="/opros/" method="post" style="margin: 0 10px;">
 
<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" class="poll">
<thead>
	<tr>
		<td style="font-weight: bold;">@oprosName@</td>
	</tr>
</thead>
	<tr>
		<td align="center">
			<table class="pollstableborder" cellspacing="0" cellpadding="0" border="0">
					@oprosContent@
										</table>
		</td>
	</tr>
	<tr>
		<td>
			<div align="center">
				<input type="submit" name="submit" class="button" value="Голосовать" />
				&nbsp;
				<input type="button" name="option" class="button" value="Итоги" onclick="document.location.href='/opros/'" />
			</div>
		</td>
	</tr>
</table>
</form>
</div>
</div>
</div> 
</div>
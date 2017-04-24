<div class="module">
			<div>
				<div>
					<div><h4>Голосование</h4>
											<form action="/opros/" method="post">
 
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center" class="poll">
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
			<div id="align">
				<input type="submit" name="submit" class="button" value="Голосовать" />
				&nbsp;
				<input type="button" name="option" class="button" value="Итоги" onclick="document.location.href='/opros/'" />
			</div>
		</td>
	</tr>
</table>
</form>					</div>
				</div>
			</div>
		</div>
<br />
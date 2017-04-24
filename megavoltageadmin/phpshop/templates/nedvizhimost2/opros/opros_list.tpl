<div class="widget"><div class="widget-bg">
<div class="title">
<h2>Голосование</h2>
</div>

                    <!-- block-content -->
                    <form action="/opros/" method="post">
                      <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" class="poll">
                        <thead>
                          <tr>
                            <td style="font-weight: bold;" align="center"> @oprosName@ </td>
                          </tr>
                        </thead>
                        <tr>
                          <td align="center"><table class="pollstableborder" cellspacing="0" cellpadding="0" border="0">
@oprosContent@
                            </table></td>
                        </tr>
                        <tr>
                          <td><div align="center">
<input type="submit" name="task_button" class="button art-button" value="Ок" />
                             
<input type="button" name="option" class="button art-button" value="Результаты" onclick="document.location.href='/opros/'" />
                            </div></td>
                        </tr>
                      </table>
                    </form>
                    <!-- /block-content -->
                    <div class="cleared"></div>
                  </div>
                </div>


<p align="left">
<form method="post" name="forma_gbook" onsubmit="Fchek2()">
  <table cellPadding="3" align="center" border="0">
    <tbody>
      <tr>
        <td vAlign="top"><div align="left"><strong>*</strong> ���� ���:</div></td>
        <td><div align=left>
            <input size="52" name="nameP" value="@php echo @$_POST[nameP]; php@">
          </div></td>
      </tr>
      <tr>
        <td vAlign="top"><div align="left"><strong>*</strong> ����:</div></td>
        <td><div align="left">
            <input size="52" name="subject" value="@php echo @$_POST[subject]; php@">
          </div></td>
      </tr>
      <tr>
        <td vAlign="top"><div  align="left"><strong>*</strong> ��� e-mail:</div></td>
        <td><div align="left">
            <input size="52" name="mail" value="@php echo @$_POST[mail]; php@">
          </div></td>
      </tr>
      <tr>
        <td vAlign="top"><div align="left">�������:</div></td>
        <td><div align="left">
            <input size="52" name="tel" value="@php echo @$_POST[tel]; php@">
          </div></td>
      </tr>
      <tr>
        <td vAlign="top"><strong>*</strong> ���������:
          </div></td>
        <td><div align="left">
            <textarea name="message" rows="8" cols="40">@php echo @$_POST[message]; php@</textarea>
          </div>
          <div class="gbook_otvet">������, ���������� <b>*</b> ����������� ��� ����������.<br>
            <font color="#FF0000"><strong>@Error@</strong></font> </div>
          <p><br></p>
          <table>
            <tr>
              <td><img src="phpshop/captcha2.php" alt="" border="0"></td>
            </tr>
            <tr>
              <td><strong>*</strong> ������� �������<br>
                <input type="text" name="key" size="20"></td>
            </tr>
          </table>
          <p><br></p></td>
      </tr>
      <tr>
        <td></td>
        <td><div align="right">
            <input style="FONT-SIZE: 90%" type=reset value=" �������� ">
            <input type=button value="��������� ���������"  onclick="Fchek2()">
            <input type="Hidden" name="send_f" value="ok">
          </div></td>
      </tr>
    </tbody>
  </table>
</FORM>
</p>

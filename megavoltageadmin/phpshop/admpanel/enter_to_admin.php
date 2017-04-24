<?php

// Настройка уровня оповещения отладчика
if (function_exists('error_reporting')) {
    if ((phpversion() * 1) >= '5.0')
        error_reporting('E_ALL & ~E_NOTICE & ~E_DEPRECATED');
    else
        error_reporting('E_ALL & ~E_NOTICE');
}

// класс проверки пользователя
class UserChek {

    var $logPHPSHOP;
    var $pasPHPSHOP;
    var $idPHPSHOP;
    var $statusPHPSHOP;
    var $mailPHPSHOP;
    var $OkFlag = 0;

    function ChekBase($table_name) {
        $sql = "select * from " . $table_name . " where enabled='1'";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
            if ($this->logPHPSHOP == $row['login']) {
                if ($this->pasPHPSHOP == $row['password']) {
                    $this->OkFlag = 1;
                    $this->idPHPSHOP = $row['id'];
                    $_SESSION['idPHPSHOP'] = $row['id'];
                    $this->statusPHPSHOP = $row['status'];
                    $this->mailPHPSHOP = $row['mail'];
                }
            }
        }
    }

    function BadUser() {
        if ($this->OkFlag == 0) {
            header("Location: /phpshop/admpanel/");
            exit("Login Error");
        }
    }

    function UserChek($logPHPSHOP, $pasPHPSHOP) {
        $this->table_name = $GLOBALS['SysValue']['base']['table_name19'];

        if (empty($this->table_name)) {
           $this->BadUser();
        }

        $this->logPHPSHOP = $logPHPSHOP;
        $this->pasPHPSHOP = $pasPHPSHOP;
        $this->ChekBase($this->table_name);
        $this->BadUser();
    }

    function BadUserForma() {
        echo'
	  <script>
	  if(confirm("Внимание ' . $this->logPHPSHOP . '!\nУ Вас недостаточно прав для выполнения данной операции.\nВернуться на предыдущую страницу?"))
	  history.back(1);
	  </script>';
    }

    function BadUserFormaWindow() {
        echo'
	  <script>
	  if(confirm("Внимание ' . $this->logPHPSHOP . '!\nУ Вас недостаточно прав для выполнения данной операции.\nЗакрыть это окно?"))
	  window.close();
	  window.close();
	  </script>';
    }

}

session_start();
$UserChek = new UserChek($_SESSION['logPHPSHOP'], $_SESSION['pasPHPSHOP']);

// Secure Fix 6.5
function RequestSearch($search) {

    // Массив для определения атаки
    $com = array("union", "document.cookie");
    $mes = '
<html>
<head>
	<title>Secure Fix 6.5</title>
<LINK href="../skins/' . $_SESSION['theme'] . '/texts.css" type=text/css rel=stylesheet>
</head>

<body bottommargin="0"  topmargin="0" leftmargin="0" rightmargin="0">
<table cellpadding="0" cellspacing="0" width="100%" height="50" id="title">
<tr bgcolor="#ffffff">
	<td style="padding:10">
	<b><span name=txtLang id=txtLang>Безопасноть под угрозой</span></b><br>
	&nbsp;&nbsp;&nbsp;<span name=txtLang id=txtLang>Укажите данные для записи в базу</span>.
	</td>
	<td align="right">
	<img src="../img/i_domainmanager_med[1].gif" border="0" hspace="10">
	</td>
</tr>
</table>
<br>
<table cellpadding="0"  cellspacing="7" width="100%" height="100%">
<tr>
	<td>
<h4 style="color:red">Внимание!!!</h4><br>Работа скрипта прервана из-за использования внутренней команды';
    $mes2 = "<br>Удалите все вхождения этой команды в водимой информации.";
    foreach ($com as $v)
        if (@preg_match("/" . $v . "/i", $search)) {
            $search = eregi_replace($v, "!!!$v!!!", $search);
            exit($mes . " " . strtoupper($v) . $mes2 . "<br><br><br><textarea style='width: 100%;height:50%'>" . $search . "</textarea><p>Команда к тексте выделена знаками !!! с обеих сторон</p>
<hr>
<div align=right>
<input type=button value=Вернуться onclick=\"history.back(1)\">
<input type=button value=Закрыть onclick=\"self.close()\">
</div>
</td>
</tr>
</table>
");
        }
}

function CheckedRules($a, $b) {
    global $UserChek;
    if ($UserChek->statusPHPSHOP < 2)
        return true;
}

$_REQUEST['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
foreach ($_REQUEST as $val)
    RequestSearch($val);
?>
<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

if($UserChek->statusPHPSHOP < 2){


$sql="select * from ".$GLOBALS['SysValue']['base']['table_name9']." where id>0";
$result=mysql_query($sql);
$num=0;
$csv="";
while($row = mysql_fetch_array($result))
    {
    $id=$row['id'];
    $mail=$row['mail'];
	$csv.="$mail;\n";
	}
  $file="users_".date("d_m_y").".csv";
  @$fp = fopen("../csv/".$file, "w+");
  if ($fp) {
  //stream_set_write_buffer($fp, 0);
  fputs($fp, $csv);
  fclose($fp);
  }
//sleep(10);
header("Location: ../csv/".$file);
}
else $UserChek->BadUserFormaWindow();

?>
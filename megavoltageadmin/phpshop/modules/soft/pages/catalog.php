<?
include("./phpshop/modules/catalog/class/readfile.class.php");

// Настройки модуля
$DB = "./UserFiles/File/".getOption();
$FileCsv = new FileCsv($DB);
$_FILEDB = $FileCsv->CreatBase();

$SysValue['other']['DispShop']=CategoryDisp($SysValue['nav']['id'],$_FILEDB);
ParseTemplate($SysValue['templates']['shop']);

?>
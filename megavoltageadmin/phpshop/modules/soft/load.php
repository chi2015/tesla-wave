<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("readcsv");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");


// Загрузка конфига
$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");


// Модуль настройки класса
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules("../");


// Файл базы 
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.soft.soft_system"));
$Base = $PHPShopOrm->select(array("filedir"));


// Подключение логики БД файлов
include("./class/readfile.class.php");
$DB = "../../../UserFiles/File/".$Base['filedir'];
$FileCsv = new FileCsv($DB);
$_FILEDB = $FileCsv->CreatBase();



// Запись в базу кол-ва загрузок
function updateLoadNum($id){
global $PHPShopModules;
$id=PHPShopSecurity::TotalClean($id,2);
$sql="select * from ".$PHPShopModules->getParam("base.soft.soft_load")." where id='$id'";
$result=mysql_query($sql);
$row = mysql_fetch_array($result);
$load_total =$row['load_total'];
$load_today =$row['load_today'];
$data=$row['data'];
$load_total++;

if($data!=date("d.m.y")) $load_today=1;
 else $load_today++;

if(empty($data)) $sql='INSERT INTO '.$PHPShopModules->getParam("base.soft.soft_load").'
SET id="'.$id.'",
load_total="1",
data="'.date("d.m.y").'",
load_today="1"';

else $sql="UPDATE ".$PHPShopModules->getParam("base.soft.soft_load")."
SET
load_total='$load_total',
data='".date("d.m.y")."',
load_today='$load_today'
where id='$id'";

$result=mysql_query($sql);
}

//Загрузка файла
if(!empty($_REQUEST['loadId'])){
$sorce=$_FILEDB[$_REQUEST['loadId']]['file'];
if(!empty($sorce)) updateLoadNum($_REQUEST['loadId']);
 else $sorce="/";
@header("Location: ".$sorce);
}
 else @header("Location: /");
?>
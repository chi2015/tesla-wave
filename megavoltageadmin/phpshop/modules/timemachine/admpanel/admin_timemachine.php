<?
$TitlePage="������ ��������� Time Machine";


function actionStart()
{
global $PHPShopInterface,$_classPath;
$PHPShopInterface->setCaption(array("�","5%"),array("���� ���������� ������","30%"),array("�������� �� ����","20%"),array("�������� �������","10%"));

// ��������� ������
PHPShopObj::loadClass("modules");
PHPShopObj::loadClass("date");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.timemachine.timemachine_log"));
$data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array("limit"=>"1000"));
$n=1;
if(is_array($data))
foreach($data as $row){
extract($row);
$PHPShopInterface->setRow($id,$n++,PHPShopDate::dataV($datas),PHPShopDate::dataV($magic_datas),$num);
}

$PHPShopInterface->Compile();
}
?>
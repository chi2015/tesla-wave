<?
$TitlePage="����� ��������";

function actionStart()
{
global $PHPShopInterface,$_classPath;
$PHPShopInterface->setCaption(array("��������� ��������","10%"),array("������","30%"),array("�������� �������","20%"),array("�������� �����","20%"));

// ��������� ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.soft.soft_load"));
$data = $PHPShopOrm->select(array('*'),false,array('order'=>'load_total DESC'),array("limit"=>"1000"));
if(is_array($data))
foreach($data as $row){
extract($row);
$PHPShopInterface->setRow($id,$data,'http://'.$_SERVER['SERVER_NAME'].'/page/'.$id.'.html',$load_today,$load_total);
}

$PHPShopInterface->Compile();
}
?>
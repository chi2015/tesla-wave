<?
$TitlePage=__("������");

function actionStart()
{
global $PHPShopInterface;
$PHPShopInterface->size="630,530";
$PHPShopInterface->link="opros/adm_oprosID.php";
$PHPShopInterface->setCaption(array("&plusmn;","5%"),array("��������","50%"),array("���� � ���� ���","10%"));

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);
$data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array("limit"=>"100"));
if(is_array($data))
foreach($data as $row){
extract($row);
$PHPShopInterface->setRow($id,$PHPShopInterface->icon($flag),$name,$dir);
}

$PHPShopInterface->setAddItem('opros/adm_opros_new.php');
$PHPShopInterface->Compile();
}
?>

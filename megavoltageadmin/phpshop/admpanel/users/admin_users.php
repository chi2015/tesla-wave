<?
$TitlePage=__("��������������");

// ������ ������������
$AdmUsers=array(
"0"=>"�������������",
"1"=>"�������� ����",
"3"=>"���������");

function actionStart()
{
global $AdmUsers,$PHPShopInterface;
$PHPShopInterface->size="500,400";
$PHPShopInterface->link="users/adm_userID.php";
$PHPShopInterface->setCaption(array("&plusmn;","5%"),array("������","45%"),array("���","45%"));

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);
$data = $PHPShopOrm->select(array('*'),false,array('order'=>'status'),array("limit"=>"100"));
if(is_array($data))
foreach($data as $row){
extract($row);
$PHPShopInterface->setRow($id,$PHPShopInterface->icon($enabled),$AdmUsers[$status],$login);
}

$PHPShopInterface->setAddItem('users/adm_users_new.php');
$PHPShopInterface->Compile();
}
?>

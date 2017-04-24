<?
$TitlePage=__("Банеры");

function actionStart() {
    global $PHPShopInterface;
    $PHPShopInterface->size="630,530";
    $PHPShopInterface->link="banner/adm_banerID.php";
    $PHPShopInterface->setCaption(array("&plusmn;","5%"),array("Название","50%"),array("Показов сегодня","10%"),array("Показов всего","10%"),array("Лимит показов","10%"));


// SQL
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name15']);
    $data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array("limit"=>"1000"));
    if(is_array($data))
        foreach($data as $row) {
            extract($row);

            if($date != date("d.m.y")) $count_today=0;

            $PHPShopInterface->setRow($id,$PHPShopInterface->icon($enabled),$name,$count_today,$count_all,$limit_all);
        }

    $PHPShopInterface->setAddItem('banner/adm_baner_new.php');
    $PHPShopInterface->Compile();
}
?>

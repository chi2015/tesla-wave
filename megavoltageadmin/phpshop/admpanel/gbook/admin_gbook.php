<?php
$TitlePage=__("Отзывы");

function actionStart() {
    global $PHPShopInterface;
    $PHPShopInterface->size="630,530";
    $PHPShopInterface->link="gbook/adm_gbookID.php";
    $PHPShopInterface->setCaption(array("&plusmn;","5%"),array("Дата","10%"),array("Заголовок","45%"),array("Сообщение","45%"));

    // SQL
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name7']);
    $data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array("limit"=>"1000"));
    if(is_array($data))
        foreach($data as $row) {
            extract($row);
            $PHPShopInterface->setRow($id,$PHPShopInterface->icon($enabled),PHPShopDate::dataV($date),$title,substr($question,0,150)."...");
        }

    $PHPShopInterface->setAddItem('gbook/adm_gbook_new.php');
    $PHPShopInterface->Compile();
}
?>
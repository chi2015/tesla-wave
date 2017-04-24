<?
$TitlePage=__("RSS");

function actionStart() {
    global $PHPShopInterface;
    $PHPShopInterface->size="400,480";
    $PHPShopInterface->link="rssgraber/adm_chanelsID.php";
    $PHPShopInterface->setCaption(array("&plusmn;","5%"),array("Адрес ленты","50%"),array("Заборов в день","10%"),array("Кол-во  новостей","10%"),array("Дата начала","10%"),array("Дата конца","10%"));
    
    
    // SQL
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name24']);
    $data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array('limit'=>1000));
    if(is_array($data))
        foreach($data as $row) {
            extract($row);
            if ($row['start_date'] == 0) {
                $start_date = '';
            }
            else $start_date = date( "d-m-Y",$row['start_date']);
            
            if ($row['end_date'] == 0) {
                $end_date = '';
            }
            else $end_date = date( "d-m-Y",$row['end_date']);
            
            if(($row['enabled'])=="1") {
                $checked="<img src=img/icon-activate.gif  width=\"16\" height=\"16\" alt=\"В наличии\">";
            }else {
                $checked="<img src=img/icon-deactivate.gif  width=\"16\" height=\"16\" alt=\"Отсутствует\">";
            };
            $PHPShopInterface->setRow($id,$checked,$link,$day_num,$news_num,$start_date,$end_date);
        }

    $PHPShopInterface->setAddItem('rssgraber/adm_chanels_new.php');
    $PHPShopInterface->Compile();
}
?>

<?

$TitlePage="Зарегистрированные пользователи";


function actionStart() {
    global $PHPShopInterface,$_classPath;

    $PHPShopInterface->size="530,530";
    $PHPShopInterface->link="../modules/users/admpanel/adm_usersID.php";
    $PHPShopInterface->setCaption(array("&plusmn;","5%"),array("Дата","10%"),array("Пользователь","20%"),array("Mail","20%"),array("Дополнительно","40%"));

    // Настройки модуля
    PHPShopObj::loadClass("modules");
    $PHPShopModules = new PHPShopModules($_classPath."modules/");


    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.users.users_base"));
    $PHPShopOrm->debug=false;
    $data = $PHPShopOrm->select(array('*'),$where,array('order'=>'id DESC'),array('limit'=>100));
    
    if(is_array($data))
        foreach($data as $row) {
            extract($row);

            // Дополнительные поля
            $content=unserialize($row['content']);
            $dop=null;

            if(is_array($content))
                foreach($content as $k=>$v) {
                    $name=str_replace('dop_', '', $k);
                    $dop.=$name.': '.$v.',';
                }
            $dop=substr($dop,0,strlen($dop)-1);

            
            $PHPShopInterface->setRow($id,$PHPShopInterface->icon($enabled),$date,$login,$mail,$dop);
        }

 $PHPShopInterface->Compile();
}
?>
<?php

// Пароль для проверки, рекомендуеся сменить
$chek_password=false; // Для включения заменить на true
$PASSWORD="123456";

$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");
$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");

// Настройки модуля
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// Редактор
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.timemachine.timemachine_log"));


function actionPageDateUpdate($date) {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);
    $mysql_affected_rows=0;
    $data=$PHPShopOrm->select(array('id'),false,false,array('limit'=>1000));
    if(is_array($data))
        foreach($data as $row){

        // Уникальная дата для страницы
        $page_data=$date+rand(1000,43000);

        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);
        $PHPShopOrm->update(array('date_new'=>$page_data),array('id'=>'='.$row['id']));
        $mysql_affected_rows++;
    }
    return $mysql_affected_rows;
}


// Функция обновления
function actionUpdate() {
    global $PHPShopOrm;
    $PHPShopOrm->debug=false;
    
    $date=time("U");
    $magic_date=$date+rand(1000,43000);
    
    // Обновление даты страниц
    $numPageUpdate=actionPageDateUpdate($date);
    
    // Запись в журнал
    $action = $PHPShopOrm->insert(array('date_new'=>$date,'magic_date_new'=>$magic_date,'num_new'=>$numPageUpdate));
    
    exit("Done");
}

if($chek_password) {
    if($_GET['pas']==$PASSWORD) actionUpdate();
    else exit('Fail - bad password');
} else actionUpdate();
?>
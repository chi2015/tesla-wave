<?php

$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
include($_classPath."admpanel/enter_to_admin.php");


// Настройки модуля
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// Редактор
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.catalog.catalog_system"));


// Функция обновления
function actionUpdate() {
    global $PHPShopOrm;

    $action = $PHPShopOrm->update($_POST);
    return $action;
}


function actionStart() {
    global $PHPShopGUI,$_classPath,$PHPShopOrm;

    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="Настройка модуля Catalog";
    $PHPShopGUI->size="500,500";

    // Выборка
    $data = $PHPShopOrm->select();
    @extract($data);


    // Графический заголовок окна
    $PHPShopGUI->setHeader("Настройка модуля 'Catalog'","Настройки",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");


    // Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Имя домена донора:",$PHPShopGUI->setInputText("http://: ","domain_new",$domain,250),'left');
    $Tab1.=$PHPShopGUI->setField("Количество товаров на странице:",$PHPShopGUI->setInputText(false,"limit_new",$limit,50,' не более 100'),'right',5);
    $Tab1.=$PHPShopGUI->setLine();
    $Tab1.=$PHPShopGUI->setField("Partner ID:",$PHPShopGUI->setInputText(false,"partner_new",$partner,50,' *идентификатор партнера (число). Учитывается при переходах для бонусов.'));
    $Tab1.=$PHPShopGUI->setField("URL Key:",$PHPShopGUI->setInputText(false,"url_key_new",$url_key,100,' *ключ подключения для сайта '.$_SERVER['SERVER_NAME'].'.'));
    $Tab1.=$PHPShopGUI->setField("Catalog ID:",$PHPShopGUI->setInputText(false,"left_new",$left,50,' *идентификатор каталога для вывода слева (число, /shop/CID_<b>8</b>.html)'));  
    $Tab1.=$PHPShopGUI->setField("Количество товаров слева:",$PHPShopGUI->setInputText(false,"limit_left_new",$limit_left,50));  
    $Tab1.=$PHPShopGUI->setField("Catalog ID:",$PHPShopGUI->setInputText(false,"right_new",$right,50,' *идентификатор каталога для вывода справа (число, /shop/CID_<b>8</b>.html)'));  
    $Tab1.=$PHPShopGUI->setField("Количество товаров справа:",$PHPShopGUI->setInputText(false,"limit_right_new",$limit_right,50)); 

    $Tab3=$PHPShopGUI->setPay($serial,false);
    
    $Info='Вид вывода товаров и каталогов задается в шаблонах phpshop/modules/catalog/templates/
<ul>
<li>catalog_forma.tpl - шаблон каталога
<li>catalog_list.tpl - шаблон списка каталогов
<li>product_forma.tpl - шаблон товара в блоке
<li>product_forma_full.tpl - шаблон краткого описания товара
<li>product_forma_full.tpl - шаблон подробного описания товара
</ul>
';
    $Tab2=$PHPShopGUI->setInfo($Info);
    
    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Опции",$Tab1,370),array("Шаблоны",$Tab2,370),array("О Модуле",$Tab3,370));


    

    // Вывод кнопок сохранить и выход в футер
      $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

    // Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>
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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.timemachine.timemachine_system"));


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

// Запись в журнал
function actionLogUpdate($numPageUpdate) {
    global $PHPShopModules;
    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.timemachine.timemachine_log"));
    $magic_date=$_POST['date']+$_POST['date_formula'];
    $date=time("U");
    $action=$PHPShopOrm->insert(array('date_new'=>$date,'magic_date_new'=>$magic_date,'num_new'=>$numPageUpdate,));
    return $action;
}

// Функция обновления
function actionUpdate() {
    global $PHPShopOrm;
    $PHPShopOrm->debug=false;

    // Обновление даты страниц
    $numPageUpdate=actionPageDateUpdate($_POST['date']+$_POST['date_formula']);

    // Запись в журнал
    actionLogUpdate($numPageUpdate);

    $action = $PHPShopOrm->update($_POST);
    return $action;
}




function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="Настройка модуля Time Machine";
    $PHPShopGUI->size="600,450";

// Выборка
    $data = $PHPShopOrm->select();
    @extract($data);

    $Select[]=array("Слева",0,$s1);
    $Select[]=array("Справа",1,$s2);

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Настройка модуля 'Time Machine'","Настройки подключения",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    $value[]=array('сегодня',time("U"),false);
    $value[]=array('l день назад',(time("U")-(1*86400)),false);
    $value[]=array('2 дня назад',(time("U")-(2*86400)),false);
    $value[]=array('3 дня назад',(time("U")-(3*86400)),false);
    $value[]=array('4 дня назад',(time("U")-(4*86400)),false);
    $value[]=array('5 дней назад',(time("U")-(5*86400)),false);
    $value[]=array('неделя назад',(time("U")-(6*86400)),false);

    $value2[]=array('- случайное числов в пределах 6 часов',-(rand(1,5)*rand(1000,86400)),false);
    $value2[]=array('+ 1 час',(1*86400),false);
    $value2[]=array('+ 2 часа',(2*86400),false);
    $value2[]=array('- 2 часа',-(1*86400),false);
    $value2[]=array('- 1 час',-(2*86400),false);

    // Создаем объекты для формы
    $ContentField=$PHPShopGUI->setSelect('date',$value,300);
    $ContentField2=$PHPShopGUI->setSelect('date_formula',$value2,300);

    // Содержание закладки 1
    $Tab1=$PHPShopGUI->setField('Дата изменения страницы заменить на',$ContentField);
    $Tab1.=$PHPShopGUI->setField('Формула генерации даты',$ContentField2);

    $PHPShopInterface = new PHPShopInterface();
    $PHPShopInterface->size="500,400";
    $PHPShopInterface->window=true;
    $PHPShopInterface->imgPath="../../../admpanel/img/";
    $PHPShopInterface->setCaption(array("Мин.","10%"),array("Час","10%"),array("В мес.","10%"),array("Мес.","10%"),
            array("В нед.","10%"),array("Команда","50%"));
    $PHPShopInterface->setRow(1,10,10,'*','*','*',"/usr/local/bin/php -q /home/shop.ru/phpshop/modules/timemachine/cron/timemachine.php >/dev/null 2>&1");

    $Info='Для запуска файла по расписанию через утилиту Cron следует указать путь к обработчику php и файлу-обработчику phpshop/modules/timemachine/cron/timemachine.php в настройке
Cron. Для указания пароля запуска модуля указывайте параметр ?pas=мой_пароль. Для смены пароля отредактируйте файл timemachine.php.

Пример запуска каждый день в 10.10 :';

    $Tab2=$PHPShopGUI->setTextarea("",$Info,"none",'100%',120);
    $Tab2.=$PHPShopInterface->Compile();
    $Tab2.=$PHPShopInterface->setLine('<br>');
    $Tab2.=$PHPShopGUI->setImage('../install/info.gif',16,16).$PHPShopGUI->setLink('http://ru.wikipedia.org/wiki/Cron','Инструкция по утилите Cron');

    // Форма регистрации
    $Tab3=$PHPShopGUI->setPay($serial);

    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,270),array("Описание",$Tab2,270),array("О Модуле",$Tab3,270));

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
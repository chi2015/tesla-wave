<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();


PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Редактирование Опроса";

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Вывод ответов
function dispFaq($n) {
    global $PHPShopSystem,$SysValue,$_classPath;

    // Тип окна
    if($_COOKIE['winOpenType'] == 'default')
        $dot=false;
    else $dot="./opros/";

    $PHPShopInterface = new PHPShopInterface();
    $PHPShopInterface->size="500,400";
    $PHPShopInterface->window=true;
    $PHPShopInterface->imgPath="../img/";
    $PHPShopInterface->link=$dot."adm_valueID.php";
    $PHPShopInterface->setCaption(array("Вариант ответа","50%"),array("Голоса","10%"),array("Всего","10%"));

// Выборка
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);
    $data = $PHPShopOrm->select(array('SUM(total) as sum'),array('category'=>'='.$n));
    $sum=$data['sum'];

    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);
    $data = $PHPShopOrm->select(array('*'),array('category'=>'='.$n),false,array("limit"=>"1000"));

    if(is_array($data))
        foreach($data as $row) {
            extract($row);
            $PHPShopInterface->setRow($id,$name,$total,@number_format(($total*100)/$sum,"1",".","").'%');
        }

    return $PHPShopInterface->Compile();
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    // Тип окна
    if($_COOKIE['winOpenType'] == 'default')
        $dot=false;
    else $dot="./opros/";


// Выборка
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    if($flag==1)  $fl="checked"; else  $fl2="checked";

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Опроса","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");



// Содержание закладки 1
    $Tab1=
            $PHPShopGUI->setField("Заголовок:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
            $PHPShopGUI->setField("Привязка:",$PHPShopGUI->setInput("text","dir_new",$dir,"none",400).$PHPShopGUI->setText("* Пример: /page/adres.html,news/. Можно указать несколько адресов через запятую. "),"left",5).
            $PHPShopGUI->setField("Вывод:",$PHPShopGUI->setRadio("flag_new",1,"Показать",@$fl,"none").$PHPShopGUI->setLine().
            $PHPShopGUI->setRadio("flag_new",0,'Скрыть',@$fl2),"none");


    $Tab2=dispFaq($id).$PHPShopGUI->setDiv("right",
            $PHPShopGUI->setInput("button","name_new","Новая позиция","right",150,"miniWin('".$dot."adm_value_new.php?categoryID=".$id."',500,400)").
            $PHPShopGUI->setInput("button","name_new","Обновить","right",150,"onReload();"));
           
// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350),array("Результаты",$Tab2,350));

// Запрос модуля на закладку
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

// Вывод кнопок сохранить и выход в футер
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("button","delID","Удалить","right",70,"return onDelete('".__('Вы действительно хотите удалить?')."')","but","actionDelete").
            $PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionUpdate");

// Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}


// Функция обновления
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}

// Функция удаления
function actionDelete() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));
    
    $action = $PHPShopOrm->delete(array('id'=>'='.$_POST['newsID']));
    return $action;
}



if($UserChek->statusPHPSHOP < 2) {

// Вывод формы при старте
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');

// Обработка событий 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>

<?

$TitlePage="������ �������";

$addTab='<td align="right"><form name="product_edit" id="product_edit">';
$PHPShopInterface->padding=0;

// ���������, ������� ����
if($_GET['sortdate_start']) $sortdate_start = $_GET['sortdate_start'];
 else $sortdate_start = PHPShopDate::dataV(date("U")-86400,false);

if($_GET['sortdate_end']) $sortdate_end = $_GET['sortdate_end'];
 else $sortdate_end = PHPShopDate::dataV(false,false);

$addTab.=$PHPShopInterface->setTable(
        $PHPShopInterface->setCalendar('sortdate_start',$align='left',$icon='icon/date.gif'),
        $PHPShopInterface->setInput("text","sortdate_start",$sortdate_start,"none",70),
        $PHPShopInterface->setCalendar('sortdate_end',$align='left',$icon='icon/date.gif'),
        $PHPShopInterface->setInput("text","sortdate_end",$sortdate_end,"none",70),
        $PHPShopInterface->setInput("submit","send",'�������',"none",70),
        $PHPShopInterface->setInput("hidden","plugin",'admlog',"none",70)
);
$addTab.='</form></td>';
$PHPShopInterface->padding=5;

function actionStart() {
    global $PHPShopInterface,$_classPath;


    $PHPShopInterface->setCaption(array("����","10%"),array("���","10%"),array("IP","10%"),array("������","50%"),array("����","20%"));

    // ��������� ������
    PHPShopObj::loadClass("modules");
    $PHPShopModules = new PHPShopModules($_classPath."modules/");

    // ��������� ������
    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.admlog.admlog_system"));
    $mod_option = $PHPShopOrm->select();


    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.admlog.admlog_log"));
    $PHPShopOrm->debug=false;
    if(!empty($_GET['sortdate_start'])) $where=array('date'=>' < '.(PHPShopDate::GetUnixTime($_GET['sortdate_end'])+86400).' AND date > '.(PHPShopDate::GetUnixTime($_GET['sortdate_start'])-86400));
    else $where=false;

    $data = $PHPShopOrm->select(array('*'),$where,array('order'=>'id DESC'),array('limit'=>100));

    if(!empty($mod_option['enabled'])){
    $PHPShopInterface->size="630,530";
    $PHPShopInterface->link="../modules/admlog/admpanel/adm_admlog_back.php";
    }
    
    if(is_array($data))
        foreach($data as $row) {
            extract($row);

            $PHPShopInterface->setRow($id,PHPShopDate::dataV($date),$user,$ip,$title,$file);
        }

    $PHPShopInterface->Compile();
}
?>
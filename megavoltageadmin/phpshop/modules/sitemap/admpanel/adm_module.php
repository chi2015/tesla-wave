<?
$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("date");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
include($_classPath."admpanel/enter_to_admin.php");


// ��������� ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// ��������
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.sitemap.sitemap_system"));

function sitemaptime($nowtime) {
    return PHPShopDate::dataV($nowtime, false, true);
}


// �������� sitemap
function setGeneration() {
    global $PHPShopModules;

    // ����������
    $title = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $title.= '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">' . "\n";

    // ��������
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);
    $data = $PHPShopOrm->select(array('*'),array('enabled'=>"!='0'"),array('order'=>'date DESC'));

    if(is_array($data))
        foreach($data as $row) {
            $stat_pages.= '<url>' . "\n";

            // �������� ������ Seourl
            if($PHPShopModules->getParam("base.seourl.seourl_system") != "")
                $stat_pages.= '<loc>http://'.$_SERVER['SERVER_NAME'].'/'.$row['link'].'.html</loc>' . "\n";
            else $stat_pages.= '<loc>http://'.$_SERVER['SERVER_NAME'].'/page/'.$row['link'].'.html</loc>' . "\n";

            $stat_pages.= '<lastmod>'.sitemaptime($row['date']).'</lastmod>' . "\n";
            $stat_pages.= '<changefreq>daily</changefreq>' . "\n";
            $stat_pages.= '<priority>1.0</priority>' . "\n";
            $stat_pages.= '</url>' . "\n";
        }

    // ��������
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name']);
    $data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'));

    if(is_array($data))
        foreach($data as $row) {
            $stat_cat.= '<url>' . "\n";

            // �������� ������ Seourl
            if($PHPShopModules->getParam("base.seourl.seourl_system") != "")
                $stat_cat.= '<loc>http://'.$_SERVER['SERVER_NAME'].'/cat/'.$row['seoname'].'.html</loc>' . "\n";
            else $stat_cat.= '<loc>http://'.$_SERVER['SERVER_NAME'].'/page/CID_'.intval($row['id']).'.html</loc>' . "\n";

            $stat_cat.= '<changefreq>daily</changefreq>' . "\n";
            $stat_cat.= '<priority>1.0</priority>' . "\n";
            $stat_cat.= '</url>' . "\n";
        }

    // �������
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
    $data = $PHPShopOrm->select(array('*'),false,array('order'=>'date DESC'));

    if(is_array($data))
        foreach($data as $row) {
            $stat_news.= '<url>' . "\n";

            // �������� ������ Seourl
            if($PHPShopModules->getParam("base.seourl.seourl_system") != "")
                $stat_news.= '<loc>http://'.$_SERVER['SERVER_NAME'].'/news/ID_'.strip_tags($row['seo_name']).'.html</loc>' . "\n";
            else  $stat_news.= '<loc>http://'.$_SERVER['SERVER_NAME'].'/news/ID_'.intval($row['id']).'.html</loc>' . "\n";

            $stat_news.= '<lastmod>'.sitemaptime(PHPShopDate::GetUnixTime($row['date'])).'</lastmod>' . "\n";
            $stat_news.= '<changefreq>daily</changefreq>' . "\n";
            $stat_news.= '<priority>1.0</priority>' . "\n";
            $stat_news.= '</url>' . "\n";
        }

    $sitemap=$title.$stat_pages.$stat_cat.$stat_news.'</urlset>';

    // ������ � ����
    fwrite(fopen('../../../../UserFiles/File/sitemap.xml',"w+"), $sitemap);
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    // �������� sitemap
    if(!empty($_POST['generation'])) setGeneration();

    return true;
}


// ��������� ������� ��������
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������";
    $PHPShopGUI->size="500,450";


// �������
    $data = $PHPShopOrm->select();
    @extract($data);


// ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'Sitemap'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

// ������� ������� ��� �����
    $ContentField1=$PHPShopGUI->setCheckbox("generation",1,"��������� ������������� ��������� ����� Sitemap.",false);
    $ContentField1.=$PHPShopGUI->setLine();
    $ContentField1.=$PHPShopGUI->setInput("button","","������� ���� sitemap.xml","left",150,"return window.open('../../../../UserFiles/File/sitemap.xml');","but");

    $Info="
   1. ��� ��������������� �������� sitemap.xml ���������� ������ <b>Cron</b> � ������� � ���� ����� ������ � �������
        ������������ �����  <b>phpshop/modules/sitemap/cron/sitemap_generator.php</b>
        <p>
   2. � ����������� ������� ����� http://".$_SERVER['SERVER_NAME']."/UserFiles/File/sitemap.xml
       </p>
   3. ���������� ����� CHMOD 775 �� ����� /UserFiles/File/ ��� ������ � ��� sitemap.xml";
    $ContentField2=$PHPShopGUI->setInfo($Info,130,'95%');

// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("�������� �����",$ContentField1);
    $Tab1.=$PHPShopGUI->setField("���������",$ContentField2);

    $Tab3=$PHPShopGUI->setPay($serial);

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,270),array("� ������",$Tab3,270));

// ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� �������
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>



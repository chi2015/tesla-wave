<?php
$_classPath = "../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("xml");
PHPShopObj::loadClass("admgui");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("date");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
$PHPShopBase->chekAdmin();

// ��������� ���������
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
$PHPShopInterface = new PHPShopInterface();
$PHPShopInterface->winOpenType = $PHPShopSystem->getSerilizeParam("admoption.wintype");
$PHPShopIcon = new PHPShopIcon();


define("PATH", "http://www.phpshop.ru/update/update3.php?server=" . $_SERVER["SERVER_NAME"] . "&from=cms&version=" . $SysValue['upload']['version']);
define("TIME_LIMIT", 600);

$RegTo = $SysValue['license']['regto'];
$ProductName = $SysValue['license']['product_name'];
$ProductNameVersion = $SysValue['license']['product_name'] . " (" . __('������') . " " . $SysValue['upload']['version'] . ")";


// ��������� �� root
if ($_SESSION['logPHPSHOP'] == "root" and $_SESSION['pasPHPSHOP'] == "cm9vdA==" and !getenv("COMSPEC"))
    $rootNote = "rootNote()";
else
    $rootNote = "";


// ��������� update
$support_status = false;
if (!getenv("COMSPEC") and function_exists("xml_parser_create") and !$_SESSION['chekUpdate'])
    if (@$db = readDatabase(PATH, "update")) {

        foreach ($db as $k => $v) {
            if ($db[$k]['name'] > $SysValue['upload']['version'])
                $support_status = $db[$k]['status'];
        }

        // ��������� �������� ���������� ��� ������� ������
        $_SESSION['chekUpdate'] = true;
    }


// ������������ ����
$_SESSION['theme'] = $PHPShopSystem->getSerilizeParam("admoption.theme");
if (empty($_SESSION['theme']))
    $_SESSION['theme'] = 'classic';

// ������������ ������� ��������
setcookie("winOpenType", $PHPShopSystem->getSerilizeParam("admoption.wintype"), time() + 60 * 60 * 24 * 30, "/phpshop/", $_SERVER['SERVER_NAME'], 0);
$_SESSION['winOpenType'] = $PHPShopSystem->getSerilizeParam("admoption.wintype");

// ������������ ����
$_SESSION['lang'] = $PHPShopSystem->getSerilizeParam("admoption.lang");
PHPShopObj::loadClass("lang");

// ����������� JS ���� �������
function CreateModulesMenu() {
    global $PHPShopIcon;
    $sql = "select path from " . $GLOBALS['SysValue']['base']['table_name2'];
    $result = mysql_query($sql);

    while ($row = mysql_fetch_array($result)) {
        $path = $row['path'];
        $menu = "../modules/" . $path . "/install/module.xml";
        @$data = implode("", file($menu));
        if (@$db = readDatabase($data, "adminmenu", false)) {
            $DIR = "../modules/" . $path . "/install/";
            @$dis_js.='
	  stm_aix("p1i1","p1i0",[0,"' . $db[0]['title'] . '","","",-1,-1,0,"","_self","","","img/arrow_r.gif","",7,7]);
      stm_bp("p2",[1,2,-1,0,3,3,18,0,100,"",-2,"",-2,100,2,2,"#000000",MenuColor,"",3,1,1,"#666666"]);';

            // JS ����
            $podmenu = readDatabase($data, "podmenu", false);
            foreach ($podmenu as $val)
                @$dis_js.='
stm_aix("p2i0","p1i0",[0,"' . $val['podmenu_name'] . '","","",-1,-1,0,"' . $val['podmenu_action'] . '","_self","","","' . $DIR . $val['podmenu_icon'] . '","' . $DIR . $val['podmenu_icon'] . '",16,16]);
	  ';
            @$dis_js.='stm_ep();';

            // ������
            $icon = readDatabase($data, "menu", false);



            if (is_array($icon)) {
                foreach ($icon as $val)
                    $IconTab.= $PHPShopIcon->setIcon("../modules/" . $path . "/install/" . $val['menu_icon'], $val['menu_name'], $val['menu_action']);
            }
        }
    }
    $disp = '
stm_aix("p0i1","p0i0",[1,"' . __('������') . '&nbsp;&nbsp;","","",-1,-1,0,"","_self","","","","",5,20]);
stm_bp("p1",[1,4,-1,0,3,3,16,0,100,"",-2,"",-2,100,2,2,"#000000",MenuColor,"",3,1,1,"#666666 #878480 #666666 #666666"]);
stm_aix("p10i1","p2i0",[0,"' . __('������� ������') . '","","",-1,-1,0,"http://www.phpshopcms.ru/module/","_blank","","","icon/databases_arrow.png","icon/databases_arrow.png"]);
stm_aix("p10i1","p2i0",[0,"' . __('����� ��������� �������') . '","","",-1,-1,0,"?p=modules","_self","","","icon/plugin.gif","icon/plugin.gif"]);
stm_aix("p10i1","p2i0",[0,"' . __('����������� �������') . '","","",-1,-1,0,"javascript:miniWin(\'modules/adm_modreg.php\',510,460)","_self","","","icon/key.png","icon/key.png"]);
' . @$dis_js . '
stm_ep();
stm_ep();
';
    if (is_array($icon))
        $IconTab = $PHPShopIcon->setBorder() . $IconTab;
    return array($disp, $IconTab);
}

// ��������� ���� �����������
if (!empty($_GET['p'])) {
    $fileLoad = $_GET['p'] . "/admin_" . $_GET['p'] . ".php";
    if (file_exists($fileLoad) and $UserChek->statusPHPSHOP < 2)
        require($fileLoad);
}
elseif (!empty($_GET['plugin'])) {

    $option = explode("/", $_GET['plugin']);
    if (is_array($option) and !empty($option[1]) and !strstr('.', $option[1]))
        $fileLoad = "../modules/" . $option[0] . "/admpanel/admin_" . $option[1] . ".php";
    else
        $fileLoad = "../modules/" . $_GET['plugin'] . "/admpanel/admin_" . $_GET['plugin'] . ".php";

    if (file_exists($fileLoad) and $UserChek->statusPHPSHOP < 2)
        require($fileLoad);
}
else
    require("catalog/admin_catalog.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<html>
    <head>
        <title><?= $ProductName . " -> " . __('������ ����������') . " -> " . $TitlePage; ?></title>
        <META http-equiv=Content-Type content="text/html; charset=<?= $GLOBALS['PHPShopLangCharset'] ?>">
            <META name="engine-copyright" content="PHPShop.ru">
                <LINK href="skins/<?= $_SESSION['theme'] ?>/dateselector.css" type="text/css" rel=stylesheet>
                    <script language="JavaScript1.2" src="java/phpshop.js" type="text/javascript"></script>

                    <?
                    if ($PHPShopSystem->getSerilizeParam("admoption.wintype") == "highslide") {
                        echo '<script type="text/javascript" src="java/highslide/highslide-full.packed.js"></script>
        <link rel="stylesheet" type="text/css" href="java/highslide/highslide.css" />
        <script type="text/javascript">
            hs.graphicsDir = "java/highslide/graphics/";
            hs.outlineType = "rounded-windows";
            hs.wrapperClassName = "draggable-header";
            hs.showCredits = false;
            hs.headingText = "<em style=\'font-weight:normal;font-size:10px\'>' . __('�����������������') . ' > ' . addslashes($PHPShopSystem->getParam("name")) . '</em>";
            hs.dimmingOpacity = 0.5;
            hs.dimmingDuration = 50;
        </script>';
                    }
                    ?>

                    <LINK href="skins/<?= $PHPShopSystem->getSerilizeParam("admoption.theme") ?>/texts.css" type=text/css rel=stylesheet>
                        <script type="text/javascript" language="JavaScript1.2"  src="java/popup_lib.js"></script>
                        <script type="text/javascript" language="JavaScript1.2" src="java/stm31.js"></script>
                        <script type="text/javascript" language="JavaScript1.2" src="java/dateselector.js"></script>
                        <script type="text/javascript">

                            // �������� ������ root
<?= $rootNote; ?>

                            winOpenType = '<?= $PHPShopSystem->getSerilizeParam("admoption.wintype") ?>';

                            // �� ���� �����
                            window.moveTo(0, 0);
                            window.resizeTo(screen.availWidth, screen.availHeight);

                            // �������� ����������
                            function ChekUpdate(flag) {
                                var update = "<?= $support_status; ?>";
                                var version = "<?= $SysValue['upload']['version']; ?>";
                                var path = "<?= PATH ?>";
                                var soft = "<?= $SysValue['license']['product_name'] ?>";
                                var cookieValue = GetCookie('update');
                                if (update == 'active') {
                                    window.status = "<?= __('��������! �������� ���������� ���'); ?> " + soft + " " + version;
                                    if (!cookieValue | flag == "true")
                                        if (confirm("<?= __('�������� ���������� ���'); ?> " + soft + " " + version + "\n\n<?= __('��� ��������� ���������� ��������� ������� Updater �� ������ EasyControl ��� Windows. ��������� EasyControl � ������� ������������?'); ?>")) {
                                            window.open("http://www.phpshopcms.ru/version/setup_cms.exe");
                                        }
                                }
                                else if (flag == "true")
                                    alert("<?= __('���'); ?> " + soft + " " + version + " <?= __('���������� �����������.'); ?>");
                            }

                        </script>
                        </head>
                        <body  <?= $onload ?> >
                            <table cellpadding="0" cellpadding="0" class="iconlist">
                                <tr>
                                    <td>
                                        <script type="text/javascript" language="JavaScript1.2" src="skins/<?= $PHPShopSystem->getSerilizeParam("admoption.theme") ?>/menu.js"></script>
                                        <script>
                                            // �������� ����
<?
include('java/menu.php');
?>


                                            // ������
<?
$CreateModulesMenu = CreateModulesMenu();
echo $CreateModulesMenu[0];
?>


                                            // ���������� ����
                                            stm_aix("p0i8", "p0i1", [1, "<?= __('�������������'); ?>&nbsp;&nbsp;&nbsp; "]);
                                            stm_bpx("p13", "p3", []);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('����� CMS Free'); ?>", "", "", -1, -1, 0, "javascript:window.open('http://forum.phpshopcms.ru/')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('���������� ������� ��� �����'); ?>", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshopcms.ru/doc/skins.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('������ ��������-��������'); ?> PHPShop Pro 1C", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/product5.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('������ ��������-��������'); ?> PHPShop Enterprise", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/product.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('������ ��������-��������'); ?> PHPShop Start", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/product2.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('������������ ������ � ���������� � CMS'); ?>", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/service.html#1')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_ep();
                                            stm_aix("p0i7", "p0i1", [1, "&nbsp;<?= __('C������'); ?>&nbsp;&nbsp;"]);
                                            stm_bpx("p12", "p4", []);
                                            stm_aix("p12i1", "p4i1", [0, "<?= __('�������'); ?>", "", "", -1, -1, 0, "http://www.phpshop.ru/news/", "_self", "", "", "icon/book_next.gif", "icon/book_next.gif"]);
                                            stm_aix("p12i2", "p4i1", [0, "<?= __('������� ����������'); ?>", "", "", -1, -1, 0, "javascript:ChekUpdate('true')", "_self", "", "", "icon/wand.gif", "icon/wand.gif"]);
                                            stm_aix("p12i4", "p4i1", [0, "<?= __('� ���������'); ?>", "", "", -1, -1, 0, "javascript:miniWin('about/adm_about.php',700,550)", "_self", "", "", "icon/image.gif", "icon/image.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('�����������'); ?>", "", "", -1, -1, 0, "javascript:window.close()", "_self", "", "", "icon/door.gif", "icon/door.gif"]);
                                            stm_aix("p13i1", "p2i0", [0, "<?= __('�����'); ?>", "", "", -1, -1, 0, "javascript:window.open('/')", "_self", "", "", "icon/house.gif", "icon/house.gif"]);
                                            stm_ep();
                                            stm_ep();
                                            stm_em();
                                        </script>
                                    </td>
                                    <td align="right" id="phpshop">
                                        <a href="http://www.phpshop.ru" target="_blank" class="phpshop" title="<?= __('��� ����� ��������'); ?>�PHPShop.ru">
<?= $ProductNameVersion ?></a>
                                    </td>

                                </tr>
                            </table>
                            <?
                            $Tab1 = $PHPShopIcon->setIcon("icon/open.gif", "�������", "window.location.replace('?p=catalog')") .
                                    $PHPShopIcon->setBorder() .
                                    $PHPShopIcon->setIcon("icon/joystick.gif", "�������", "miniWin('system/adm_system.php',510,450)") .
                                    $PHPShopIcon->setIcon("icon/xhtml.gif", "���������", "miniWin('system/adm_system_promo.php',500,600)") .
                                    $PHPShopIcon->setBorder() .
                                    $PHPShopIcon->setIcon("icon/page_lightning.gif", "�������", "window.location.replace('?p=news')") .
                                    $PHPShopIcon->setIcon("icon/photo_album.gif", "�����������", "window.location.replace('?p=photo')") .
                                    $PHPShopIcon->setIcon("icon/page_refresh.gif", "������", "window.location.replace('?p=banner')") .
                                    $PHPShopIcon->setIcon("icon/page_attach.gif", "�����", "window.location.replace('?p=menu')") .
                                    $PHPShopIcon->setIcon("icon/page_error.gif", "������", "window.location.replace('?p=gbook')") .
                                    $PHPShopIcon->setIcon("icon/comments.gif", "��������", "window.location.replace('?p=news_writer')") .
                                    $PHPShopIcon->setIcon("icon/page_link.gif", "������", "window.location.replace('?p=links')") .
                                    $PHPShopIcon->setIcon("icon/page_edit.gif", "������", "window.location.replace('?p=opros')") .
                                    $PHPShopIcon->setIcon("icon/rss.gif", "RSS ������", "window.location.replace('?p=rssgraber')") .
                                    $PHPShopIcon->setIcon("icon/plugin.gif", "������", "window.location.replace('?p=modules')");

                            // ������
                            $Tab1.=$CreateModulesMenu[1];

                            $Tab1.=$PHPShopIcon->setBorder() .
                                    $PHPShopIcon->setIcon("icon/database_key.gif", "SQL", "miniWin('sql/adm_sql.php',500,450)") .
                                    $PHPShopIcon->setIcon("icon/database_save.gif", "�������� �������� ����", "miniWin('dumper/dumper.php',500,500)") .
                                    $PHPShopIcon->setBorder();

                            // ����������
                            if ($support_status == "active" and $SysValue['update']['chek_enabled'] == "true")
                                $Tab1.=$PHPShopIcon->setIcon("icon/update.gif", "�������� ����������", "ChekUpdate('true')");

                            $Tab1.=$PHPShopIcon->setIcon("icon/door.gif", "�����������", "window.close()") .
                                    $PHPShopIcon->setIcon("icon/house.gif", "����", "window.open('../../')");

                            // �������������� ���� ������
                            if (!empty($addTab))
                                $Tab1.=$addTab;

                            $PHPShopIcon->setTab($Tab1);
                            $PHPShopIcon->Compile();

                            // �����
                            $PHPShopInterface->setLoader(false, 'actionStart');
                            ?>
                        </body>
                        </html>
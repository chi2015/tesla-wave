<?php

/**
 * ������� ���� �������
 * @author PHPShop Software
 * @version 1.2
 * @package PHPShopElements
 */
class PHPShopPhotoElement extends PHPShopElements {

    /**
     * @var int ���-�� ���� � �����
     */
    var $ilim = 4;

    /**
     * @var int  ���-�� ���� � ����������
     */
    var $prew = 4;

    /**
     * �����������
     */
    function PHPShopPhotoElement() {

        // �������
        $this->debug = false;

        // ��� ��
        $this->objBase = $GLOBALS['SysValue']['base']['table_name22'];
        parent::PHPShopElements();
    }

    /**
     * ����� ���� �� ����������
     * @return string
     */
    function getPhotos() {
        $dis = null;
        $url = addslashes(substr($this->SysValue['nav']['url'], 1));
        if(empty($url)) $url='/';
        
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name22'));
        $PHPShopOrm->debug = $this->debug;
        $data = $PHPShopOrm->select(array('*'), array('enabled' => "='1'", "page" => " LIKE '%$url%'"), array('order' => 'num'), array("limit" => 50));

        if (is_array($data))
            foreach ($data as $row) {

                $dis.='<p><H4>����������� '.$row['name'].':</H4>' . $this->ListPhoto($row['id'], $this->prew) . '<BR><CENTER>
                       <A href="/photo/CID_' . $row['id'] . '.html">[�������� �����]</A></CENTER></p>';
            }
        return $dis;
    }

    /**
     * ����� ���������� ����
     * @param int $cat ID ��������
     * @return string
     */
    function randPhoto($cat) {
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name23'));
        $PHPShopOrm->debug = $this->debug;
        $row = $PHPShopOrm->select(array('*'), array('enabled' => "='1'", "category" => "=" . intval($cat)), array('order' => 'RAND()'), array("limit" => 1));
        if (is_array($row)) {
            $name_s = str_replace(".", "s.", $row['name']);
            if (is_file($_SERVER['DOCUMENT_ROOT'] . $name_s))
                $realsize = getimagesize($_SERVER['DOCUMENT_ROOT'] . $name_s);

            $dis = '<script type="text/javascript" src="/highslide/highslide-p.js"></script>
<link rel="stylesheet" type="text/css" href="/highslide/highslide.css" />

<script type="text/javascript">
hs.registerOverlay({
  html: \'<div class="closebutton" onclick="return hs.close(this)" title="�������"></div>\',
  position: \'top right\',
  fade: 2 // fading the semi-transparent overlay looks bad in IE
});


hs.graphicsDir = \'/highslide/graphics/\';
hs.wrapperClassName = \'borderless\';
</script>
 <a class="highslide" onclick="return hs.expand(this)" target="_blank" href="' . $row['name'] . '">
 <img width="' . $realsize[0] . '" height="89" src="' . $name_s . '" border="0"></a><div class="highslide-caption">' . $row['info'] . '</div>';
        }

        return $dis;
    }

    /**
     * ����� ����
     * @param int $cat �� ��������� ����
     * @param int $num ���-�� ���� ��� ������
     * @return string
     */
    function ListPhoto($cat, $num = 4) {
        $disp = '';
        $i = 0;

        // ������� ������
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name23'));
        $this->dataArray = $PHPShopOrm->select(array('*'), array('category' => '=' . $cat, 'enabled' => "='1'"), array('order' => 'num'), array('limit' => $num));
        if (is_array($this->dataArray))
            foreach ($this->dataArray as $row) {

                $name_s = str_replace(".", "s.", $row['name']);
                if (is_file($_SERVER['DOCUMENT_ROOT'] . $name_s))
                    $realsize = getimagesize($_SERVER['DOCUMENT_ROOT'] . $name_s);

                $disp.='<TD valign="top" align="center" style="width:90px;">
 <a class="highslide" onclick="return hs.expand(this)" target="_blank" href="' . $row['name'] . '">
 <img width="' . $realsize[0] . '" height="89" src="' . $name_s . '" border="0"></a><div class="highslide-caption">' . $row['info'] . '</div>
</TD>';
                if ($i < $this->ilim - 1) {
                    $i++;
                } else {
                    $i = 0;
                    $disp.='</TR><TR>';
                }
            }

        // ���� ���� �������� ��������
        if (!empty($this->LoadItems['CatalogPhoto'][$this->category]['content_enabled']))
            $content = $this->PHPShopPhotoCategory->getContent();

        $d = '<script type="text/javascript" src="/highslide/highslide-p.js"></script>
<link rel="stylesheet" type="text/css" href="/highslide/highslide.css" />

<script type="text/javascript">
hs.registerOverlay({
  html: \'<div class="closebutton" onclick="return hs.close(this)" title="�������"></div>\',
  position: \'top right\',
  fade: 2 // fading the semi-transparent overlay looks bad in IE
});


hs.graphicsDir = \'/highslide/graphics/\';
hs.wrapperClassName = \'borderless\';
</script>
<p>' . $content . '<p>
<table border="0" cellspacing="0" cellpadding="0" ><tr height="94">' . $disp . '</tr></table>';
        return $d;
    }

    /**
     * ����� ��������� ���� ��� ���������
     * @return string
     */
    function mainMenuPhoto() {
        global $PHPShopModules;
        
        $dis = null;
        $i = 0;

        $data = $this->PHPShopOrm->select(array('*'), array('parent_to' => '=0', 'enabled' => "='1'"), array('order' => 'num'), array("limit" => 100));
        if (is_array($data))
            foreach ($data as $row) {

                // ���������� ����������
                $this->set('catalogId', $row['id']);
                $this->set('catalogI', $i);
                $this->set('catalogTemplates', $this->getValue('dir.templates') . chr(47) . $this->PHPShopSystem->getValue('skin') . chr(47));

                // ���������� ������ ��� ��������� ������� ������
                $this->LoadItems['CatalogPhoto'][$row['id']]['name'] = $row['name'];
                $this->LoadItems['CatalogPhoto'][$row['id']]['parent_to'] = $row['parent_to'];

                if (!empty($row['content']))
                    $this->LoadItems['CatalogPhoto'][$row['id']]['content_enabled'] = true;
                else
                    $this->LoadItems['CatalogPhoto'][$row['id']]['content_enabled'] = false;

                $this->set('catalogName', $row['name']);
                $this->set('catalogLink', '/photo/CID_' . $row['id'] . '.html');
                
                // �������� ������
                $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, $row);
                
                $this->set('menu', $this->parseTemplate($this->getValue('templates.catalog_photo_1_point')));

                $dis.=$this->parseTemplate($this->getValue('templates.catalog_photo_1'));
            }
        return $dis;
    }

}

/**
 * ������� �������� �������
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopCatalogElement extends PHPShopElements {

    /**
     * @var bool ��������� �� ��������� ��������
     */
    var $chek_page = true;

    /**
     * �����������
     */
    function PHPShopCatalogElement() {
        $this->debug = false;
        $this->objBase = $GLOBALS['SysValue']['base']['table_name'];
        parent::PHPShopElements();
    }

    /**
     * ����� ��������� ���������
     * @return string
     */
    function mainMenuPage() {
        $dis = '';
        $i = 0;

        $data = $this->PHPShopOrm->select(array('*'), array('parent_to' => '=0'), array('order' => 'num'), array("limit" => 100));
        if (is_array($data))
            foreach ($data as $row) {

                // ���������� ����������
                $this->set('catalogId', $row['id']);
                $this->set('catalogI', $i);
                $this->set('catalogTemplates', $this->getValue('dir.templates') . chr(47) . $this->PHPShopSystem->getValue('skin') . chr(47));

                // ���������� ������ ��� ��������� ������� ������
                $this->LoadItems['CatalogPage'][$row['id']]['name'] = $row['name'];
                $this->LoadItems['CatalogPage'][$row['id']]['parent_to'] = $row['parent_to'];
                if (!empty($row['content']))
                    $this->LoadItems['CatalogPage'][$row['id']]['content_enabled'] = true;
                else
                    $this->LoadItems['CatalogPage'][$row['id']]['content_enabled'] = false;

                // ���� ���� ��������
                if ($this->chek($row['id'])) {

                    $link = $this->chek_page($row['id']);
                    if ($link and $this->chek_page) {
                        $this->set('catalogName', $row['name']);
                        $this->set('catalogId', $link);
                        $dis.=$this->parseTemplate($this->getValue('templates.catalog_forma_3'));
                    } else {

                        $this->set('catalogPodcatalog', $this->page($row['id']));
                        $this->set('catalogName', $row['name']);
                        $dis.=$this->parseTemplate($this->getValue('templates.catalog_forma'));
                    }
                } else {
                    $this->set('catalogPodcatalog', $this->podcatalog($row['id']));
                    $this->set('catalogName', $row['name']);
                    $dis.=$this->parseTemplate($this->getValue('templates.catalog_forma_2'));
                }

                $i++;
            }
        return $dis;
    }

    /**
     * �������� �����������
     * @param Int $id �� ��������
     * @return bool
     */
    function chek($id) {
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name'));
        $PHPShopOrm->debug = $this->debug;
        $num = $PHPShopOrm->select(array('id'), array('parent_to' => "=$id"), false, array('limit' => 1));
        if (empty($num['id']))
            return true;
    }

    /**
     * �������� �������
     * @param int $id �� ��������
     * @return mixed
     */
    function chek_page($id) {
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name11'));
        $PHPShopOrm->debug = false;
        $num = $PHPShopOrm->select(array('link'), array('category' => "=$id"), false, array('limit' => 5));
        if (is_array($num))
            if (count($num) == 1)
                return $num[0]['link'];
    }

    /**
     * ����� �������
     * @param Int $n �� ��������
     * @return string
     */
    function page($n) {
        global $PHPShopModules, $dis;
        $dis = '';
        $n = intval($n);
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name11'));
        $PHPShopOrm->debug = $this->debug;
        $data = $PHPShopOrm->select(array('*'), array('category' => '=' . $n, 'enabled' => "='1'"), array('order' => 'num'), array("limit" => 100));
        if (is_array($data))
            foreach ($data as $row) {

                // ���������� ����������
                $this->set('catalogId', $n);
                $this->set('catalogUid', $row['id']);
                $this->set('catalogLink', $row['link']);
                $this->set('catalogName', $row['name']);

                // �������� ������
                $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, array($row, &$dis));

                // ���������� ������
                $dis.=$this->parseTemplate($this->getValue('templates.podcatalog_forma'));
            }

        return $dis;
    }

    /**
     * ����� ������������
     * @param Int $n �� ��������
     * @return string
     */
    function podcatalog($n) {
        global $PHPShopModules;

        $dis = '';
        $i = 0;
        $n = intval($n);
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name'));
        $data = $PHPShopOrm->select(array('*'), array('parent_to' => '=' . $n), array('order' => 'num'), array("limit" => 100));
        if (is_array($data))
            foreach ($data as $row) {

                // ���������� ����������
                $this->set('catalogId', $n);
                $this->set('catalogI', $i);
                $this->set('catalogLink', 'CID_' . $row['id']);
                $this->set('catalogName', $row['name']);
                $this->set('catalogTemplates', $this->getValue('dir.templates') . chr(47) . $this->PHPShopSystem->getValue('skin') . chr(47));
                $this->set('catalogName', $row['name']);
                $i++;


                // ���������� ������ ��� ��������� ������� ������
                $this->LoadItems['CatalogPage'][$row['id']]['name'] = $row['name'];
                $this->LoadItems['CatalogPage'][$row['id']]['parent_to'] = $row['parent_to'];
                if (!empty($row['content']))
                    $this->LoadItems['CatalogPage'][$row['id']]['content_enabled'] = true;
                else
                    $this->LoadItems['CatalogPage'][$row['id']]['content_enabled'] = false;

                // �������� ������
                $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, $row);


                // ���������� ������
                $dis.=$this->parseTemplate($this->getValue('templates.podcatalog_forma'));
            }
        return $dis;
    }

}

?>
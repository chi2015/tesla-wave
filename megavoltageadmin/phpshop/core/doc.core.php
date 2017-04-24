<?php

/**
 * ���������� ������������ html ������
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopCore
 */
class PHPShopDoc extends PHPShopCore {

    /**
     * �����������
     */
    function PHPShopDoc() {
        $this->setMeta();
        parent::PHPShopCore();
    }

    /**
     * ������� ����������� �����
     * @global array $SysValue ���������
     * @param string $pages ��� ����� ��� ����������
     * @return string
     */
    function OpenHTML($pages) {
        global $SysValue;
        $dir = "pageHTML/";
        $pages = $pages . ".php";
        $handle = opendir($dir);
        while ($file = readdir($handle)) {
            if ($file == $pages) {
                $urlfile = fopen("$dir$file", "r");
                $text = fread($urlfile, 1000000);
                return $text;
            }
        }
        return false;
    }

    /**
     * ����� �� ���������
     */
    function index() {

        // ������ ����
        $dis = $this->OpenHTML($this->SysValue['nav']['name']);
        
        // 404 ������ ��� ���������� �����
        if(empty($dis))
            return $this->setError404();

        // ����
        $this->title = $this->meta[$this->SysValue['nav']['name']] . ' - ' . $this->PHPShopSystem->getValue("name");

        // ���������� ���������
        $this->set('pageContent', $dis);
        $this->set('pageTitle', $this->meta[$this->SysValue['nav']['name']]);


        // ���������� ������
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

    // ��������� ������
    function setMeta() {
        $this->meta = array(
            'license' => '������������ ����������',
            'design' => '�������������� �������',
            'test' => '����������� HTML ������',
            'phpshop-response' => 'PHPShop ������'
        );
    }

}

?>

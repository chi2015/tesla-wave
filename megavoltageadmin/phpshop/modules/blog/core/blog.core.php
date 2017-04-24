<?php

/**
 * ���������� �����
 * @author PHPShop Software
 * @version 1.3
 * @package PHPShopCore
 */
class PHPShopBlog extends PHPShopCore {

    /**
     * �����������
     */
    function PHPShopBlog() {
        
        // ��� ��
        $this->objBase = $GLOBALS['SysValue']['base']['blog']['blog_log'];

        // ���� ��� ���������
        $this->objPath = "/blog/blog_";

        // �������
        $this->debug = false;

        // ������ �������
        $this->action = array("nav" => "ID");
        parent::PHPShopCore();
        
        // ���������
        $this->option();
    }

    /**
     * ���������
     */
    function option() {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['blog']['blog_system']);
        $this->data = $PHPShopOrm->select();
    }

    /**
     * ����� �� ���������
     */
    function index() {
        global $PHPShopModules;

        // ������� ������
        $this->dataArray = parent::getListInfoItem(array('*'), false, array('order' => 'id DESC'));

        // 404
        if (!isset($this->dataArray))
            return $this->setError404();

        if (is_array($this->dataArray))
            foreach ($this->dataArray as $row) {

                // ���������� ����������
                $this->set('newsId', $row['id']);
                $this->set('newsData', $row['date']);
                $this->set('newsZag', $row['title']);

                // ��������� ����
                $this->set('newsKratko', $row['description']);

                if (!empty($row['content'])) {
                    $this->set('blogComStart', '');
                    $this->set('blogComEnd', '');
                } else {
                    $this->set('blogComStart', '<!--');
                    $this->set('blogComEnd', '-->');
                }
                // �������� ������
                $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, $row);

                // ���������� ������
                $this->addToTemplate($this->getValue('templates.main_news_forma'), false, array('news' => 'blog', '�������' => $this->data['title']));
            }

        // ���������
        $this->setPaginator();

        // ����
        $this->title = "���� - " . $this->PHPShopSystem->getValue("name");

        // ���������� ������
        $this->parseTemplate($this->getValue('templates.news_page_list'), false, array('news' => 'blog', '�������' => $this->data['title']));
    }

    /**
     * ��������� � ��������� ��������
     * @return string
     */
    function setPaginatorContent() {

        // ������ �������
        $curId = $this->PHPShopNav->getId();
        $prevId = $curId - 1;
        $nextId = $curId + 1;

        // �������� �������
        $PHPShopOrm = new PHPShopOrm($this->objBase);
        $PHPShopOrm->Option['where'] = ' or ';
        $PHPShopOrm->debug = $this->debug;
        $PHPShopOrm->sql = 'select id from ' . $this->objBase . ' where id=' . $prevId . ' or id=' . $nextId;
        $row = $PHPShopOrm->select();

        // �������� �� ��������� ������
        if (count($row) == 1)
            $data[0] = $row;
        else
            $data = $row;

        if (is_array($data)) {

            if ($data[0]['id'] == $prevId)
                $navigat = '<a href="./ID_' . $prevId . '.html" title="' . $this->getValue('lang.prev_page') . '">' .
                        $this->getValue('lang.prev_page') . '</a>';
            else
                $navigat = '';

            if ($data[1]['id'] == $nextId)
                $navigat.=' | <a href="./ID_' . $nextId . '.html" title="' . $this->getValue('lang.next_page') . '">' .
                        $this->getValue('lang.next_page') . '</a>';
            else
                $navigat.='';
        }
        return $navigat;
    }

    /**
     * ����� ������� ��������� ���������� ��� ������� ���������� ��������� ID
     * @return string
     */
    function ID() {
        global $PHPShopModules;

        // ������������
        if (!PHPShopSecurity::true_num($this->PHPShopNav->getId()))
            return $this->setError404();

        // ������� ������
        $row = parent::getFullInfoItem(array('*'), array('id' => '=' . $this->PHPShopNav->getId()));

        // 404
        if (!is_array($row))
            return $this->setError404();

        // ���������� ���������
        $this->set('newsData', $row['date']);
        $this->set('newsZag', $row['title']);
        $this->set('newsKratko', $row['description']);
        $this->set('newsPodrob', $row['content']);

        // ���������
        $this->set('paginatorContent', $this->setPaginatorContent());

        // �������� ������
        $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, $row);

        // ���������� ������
        $this->addToTemplate($this->getValue('templates.main_news_forma_full'), false, array('news' => 'blog', '�������' => $this->data['title']));

        // ����
        $this->title = $row['title'] . " - " . $this->PHPShopSystem->getValue("name");
        $this->description = strip_tags($row['description']);
        $this->lastmodified = PHPShopDate::GetUnixTime($row['date']);

        // ���������� ������
        $this->parseTemplate($this->getValue('templates.news_page_full'), false, array('news' => 'blog', '�������' => $this->data['title']));
    }

    function meta() {
        global $PHPShopModules;
        parent::meta();

        // �������� ������
        $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this);
    }

}

?>
<?php

class PHPShopReturncall extends PHPShopCore {

    /**
     * �����������
     */
    function PHPShopReturncall() {

        // ��� ��
        $this->objBase = $GLOBALS['SysValue']['base']['returncall']['returncall_jurnal'];

        // �������
        $this->debug = false;

        // ���������
        $this->system();

        // ������ �������
        $this->action = array(
            'post' => 'returncall_mod_send',
            'name' => 'done',
            'nav' => 'index'
        );
        parent::PHPShopCore();

        // ����
        $this->title = $this->system['title'] . " - " . $this->PHPShopSystem->getValue("name");
    }

    /**
     * ���������
     */
    function system() {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['returncall']['returncall_system']);
        $this->system = $PHPShopOrm->select();
    }

    /**
     * ��������� �� ������� ������
     */
    function done() {
        $message = $this->system['title_end'];
        if (empty($message))
            $message = $GLOBALS['SysValue']['lang']['returncall_done'];
        $this->set('pageTitle', $this->system['title']);
        $this->set('pageContent', $message);
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

    /**
     * ����� �� ���������, ����� ����� ������
     */
    function index($message = false) {

        // ������ ��������
        if ($message)
            $this->set('pageTitle', $message);
        else
            $message = $this->system['title'];

        // �������� ������
        $captcha = parseTemplateReturn($GLOBALS['SysValue']['templates']['returncall']['returncall_captcha_forma'], true);
        $this->set('returncall_captcha', $captcha);

        // ���������� ������
        $this->set('pageTitle', $message);
        $this->set('pageContent', parseTemplateReturn($GLOBALS['SysValue']['templates']['returncall']['returncall_forma'], true));
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

    /**
     * ����� ������ ��� ��������� $_POST[returncall_mod_send]
     */
    function returncall_mod_send() {

        $error = true;

        // �������� ������
        if (!empty($_SESSION['mod_returncall_captcha'])) {
            if ($_SESSION['mod_returncall_captcha'] != $_POST['key'])
                $error = false;
        }

        if (PHPShopSecurity::true_param($_POST['returncall_mod_name'], $_POST['returncall_mod_tel'], $error)) {
            $this->write();
            header('Location: ./done.html');
            exit();
        } else {
            $message = $GLOBALS['SysValue']['lang']['returncall_error'];
        }
        $this->index($message);
    }

    /**
     * ������ � ����
     */
    function write() {

        // ���������� ���������� �������� �����
        PHPShopObj::loadClass("mail");
        $insert = array();
        $insert['name_new'] = PHPShopSecurity::TotalClean($_POST['returncall_mod_name'], 2);
        $insert['tel_new'] = PHPShopSecurity::TotalClean($_POST['returncall_mod_tel'], 2);
        $insert['date_new'] = time();
        $insert['time_start_new'] = floatval($_POST['returncall_mod_time_start']);
        $insert['time_end_new'] = floatval($_POST['returncall_mod_time_end']);
        $insert['message_new'] = PHPShopSecurity::TotalClean($_POST['returncall_mod_message'], 2);
        $insert['ip_new'] = $_SERVER['REMOTE_ADDR'];

        // ������ � ����
        $this->PHPShopOrm->insert($insert);

        $zag = $this->PHPShopSystem->getValue('name') . " - �������� ������ - " . PHPShopDate::dataV($date);
        $message = "
������� �������!
---------------

� ����� " . $this->PHPShopSystem->getValue('name') . " ������ ������ �� �������� ������

������ � ������������:
----------------------

���:                " . $insert['name_new'] . "
�������:             " . $insert['tel_new'] . "
����� ������:       �� " . $insert['time_start_new'] . " �� " . $insert['time_end_new'] . "
���������:          " . $insert['message_new'] . "
����:               " . PHPShopDate::dataV($insert['date_new']) . "
IP:                 " . $_SERVER['REMOTE_ADDR'] . "

---------------

� ���������,
http://" . $_SERVER['SERVER_NAME'];

        new PHPShopMail($this->PHPShopSystem->getValue('admin_mail'), $this->PHPShopSystem->getValue('admin_mail'), $zag, $message);
    }

}

?>
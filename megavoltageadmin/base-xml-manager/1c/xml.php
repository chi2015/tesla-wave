<?php

$_classPath = '../../';
include($_classPath . 'phpshop/class/obj.class.php');
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("xml");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("basexml");
PHPShopObj::loadClass("modules");

// Подключаем БД
$PHPShopBase = new PHPShopBase($_classPath . 'phpshop/inc/config.ini');

// Настройки модулей
$PHPShopModules = new PHPShopModules($_classPath . "phpshop/modules/");

class PHPShopXML extends PHPShopBaseXml {

    function PHPShopXML() {
        $this->debug = false;
        $this->true_method = array('select', 'option', 'insert', 'update', 'delete', 'image', 'order');
        $this->true_from = array('table_name', 'table_name1', 'table_name2', 'table_name3', 'table_name24',
            'table_name5', 'table_name6', 'table_name7', 'table_name8', 'table_name11',
            'table_name14', 'table_name15', 'table_name17', 'table_name27', 'table_name29', 'table_name32',
            'table_name9', 'table_name48', 'table_name50', 'table_name51');

        parent::PHPShopBaseXml();
    }

    function decode($code) {
        $decode = substr($code, 0, strlen($code) - 4);
        $decode = str_replace("I", 11, $decode);
        $decode = explode("O", $decode);
        $disp_pass = "";
        for ($i = 0; $i < (count($decode) - 1); $i++)
            $disp_pass.=chr($decode[$i]);
        return base64_encode($disp_pass);
    }

    function admin() {

        $PHPShopOrm = new PHPShopOrm($this->PHPShopBase->getParam('base.table_name19'));
        $PHPShopOrm->debug = $this->debug;
        $data = $PHPShopOrm->select(array('login,password,status'), array('enabled' => "='1'"), false, array('limit' => 10));
        if (is_array($data)) {
            foreach ($data as $v)
                if ($_POST['log'] == $v['login'] and $this->decode($_POST['pas']) == $v['password']) {
                    $this->user_status = $v['status'];
                    return true;
                }
        }
        return false;
    }

    function update() {

        if (empty($this->user_status))
            parent::update();
    }

    function delete() {

        if (empty($this->user_status))
            parent::delete();
    }

    function insert() {

        if (empty($this->user_status))
            parent::insert();
    }

    function select() {

        if (empty($this->user_status))
            parent::select();
    }

}

new PHPShopXML();
?>
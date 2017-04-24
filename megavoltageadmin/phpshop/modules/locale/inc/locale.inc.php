<?

class PHPShopLocaleElement extends PHPShopElements {

    function PHPShopLocalElement() {
        parent::PHPShopElements();
    }

    /**
     * ���� ����� �����
     * @return string
     */
    function rightMenu() {

        if($this->check()) {
            $this->set('leftMenuName',"Translate");
            $this->set('leftMenuContent','<p><a href="?lang=russian">RUS</a> | <b>ENG</b></p>');
        }
        else {
            $this->set('leftMenuName',"����");
            $this->set('leftMenuContent','<p><b>RUS</b> | <a href="?lang=english">ENG</a></p>');
        }

        return $this->parseTemplate($this->getValue('templates.right_menu'));
    }

    /**
     * �������� �����
     * @return bool
     */
    function check() {
        if(isset($_SESSION['mod_locale']) and $_SESSION['mod_locale'] != 'russian') return true;
    }


    function option(){
          $PHPShopOrm = &new PHPShopOrm($GLOBALS['SysValue']['base']['locale']['locale_system']);
          $data = $PHPShopOrm->select();
          return $data;
    }


    /**
     * ��������� �������� ����������
     */
    function setlang() {
        global $PHPShopSystem;

        // ������ ��� �����
        if($this->check()) {
            $option = $this->option();
            $PHPShopSystem->setParam('name',$option['name']);
            $PHPShopSystem->setParam('title',$option['name']);
        }

        if(!empty($_GET['lang'])) {

            $_SESSION['mod_locale'] = $_GET['lang'];
            $_SESSION['lang'] = $_GET['lang'];

            if($this->check()) {

                if(empty($option)) $option = $this->option();

                if (!empty($option['skin_enabled']) and file_exists("phpshop/templates/".$option['skin']."/index.html"))
                    $_SESSION['skin'] = $option['skin'];
            }
            else $_SESSION['skin'] = $PHPShopSystem->getValue('skin');
            
            header('Location: '.$this->PHPShopNav->objNav['truepath']);
        }
    }
}

$PHPShopLocaleElement = new PHPShopLocaleElement();
$PHPShopLocaleElement->setlang();
$PHPShopLocaleElement->init('rightMenu',true);

?>
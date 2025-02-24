<?php

class PHPShopMessageboardElement extends PHPShopElements {
    /**
     * @var int ���������� ��������� ��� ������
     */
    var $num=5;
    
    function PHPShopMessageboardElement() {
        
        if(!class_exists('PHPShopText'))
            PHPShopObj::loadClass('text');
        
        $this->objBase=$GLOBALS['SysValue']['base']['messageboard']['messageboard_log'];
        $this->debug=false;
        parent::PHPShopElements();
        $this->option();
    }
    
    /**
     * ���������
     */
    function option() {
        $PHPShopOrm = &new PHPShopOrm($GLOBALS['SysValue']['base']['messageboard']['messageboard_system']);
        $this->data = $PHPShopOrm->select();
        
        // ��������� ���������
        $this->LoadItems['modules']['messageboard']['enabled']=$this->data['enabled'];
        $this->LoadItems['modules']['messageboard']['flag']=$this->data['flag'];
        $this->LoadItems['modules']['messageboard']['enabled_menu']=$this->data['enabled_menu'];
    }
    
    
    /**
     * ����� ��������� ����������
     * @return string
     */
    function lastboardForma() {
        $disp=null;
        $num=0;
        $PHPShopOrm = &new PHPShopOrm($GLOBALS['SysValue']['base']['messageboard']['messageboard_log']);
        $PHPShopOrm->debug=false;
        
        $result=$PHPShopOrm->query('SELECT * FROM '.$GLOBALS['SysValue']['base']['messageboard']['messageboard_log'].' order by id desc limit '.$this->num);
        while ($row = mysql_fetch_array($result)) {
            
            $this->set('boardTitle',$row['title']);
            $this->set('boardContent',$row['name'].': '.$row['content']);
            $this->set('boardId',$row['id']);
            $disp.=ParseTemplateReturn($GLOBALS['SysValue']['templates']['messageboard']['messageboard_last_content'],true);
            
        }
        
        $this->set('leftMenuName',$GLOBALS['SysValue']['lang']['messageboard_last_title']);
        $this->set('leftMenuContent',$disp.PHPShopText::a('/board/?add_forma=true',$this->SysValue['lang']['messageboard_add'],$this->SysValue['lang']['messageboard_add']));
        return $this->parseTemplate($this->getValue('templates.left_menu'));
    }
    
    // ���������� ������ � ���-����
    function addToTopMenu() {
        
        // �������� ����
        $this->set('topMenuName',$this->getValue('lang.messageboard_title'));
        
        // ������
        $this->set('topMenuLink','index');
        
        // ������ ������������
        $this->set('userName',$_SESSION['userName']);
        $this->set('userMail',$_SESSION['userMail']);
        
        // ��������� ������ � ������� 'page' �� 'example'
        $dis=$this->PHPShopModules->Parser(array('page'=>'board'),$this->getValue('templates.top_menu'));
        return $dis;
    }
    
}


$PHPShopMessageboardElement = new PHPShopMessageboardElement();

// ������ � ���������
if(!empty($GLOBALS['LoadItems']['modules']['messageboard']['enabled_menu'])) {
    $GLOBALS['SysValue']['other']['topMenu'].=$PHPShopMessageboardElement->addToTopMenu();
}

if(!empty($GLOBALS['LoadItems']['modules']['messageboard']['enabled'])) {
    
    if($GLOBALS['LoadItems']['modules']['messageboard']['flag']==1)  $GLOBALS['SysValue']['other']['rightMenu'].=$PHPShopMessageboardElement->lastboardForma();
    else $GLOBALS['SysValue']['other']['leftMenu'].=$PHPShopMessageboardElement->lastboardForma();
    
}else {
    $PHPShopMessageboardElement->init('lastboardForma');
}

?>
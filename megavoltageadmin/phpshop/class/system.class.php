<?php
/**
 * ��������� ���������
 * ���������� ������ � ���������� �������
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopObj
 */

class PHPShopSystem extends PHPShopObj {
    
    /**
     * �����������
     */
    function PHPShopSystem() {
        $this->objID=1;
        $this->install=false;
        $this->objBase=$GLOBALS['SysValue']['base']['table_name3'];
        parent::PHPShopObj();
    }
    
    /**
     * ������ ��������� ����� �����
     * @return string 
     */
    function getName() {
        return parent::getParam("name");
    }
    
    /**
     * ������ ���������������� ��������
     * @param string $param �������� [param.val]
     * @return string
     */
    function getSerilizeParam($param) {
        $param=explode(".",$param);
        $val=parent::unserializeParam($param[0]);
        return $val[$param[1]];
    }
    /**
     * ������ �������� � ���� �������
     * @return array
     */
    function getArray() {
        $array = $this->objRow;
        foreach($array as $key=>$v)
            if(is_string($key)) $newArray[$key]=$v;
        return $newArray;
    }
}
?>
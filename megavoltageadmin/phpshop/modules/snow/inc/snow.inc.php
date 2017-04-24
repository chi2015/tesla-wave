<?php 
           
/**
 * Украшение снега
 * @author PHPShop Software
 */

	  
class PHPShopSnowElement extends PHPShopElements {

     function PHPShopSnowElement() {
         parent::PHPShopElements();
     }

     function element() {

         $dis= '<script language="JavaScript" src="phpshop/modules/snow/js/snow.js"></script>';
         return $dis;
     }
}

     $PHPShopSnowElement = &new PHPShopSnowElement();
     $GLOBALS['SysValue']['other']['skinSelect'].=$PHPShopSnowElement->element();
     
?>
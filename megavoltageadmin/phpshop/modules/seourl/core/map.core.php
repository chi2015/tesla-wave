<?php
/**
 * ���������� ����� �����
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopCore
 */
class PHPShopMap extends PHPShopCore {

    /**
     * �����������
     */
    function PHPShopMap() {

        // �������
        $this->debug=false;

        parent::PHPShopCore();
    }


    /**
     * ����� �������
     */
    function pagemap() {

        $this->set('pageFrom',"page");
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name11'));
        $PHPShopOrm->debug=$this->debug;
        $dataArray=$PHPShopOrm->select(array('*'),array('category'=>'!=2000','enabled'=>'!=0'),array('order'=>'link'),array('limit'=>1000));
        $j==0;

        if(is_array($dataArray))
            foreach($dataArray as $row) {

                // ���������� ����������
                $this->set('productName',$row['name']);
                $this->set('productKey',substr(strip_tags($row['content']),0,200)."...");
                $this->set('pageLink',$row['link'].".html");
                $i++;
                $this->set('productNum',$i);

                if($j==0) {
                    $this->set('pageTitle',$this->PHPShopSystem->getParam('name').' / ��������');
                    $this->set('pageNumN',"���������: ������� - ". count($dataArray));
                }
                else {
                    $this->set('pageTitle',false);
                    $this->set('pageNumN',false);
                }

                $j++;



                // ���������� ������
                $dis=ParseTemplateReturn($this->getValue('templates.main_search_forma'));
                $dis=str_replace('/page', '', $dis);
                $this->add($dis,true);
            }

        $this->add('<p><br></p>',true);
    }


    /**
     * ����� ��������
     */
    function newsmap(){
        $this->set('pageFrom',"news");
        $this->set('pageDomen',$_SERVER['SERVER_NAME']."/news/");
        $j=0;


        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name8'));
        $PHPShopOrm->debug=$this->debug;
        $PHPShopOrm->Option['where']=" or ";
        $dataArray=$PHPShopOrm->select(array('*'),false,array('order'=>'id desc'),array('limit'=>1000));
        if(is_array($dataArray))
            foreach($dataArray as $row) {

                // ���������� ����������
                $this->set('productName',$row['title']);
                $this->set('pageWords',$this->words);
                $this->set('productKey',substr(strip_tags($row['description']),0,200)."...");
                $this->set('pageLink',"ID_".$row['seo_name'].".html");
                $i++;
                $this->set('productNum',$i);

                if($j==0) {
                    $this->set('pageTitle',$this->PHPShopSystem->getParam('name').' / �������');
                    $this->set('pageNumN',"���������: ������� - ". count($dataArray));
                }
                else {
                    $this->set('pageTitle',false);
                    $this->set('pageNumN',false);
                }

                $j++;

                // ���������� ������
                $this->addToTemplate($this->getValue('templates.main_search_forma'));
            }

        $this->add('<p><br></p>',true);

    }

    /**
     * ����� �������
     */
    function gbookmap(){

        $this->set('pageFrom',"gbook");
        $this->set('pageDomen',$_SERVER['SERVER_NAME']."/gbook/");
        $j=0;


        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name7'));
        $PHPShopOrm->debug=$this->debug;
        $PHPShopOrm->Option['where']=" or ";
        $dataArray=$PHPShopOrm->select(array('*'),array('enabled'=>"='1'"),array('order'=>'id desc'),array('limit'=>1000));
        if(is_array($dataArray))
            foreach($dataArray as $row) {

                // ���������� ����������
                $this->set('productName',$row['title']);
                $this->set('pageWords',$this->words);
                $this->set('productKey',substr(strip_tags($row['question']),0,200)."...");
                $this->set('pageLink',"ID_".$row['id'].".html");
                $i++;
                $this->set('productNum',$i);

                if($j==0) {
                    $this->set('pageTitle',$this->PHPShopSystem->getParam('name').' / ������');
                    $this->set('pageNumN',"���������: ������� - ". count($dataArray));
                }
                else {
                    $this->set('pageTitle',false);
                    $this->set('pageNumN',false);
                }

                $j++;

                // ���������� ������
                $this->addToTemplate($this->getValue('templates.main_search_forma'));
            }
    }

    /**
     * ����� �� ���������, ����� ����� �� ���������, �������� � �������
     */
    function index() {

        $this->pagemap();
        $this->newsmap();
        $this->gbookmap();

        $this->set('searchString',$this->words);

        // ����
        $this->title="����� ����� - ".$this->PHPShopSystem->getValue("name");

        $this->parseTemplate($this->getValue('templates.map_page_list'));
    }
}
?>

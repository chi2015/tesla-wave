<?php

/**
 * ������� ��������� ������
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopGbookElement extends PHPShopElements {
    /**
     * @var bool  ���������� ������ �� �������
     */
    var $disp_only_index=false;
    /**
     * @var Int ���-�� �������
     */
    var $limit=3;

    /**
     * �����������
     */
    function PHPShopGbookElement() {

        // �������
        $this->debug=false;

        // ��� ��
        $this->objBase=$GLOBALS['SysValue']['base']['table_name7'];
        parent::PHPShopElements();
    }

    /**
     * ����� ��������� �������
     * @return string
     */
    function index() {
        global $PHPShopModules;
        $dis=null;

        // ���������� ������ �� ������� ��������
        if($this->disp_only_index) {
            if($this->PHPShopNav->index()) $view=true;
            else $view=false;
        }
        else $view=true;

        if($view) {
            $data = $this->PHPShopOrm->select(array('*'),array('enabled'=>"='1'"),array('order'=>'id DESC'),array("limit"=>$this->limit));
            if(is_array($data))
                foreach($data as $row) {

                    // ������ �� ������
                    if(!empty($row['mail']))  $d_mail=PHPShopText::a('mailto:'.$row[mail],PHPShopText::b($row['name']),$row['name']);
                    else  $d_mail=PHPShopText::b($row['name']);

                    // ���������� ���������
                    $this->set('gbookData',PHPShopDate::dataV($row['date'],false));
                    $this->set('gbookName',$row['name']);
                    $this->set('gbookTema',$row['title']);
                    $this->set('gbookMail',$d_mail);
                    $this->set('gbookOtsiv',$row['question']);
                    $this->set('gbookOtvet',$row['answer']);
                    $this->set('gbookId',$row['id']);

                    // �������� ������
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    // ���������� ������
                    $dis.=$this->parseTemplate($this->getValue('templates.main_gbook_forma'));
                }

            $dis.=PHPShopText::div(PHPShopText::a('/gbook/',__('������ ��� ������')),'left','padding:20');
            $this->set('leftMenuName',__('������'));
            $this->set('leftMenuContent',$dis);

            return $this->parseTemplate($this->getValue('templates.left_menu'));
        }
    }
}


/**
 * ������� ��������� �����
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopTextElement extends PHPShopElements {

    /**
     * �����������
     */
    function PHPShopTextElement() {

        // �������
        $this->debug=false;

        // ��� ��
        $this->objBase=$GLOBALS['SysValue']['base']['table_name14'];
        parent::PHPShopElements();
    }


    /**
     * ����� ����� ��������� ������ ��� ���������
     * @return string
     */
    function leftMenu() {
        global  $PHPShopModules;
        $dis=null;
        $PHPShopOrm = &new PHPShopOrm($this->objBase);
        $data = $PHPShopOrm->select(array('*'),array("flag"=>"='1'",'element'=>"='0'"),array('order'=>'num'),array("limit"=>20));
        if(is_array($data))
            foreach($data as $row) {

                if(empty($row['dir'])) {
                    // ���������� ���������
                    $this->set('leftMenuName',$row['name']);
                    $this->set('leftMenuContent',Parser($row['content']));

                    // �������� ������
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    $dis.=$this->parseTemplate($this->getValue('templates.left_menu'));
                }
                else {
                    $dirs= explode(",",$row['dir']);
                    foreach($dirs as $dir)
                        if($dir==$_SERVER['REQUEST_URI']) {
                            $this->set('leftMenuName',$row['name']);
                            $this->set('leftMenuContent',Parser($row['content']));

                            // �������� ������
                            $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                            // ���������� ������
                            $dis.=$this->parseTemplate($this->getValue('templates.left_menu'));
                        }
                }
            }
        return $dis;
    }

    /**
     * ����� ������ ��������� ������ ��� ���������
     * @return string
     */
    function rightMenu() {
        global $PHPShopModules;
        $dis='';
        $PHPShopOrm = &new PHPShopOrm($this->objBase);
        $data = $PHPShopOrm->select(array('*'),array("flag"=>"='1'",'element'=>"='1'"),array('order'=>'num'),array("limit"=>20));
        if(is_array($data))
            foreach($data as $row) {

                if(empty($row['dir'])) {

                    // ���������� ���������
                    $this->set('leftMenuName',$row['name']);
                    $this->set('leftMenuContent',Parser($row['content']));

                    // �������� ������
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    $dis.=$this->parseTemplate($this->getValue('templates.right_menu'));
                }
                else {
                    $dirs= explode(",",$row['dir']);
                    foreach($dirs as $dir)
                        if($dir==$_SERVER['REQUEST_URI']) {
                            $this->set('leftMenuName',$row['name']);
                            $this->set('leftMenuContent',Parser($row['content']));

                            // �������� ������
                            $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                            // ���������� ������
                            $dis.=$this->parseTemplate($this->getValue('templates.right_menu'));
                        }
                }
            }
        return $dis;
    }


    /**
     * ����� ��������������� ����
     * @return string
     */
    function topMenu() {
        global $PHPShopModules;

        $dis='';
        $objBase=$GLOBALS['SysValue']['base']['table_name11'];
        $PHPShopOrm = &new PHPShopOrm($objBase);
        $data = $PHPShopOrm->select(array('*'),array("category"=>"=1000","enabled"=>"!='0'"),array('order'=>'num'),array("limit"=>20));
        if(is_array($data))
            foreach($data as $row) {

                // ���������� ���������
                $this->set('topMenuName',$row['name']);
                $this->set('topMenuLink',$row['link']);

                // �������� ������
                $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                $dis.=$this->parseTemplate($this->getValue('templates.top_menu'));

            }
        return $dis;
    }
}

/**
 * ������� c���� ��������
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopSkinElement extends PHPShopElements {

    /**
     * �����������
     */
    function PHPShopSkinElement() {
        parent::PHPShopElements();
    }

    /**
     * ����� ����� ��������
     * @return string
     */
    function index() {
        $dis=$name='';
        if($this->PHPShopSystem->getValue('skin_choice')) {
            $dir=$this->getValue('dir.templates').chr(47);
            if (is_dir($dir)) {
                if (@$dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {

                        if($_SESSION['skin'] == $file)
                            $sel="selected";
                        else $sel="";

                        if($file!="." and $file!=".." and $file!="index.html")
                            @$name.= "<option value=\"$file\" $sel>������ $file</option>";
                    }
                    closedir($dh);
                }
            }


            // ���������� ���������
            $forma="<div style=\"padding:10px\"><form name=SkinForm method=post><select name=\"skin\" onchange=\"ChangeSkin()\">".$name."</select></form></div>";
            $this->set('leftMenuContent',$forma);
            $this->set('leftMenuName',"������� ������");

            // ���������� ������
            $dis=$this->parseTemplate($this->getValue('templates.left_menu'));
        }
        return $dis;
    }
}

/**
 * ������� ��������� �������
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopNewsElement extends PHPShopElements {
    /**
     * @var bool  ���������� ������ �� �������
     */
    var $disp_only_index=false;
    /**
     * @var Int ���-�� ��������
     */
    var $limit=3;

    /**
     * �����������
     */
    function PHPShopNewsElement() {

        // �������
        $this->debug=false;

        // ��� ��
        $this->objBase=$GLOBALS['SysValue']['base']['table_name8'];
        parent::PHPShopElements();
    }

    /**
     * ����� ��������� ��������
     * @return string
     */
    function index() {
        global $PHPShopModules;
        $dis='';

        // ���������� ������ �� ������� ��������
        if($this->disp_only_index) {
            if($this->PHPShopNav->index()) $view=true;
            else $view=false;
        }
        else $view=true;

        if($view) {
            $data = $this->PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array("limit"=>$this->limit));
            if(is_array($data))
                foreach($data as $row) {

                    // ���������� ���������
                    $this->set('newsId',$row['id']);
                    $this->set('newsZag',$row['title']);
                    $this->set('newsData',$row['date']);
                    $this->set('newsKratko',$row['description']);

                    // �������� ������
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    // ���������� ������
                    $dis.=$this->parseTemplate($this->getValue('templates.news_main_mini'));
                }
            return $dis;
        }
    }
}

/**
 * ������� ����� �������
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopElements
 */
class PHPShopOprosElement extends PHPShopElements {

    /**
     * �����������
     */
    function PHPShopOprosElement() {
        $this->debug=false;
        parent::PHPShopElements();
    }

    /**
     * ����� ����� �����������
     * @return string
     */
    function oprosDisp() {

        // ������� ������
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name21'));
        $PHPShopOrm->debug=$this->debug;
        $dataArray=$PHPShopOrm->select(array('*'),array('flag'=>"='1'"),array('order'=>'id DESC'),array('limit'=>10));
        $content='';
        if(is_array($dataArray))
            foreach($dataArray as $row) {

                if(empty($row['dir'])) {
                    // ���������� ����������
                    $this->set('oprosName',$row['name']);
                    $this->set('oprosContent',$this->getOprosValue($row['id'],"FORMA"));

                    // ���������� ������
                    $content.= $this->parseTemplate($this->getValue('templates.opros_list'));
                }
                else {

                    // ���� ����� ������� ������
                    if(strpos($row['dir'], ",")) $dirs = explode(",",$row['dir']);
                    else $dirs[] = $row['dir'];

                    foreach($dirs as $dir)
                        if($dir==$_SERVER['REQUEST_URI']) {

                            // ���������� ����������
                            $this->set('oprosName',$row['name']);
                            $this->set('oprosContent',$this->getOprosValue($row['id'],"FORMA"));

                            // ���������� ������
                            $content.= $this->parseTemplate($this->getValue('templates.opros_list'));
                        }
                }
            }

        // ���������� ������
        return $content;
    }

    /**
     * ����� �������
     * @param int $n �� ������
     * @param string $flag [FORMA|RESULT] ����� ����� ������ (����� ������ ��� ��������� �������)
     * @return string
     */
    function getOprosValue($n,$flag) {
        $dis='';
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name20'));
        $PHPShopOrm->comment='getOprosValue';
        $PHPShopOrm->debug=$this->debug;
        $this->dataArray=$PHPShopOrm->select(array('*'),array('category'=>'='.$n),array('order'=>'num'),array('limit'=>100));
        if(is_array($this->dataArray))
            foreach($this->dataArray as $row) {

                if($row['total'] > 0) $total=$row['total'];
                else $total="--";

                // ���������� ���������
                $this->set('valueName',$row['name']);
                $this->set('valueId',$row['id']);


                // ���������� ������
                if($flag=="FORMA")
                    $dis.=$this->parseTemplate($this->getValue('templates.opros_forma'));
                elseif($flag=="RESULT") {
                    $sum=$this->getSumValue($row['category']);
                    $pr=@number_format(($total*100)/$sum,"1",".","");

                    // ���������� ���������
                    $this->set('valueSum',$total);
                    $this->set('valueProc',$pr);
                    $this->set('valueWidth',$pr*3+1);

                    $dis.=$this->parseTemplate($this->getValue('templates.opros_page_forma'));
                }
            }
        return $dis;
    }

    /**
     * ����� ��������
     * @param int $n �� ������
     * @return int
     */
    function getSumValue($n) {
        $objBase=$this->getValue('base.table_name20');
        $PHPShopOrm = &new PHPShopOrm($objBase);
        $result=$PHPShopOrm->query("select SUM(total) as sum from ".$objBase." where category=".$n);
        $row = mysql_fetch_array($result);
        return $row['sum'];
    }
}


/**
 * ������� ������
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopElements
 */
class PHPShopBannerElement extends PHPShopElements {

    /**
     * �����������
     */
    function PHPShopBannerElement() {

        // �������
        $this->debug=false;

        // ��� ��
        $this->objBase=$GLOBALS['SysValue']['base']['table_name15'];
        parent::PHPShopElements();
    }

    /**
     * ����� �������
     * @return string
     */
    function index() {

        $this->row = $this->PHPShopOrm->select(array('*'),array("enabled"=>"='1'"),array('order'=>'RAND()'),array("limit"=>1));
        if(is_array($this->row)) {

            // ���������� ���������
            $this->set('banerContent',Parser($this->row['content']));
            $this->set('banerTitle',$this->row['name']);

            // ��������� �������������� � ����� �������
            if($this->row['count_all']>$this->row['limit_all']) $this->mail();

            // ��������� ������ ������
            $this->update();

            // ���������� ������
            $dis=$this->parseTemplate($this->getValue('templates.banner_list_forma'));
        }
        return $dis;

    }

    /**
     * ����� ������� �� ��
     * @param int $id �� �������
     * @return string
     */
    function banner($id) {

        if(PHPShopSecurity::true_num($id)) {

            $this->row = $this->PHPShopOrm->select(array('*'),array("id"=>"=".$id),false,array("limit"=>1));
            if(is_array($this->row)) {

                // ���������� ����������
                $this->set('banerContent',Parser($this->row['content']));
                $this->set('banerTitle',$this->row['name']);

                // ��������� �������������� � ����� �������
                if($this->row['count_all']>$this->row['limit_all']) $this->mail();

                // ��������� ������ ������
                $this->update();

                // ���������� ������
                $dis=$this->parseTemplate($this->getValue('templates.banner_list_forma'));
            }
            return $dis;
        }

    }

    /**
     * ���������� �������� ������
     */
    function update() {

        if($this->row['date'] != date("d.m.y")) $count_today=0;
        else $count_today=$this->row['count_today']+1;


        $count_all=$this->row['count_all']+1;
        $this->PHPShopOrm->update(array('count_all'=>$count_all,'count_today'=>$count_today,'date'=>date("d.m.y")),
                array('id'=>"=".$this->row['id']),$prefix='');
    }


    /**
     * ����������� � ������ ������
     */
    function mail() {
        $this->PHPShopOrm->update(array('flag'=>'0'),array('id'=>"=".$this->row['id']),$prefix='');

        // ���������� ���������� �������� �����
        PHPShopObj::loadClass("mail");
        $zag="����������� ������ � ������ ".$this->row['name']."";

        $message="
����������� ������ � ������ ".$this->row['name'].".
��� �������������� ��������� ��������� ���� ��������� � ������
�����������������  http://".$_SERVER['SERVER_NAME']."/phpshop/admpanel/

�������������� �������
---------------------------------------------------------

��������: ".$this->row['name']."
�����: ".$this->row['limit_all']."
���� ����������: ".date("d.m.y")."
---------------------------------------------------------


http://".$_SERVER['SERVER_NAME'];
        $PHPShopMail = &new PHPShopMail($this->PHPShopSystem->getParam('adminmail2'),
                "robot@".str_replace("www", '', $_SERVER['SERVER_NAME']),$zag,$message);
    }
}


/**
 * ������� ������ �����
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopElements
 */
class PHPShopCloudElement extends PHPShopElements {
    /**
     * @var Int ����� ������� ��� �������
     */
    var $page_limit=100;
    /**
     * @var int ����� ���� ��� ������
     */
    var $word_limit=30;

    /*
     * �����������
    */
    function PHPShopCloudElement() {

        // �������
        $this->debug=false;

        // ��� ��
        $this->objBase=$GLOBALS['SysValue']['base']['table_name11'];

        parent::PHPShopElements();

        // ���� ������ ������
        if($this->PHPShopSystem->getSerilizeParam('admoption.cloud_color')=="")
            $this->color="0x518EAD";
        else $this->color="0x".$this->PHPShopSystem->getSerilizeParam('admoption.cloud_color');
    }

    /**
     * ����� ������ �����
     * @return string
     */
    function index() {
        $disp='';

        $data = $this->PHPShopOrm->select(array('keywords','link'),array('enabled'=>"='1'",'keywords'=>" !=''",'category'=>'!=2000'),array('order'=>'RAND()'),array("limit"=>$this->page_limit));
        if(is_array($data))
            foreach($data as $row) {

                $explode=explode(", ",$row['keywords']);
                foreach($explode as $ev)
                    if(!empty($ev)) {
                        $ArrayWords[]=$ev;
                        $ArrayLinks[$ev]=$row['link'];
                    }

            }
        if(is_array($ArrayWords))
            foreach($ArrayWords as $k=>$v) {
                $count=array_keys($ArrayWords,$v);
                $CloudCount[$v]['size']=count($count);
            }

        // ������� ����� ��� �����������
        $i=0;
        if(is_array($CloudCount))
            foreach($CloudCount as $k=>$v) {
                if($i<$this->word_limit) $CloudCountLimit[$k]=$v;
                $i++;
            }

        if(is_array($CloudCountLimit))
            foreach($CloudCountLimit as $key=>$val)
                $disp.="<a href='/page/".$ArrayLinks[$key].".html' style='font-size:12pt;'>$key</a>";

        $disp='
<div id="wpcumuluscontent">�������� ����...</div><script type="text/javascript">
var dd=new Date();
 var so = new SWFObject("/tagcloud/tagcloud.swf?rnd="+dd.getTime(), "tagcloudflash", "180", "180", "9", "'.$this->color.'");
so.addParam("wmode", "transparent");
so.addParam("allowScriptAccess", "always");
so.addVariable("tcolor", "'.$this->color.'");
so.addVariable("tspeed", "150");
so.addVariable("distr", "true");
so.addVariable("mode", "tags");
so.addVariable("tagcloud", "<tags>'.$disp.'</tags>");
so.write("wpcumuluscontent");</script>
';

        // ������
        $disp = str_replace('\n','',$disp);
        $disp = str_replace(chr(13),'',$disp);
        $disp = str_replace(chr(10),'',$disp);

        // ���������� ����������
        $this->set('leftMenuName',"������ �����");
        $this->set('leftMenuContent',$disp);

        // ���������� ������
        $dis=$this->parseTemplate($this->getValue('templates.left_menu'));

        return $dis;
    }
}
?>
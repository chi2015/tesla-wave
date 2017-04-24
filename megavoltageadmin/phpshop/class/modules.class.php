<?php
/**
 * ����������� �������
 * @author PHPShop Software
 * @version 1.5
 * @package PHPShopClass
 */

class PHPShopModules {
    /**
     * @var mixed ������ ��������� �������� �������
     */
    var $ModValue;
    /**
     * @var string ������������� ���������� �������
     */
    var $ModDir;
    /**
     * @var bool ����� �������
     */
    var $debug=false;
    /**
     * �����������
     * @param string $ModDir  ������������� ���������� �������
     */
    function PHPShopModules($ModDir="phpshop/modules/") {
        $this->ModDir=$ModDir;
        $this->objBase=$GLOBALS['SysValue']['base']['table_name2'];

        $this->PHPShopOrm = &new PHPShopOrm($this->objBase);
        $this->PHPShopOrm->debug=$this->debug;

        $data=$this->PHPShopOrm->select(array('*'),false,array('order'=>'date'),array('limit'=>100));
        if(is_array($data))
            foreach($data as $row) {
                $path=$row['path'];
                $this->getIni($path);
            }
    }

    /**
     * ��������� �������� ������� �������
     * @param string $path ���� �� ������������ ������
     */
    function getIni($path) {
        $ini=$this->ModDir.$path."/inc/config.ini";
        if(file_exists($ini)) {
            $SysValue = parse_ini_file($ini,1);

            if(is_array($SysValue['autoload']))
                foreach($SysValue['autoload'] as $k=>$v) $this->ModValue['autoload'][$k]=$v;

            if(is_array($SysValue['core']))
                foreach($SysValue['core'] as $k=>$v) $this->ModValue['core'][$k]=$v;

            if(is_array($SysValue['class']))
                foreach($SysValue['class'] as $k=>$v) $GLOBALS['SysValue']['class'][$k]=$v;

            if(is_array($SysValue['lang']))
                foreach($SysValue['lang'] as $k=>$v) $GLOBALS['SysValue']['lang'][$k]=$v;

            if(is_array($SysValue['admpanel']))
                foreach($SysValue['admpanel'] as $k=>$v) $this->ModValue['admpanel'][][$k]=$v;

            if(is_array($SysValue['hook']))
                foreach($SysValue['hook'] as $k=>$v) $this->ModValue['hook'][][$k]=$v;


            $this->ModValue['templates'][$path]=$SysValue['templates'];
            $GLOBALS['SysValue']['templates'][$path]=$SysValue['templates'];
            $this->ModValue['base'][$path]=$SysValue['base'];
            $GLOBALS['SysValue']['base'][$path]=$SysValue['base'];
            $this->ModValue['class'][$path]=$SysValue['class'];
            $this->ModValue['field'][$path]=$SysValue['field'];

        }
    }

    /**
     * �������� ��������� ������������ �������
     */
    function doLoad() {
        global $SysValue,$PHPShopSystem,$PHPShopNav;
        if(is_array($this->ModValue['autoload']))
            foreach($this->ModValue['autoload'] as $k=>$v) {
                if(file_exists($v)) require_once($v);
                else echo("������ �������� ������ ".$k."<br>����: ".$v);
            }
    }

    /**
     * �������� ���� �������
     * @param string $path ���� ���������� core ����� ������
     * @return <type>
     */
    function doLoadPath($path) {
        global $SysValue;
        if(!empty($this->ModValue['core'][$path])) {
            if(is_file($this->ModValue['core'][$path])) {
                require_once($this->ModValue['core'][$path]);
                $classname = 'PHPShop'.ucfirst($SysValue['nav']['path']);

                if(class_exists($classname)) {
                    $PHPShopCore = new $classname ();
                    $PHPShopCore->loadActions();
                    return true;
                } else echo PHPShopCore::setError($classname,"�� ��������� ����� phpshop/modules/*/core/$classname.core.php");
            }
            else PHPShopCore::setError($path,"������ �������� ������ ".$path."<br>����: ".$this->ModValue['core'][$path]);
        }else return false;
    }
    /**
     * ������ ���������������� �������� �������
     * @param string ��� ��������� ����� ������.������������ [������.���������.������������]
     * @return <type>
     */
    function getParam($param) {
        $param=explode(".",$param);
        if(count($param)>2) return $this->ModValue[$param[0]][$param[1]][$param[2]];
        return $this->ModValue[$param[0]][$param[1]];
    }
    /**
     * ������ ���������������� �������� �������
     * @return array
     */
    function getModValue() {
        return $this->ModValue;
    }

    /**
     * ������ � ������� ������ �� ����
     * <code>
     * // example:
     * $PHPShopModules->Parser(array('page'=>'market'),'catalog_page_1');
     * </code>
     * @param array $preg ������ ���������� ��������
     * @param string $TemplateName ��� �������
     * @return string
     */
    function Parser($preg,$TemplateName) {
        $file = newGetFile($GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47).$TemplateName);

        // ������
        foreach($preg as $k=>$v)
            $file = str_replace($k, $v, $file);

        $dis = newParser($file);
        return @$dis;
    }

    /**
     * ������ XML ������� ������
     * @param string $path ���� �� xml �������� ������
     * @return array
     */
    function getXml($path) {
        PHPShopObj::loadClass("xml");
        if(function_exists("xml_parser_create")) {
            if(@$db=readDatabase($path,"module")) {

                if(count($db)>1) return $db;
                else return $db[0];
            }
        }
    }
    /**
     * �������� �� ����������� ��������� ������
     * @param string $serial �������� �����
     * @return bool
     */
    function true_serial($serial) {
        if (preg_match('/^\d{5}-\d{5}-\d{5}$/',$serial)) {
            return true;
        }
    }

    /**
     * �������� �� ���������� ����� ��� ������ ����������
     * @param string $path ��� �����
     * @param string $function_name ��� ������� ��� ����������
     * @param array $data ������
     * @return string
     */
    function setAdmHandler($path,$function_name,$data) {
        global $PHPShopGUI;
        $file=pathinfo($path);

        if(is_array($this->ModValue['admpanel']))
            foreach($this->ModValue['admpanel'] as $mods) {
                $mod=$mods[substr($file['basename'],0,-4)];
                if($mod)
                    if(is_file($this->ModDir.$mod)) {
                        include_once($this->ModDir.$mod);

                        if ((phpversion()*1)>='5.0') {
                            if(!empty($addHandler[$function_name])) call_user_func($addHandler[$function_name],$data);
                        }
                        else {
                            // ��������� ���� ������� � ������ �������
                            if(is_array($addHandler))
                                foreach($addHandler as $v=>$k) $handler[strtolower($v)] = $k;
                            if(!empty($handler[$function_name])){
                                call_user_func($handler[$function_name],$data);
                            }
                        }

                    }
                    else $this->PHPShopOrm->setError('setAdmHandler',"������ ���������� ������ ".$this->ModDir.$mod);
            }
    }


    /**
     * �������� ������� Hook
     * @param string $class_name ��� ������
     * @param string $function_name ��� �������
     * @param mixed $obj ������
     * @param mixed $data ������
     * @param string �������� ���������� ���� [END|START|MIDDLE]
     */
    function setHookHandler($class_name, $function_name, $obj = false, $data = false, $rout = 'END') {

        // ��������� PHP 5.4
        if(!empty($obj) and is_array($obj))
            $obj=&$obj[0];

        if ((phpversion() * 1) >= '5.0')
            $class_name = strtolower($class_name);

        // �������� ����� ������� �� �����
        if (!empty($this->ModValue['hook'][$class_name]))
            foreach ($this->ModValue['hook'][$class_name] as $hook) {
                if (isset($hook))
                    if (is_file($hook)) {
                        include_once($hook);


                        if ((phpversion() * 1) >= '5.0') {

                            if (is_array($addHandler))
                                foreach ($addHandler as $v => $k)
                                    if (!strstr($v, '#'))
                                        $this->addHandler[$class_name][$v][$hook] = $k;
                        }
                        else {

                            // ��������� ���� ������� � ������ �������
                            if (!empty($addHandler) and is_array($addHandler))
                                foreach ($addHandler as $v => $k)
                                    if (!strstr($v, '#'))
                                        $this->addHandler[$class_name][strtolower($v)][$hook] = $k;
                        }
                    }
            }

        if (!empty($this->addHandler[$class_name][$function_name]) and is_array($this->addHandler[$class_name][$function_name]))
            foreach ($this->addHandler[$class_name][$function_name] as $hook_function_name) {

                // �������� ������
                $time = microtime(true);

                $user_func_result = call_user_func_array($hook_function_name, array(&$obj, &$data, $rout));

                // ��������� ������
                $seconds = round(microtime(true) - $time, 6);


                // ����� ���������� ����
                $this->handlerDone[$class_name][$hook_function_name][$rout] = $seconds;

                if (!empty($user_func_result))
                    return $user_func_result;
            }
    }
}

?>
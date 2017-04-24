<?php
/**
 * Библиотека офорфмления текста
 * @version 1.1
 * @package PHPShopClass
 * @subpackage Helper
 */
class PHPShopText {

    function b($string,$style=false) {
        return '<b style="'.$style.'">'.$string.'</b>';
    }

    function notice($string,$icon=false,$size=false) {
        if(!empty($icon)) $img=PHPShopText::img($icon);
        return $img.'<font color="red" style="font-size:'.$size.'">'.$string.'</font>';
    }

    function message($string,$icon=false,$size=false,$color='green') {
        if(!empty($icon)) $img=PHPShopText::img($icon);
        return $img.'<font color="'.$color.'" style="font-size:'.$size.'">'.$string.'</font>';
    }

    function img($src,$hspace=5,$align='left') {
        return '<img src="'.$src.'" hspace="'.$hspace.'" align="'.$align.'" border="0">';
    }

    function br() {
        return '<br>';
    }

    function a($href,$text,$title=false,$color=false,$size=false,$target=false,$class=false) {
        $style='text-decoration:underline;';
        if($size) $style.='font-size:'.$size.'px;';
        if($color) $style.='color:'.$color;
        if(empty($title)) $title=$text;
        return '<a href="'.$href.'" title="'.$title.'" target="'.$target.'" class="'.$class.'" style="'.$style.'">'.$text.'</a>';
    }

    function slide($name) {
        return '<a name="'.$name.'"></a>';
    }

    function h1($string) {
        return '<h1>'.$string.'</h1>';
    }

    function h2($string) {
        return '<h2>'.$string.'</h2>';
    }
    function h3($string) {
        return '<h3>'.$string.'</h3>';
    }

    function ul($string) {
        return '<ul>'.$string.'</ul>';
    }

    function ol($string,$type=null) {
        return '<ol type="'.$type.'">'.$string.'</ol>';
    }

    function li($string,$href=null) {
        if(!empty($href)) {
            $text=PHPShopText::a($href,$string);
            $li='<li>'.$text.'</li>';
        }
        else $li='<li>'.$string.'</li>';
        return $li;
    }

    function tr() {
        $Arg=func_get_args();
        $tr='<tr class=tablerow>';
        foreach($Arg as $val) {
            $tr.=PHPShopText::td($val,'tablerow');
        }
        $tr.='</tr>';
        return $tr;
    }

    /**
     * Прорисовка элемента Select
     * <code>
     * // example:
     * $value[]=array('моя цифра 1',123,'selected');
     * $value[]=array('моя цифра 2',456,false);
     * PHPShopText::select('my',$value,100);
     * </code>
     * @param string $name имя
     * @param array $value значенение в виде массива
     * @param int $width ширина
     * @param string $float float
     * @param string $caption текст перед элементом
     * @param string $onchange имя javascript функции по экшену onchange
     * @param int $height высота
     * @param int $size размер
     * @return string
     */
    function select($name,$value,$width,$float="none",$caption=false,$onchange="return true",$height=false,$size=1,$id=false) {

        if(empty($id)) $id=$name;

        $select=$caption.' <select name="'.$name.'" id="'.$id.'" size="'.$size.'" style="float:'.$float.';margin:'.$this->margin.'px;width:'.$width.'px;height:'.$height.'px" onchange="'.$onchange.'">';
        if(is_array($value))
            foreach($value as $val)
                $select.='<option value="'.$val[1].'" '.@$val[2].'>'.$val[0].'</option>';
        $select.='</select>';
        return $select;
    }

    function td($string,$class=false,$colspan=false,$id=false) {
        return '<td class="'.$class.'" id="'.$id.'" colspan="'.$colspan.'">'.$string.'</td>';
    }

    function th($string) {
        return '<th>'.$string.'</th>';
    }

    function div($string,$align="left",$style=false,$id=false) {
        return '<div align="'.$align.'" id="'.$id.'" style="'.$style.'">'.$string.'</div>';
    }

    function strike($string) {
        return '<strike>'.$string.'</strike>';
    }

    function comment($type='<') {
        if($type == '<') return '<!--';
        else return '-->';
    }

    function p($string='<br>',$style=false) {
        return '<p style="'.$style.'">'.$string.'</p>';
    }

    function button($value,$onclick,$class='ok') {
        return '<input type="button" value="'.$value.'" onclick="'.$onclick.'" class="'.$class.'">';
    }

    function table($content,$cellpadding=3,$cellspacing=1,$align='center',$width='98%',$bgcolor=false,$border=0,$id=false) {
        return '<table id="'.$id.'" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" border="'.$border.'" bgcolor="'.$bgcolor.'" width="'.$width.'" align="'.$align.'">'.$content.'</table>';
    }

    function form($content,$name,$method='post',$action=false) {
        return '<form action="'.$action.'" name="'.$name.'" id="'.$name.'" method="'.$method.'">'.$content.'</form>';
    }

    /**
     * Прорисовка элемента Input
     * @param string $type тип [text,password,button и т.д]
     * @param string $name имя
     * @param mixed $value значение
     * @param int $float float
     * @param int $size размер
     * @param string $onclick экшен по клику, имя javascript функции
     * @param string $class имя класса стиля
     * @param string $caption текст перед элементом
     * @param string $description текст после элемента
     * @return string
     */
    function setInput($type,$name,$value,$float="none",$size=200,$onclick="return true",$class=false,$caption=false,$description=false) {
        $input='
	 <div style="float:'.$float.';padding:5px;">
             '.$caption.' <input type="'.$type.'" value="'.$value.'" name="'.$name.'" id="'.$name.'" style="width:'.$size.'px;"
                 class="'.$class.'" onclick="'.$onclick.'"> '.$description.'</div>';
        return $input;
    }

    /**
     * Прорисовка элемента InputText
     * @param string $caption текст перед элементом
     * @param string $name имя
     * @param mixed $value значение
     * @param int $size размер
     * @param string $description текст после элемента
     * @param string $float  float
     * @param string $class имя класса стиля
     * @return string
     */
    function setInputText($caption,$name,$value,$size=300,$description=false,$float="none",$class=false) {
        return PHPShopText::setInput('text',$name,$value,$float,$size,false,$class,$caption,$description) ;
    }

}
?>
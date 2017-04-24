<?php


class PHPShopPrice extends PHPShopCore {

    var $search_message;
    /**
     * @var array ����� ����� ������ ��� ����� � ������
     */
    var $search_target=array("name","art");
    /**
     * @var int ���-�� ������ �� ��������
     */
    var $search_limit;
    var $current_page=1;

    function PHPShopPrice() {
        if(!empty($_REQUEST['p'])) $this->current_page=$_REQUEST['p'];
        $this->total=count($GLOBALS['_PRODUCT']);
        $this->search_limit=$GLOBALS['LoadItems']['modules']['cart']['num'];

        parent::PHPShopCore();

        // ��������� ������� ������
        $this->navigation(false,'�����-����');
    }

    function searchforma() {

        // ��������� ������ �� ������������
        if(!empty($_REQUEST['search']))
            $value=PHPShopSecurity::TotalClean($_REQUEST['search'],$flag=2);
        else $value='';

        $dis='<div><form method="get">
        <input type="text" name="search" size="30" value="'.$value.'">
	<input type="submit" value="�����"  height="10" title="�����"></form></div>';
        return $dis;
    }


    // ������� � ������ �������
    function lower($str) {
        if(function_exists('mb_strtolower')) $str =  mb_strtolower($str,'WINDOWS-1251');
        else $str = strtolower($str);
        return $str;
    }


    function search() {

        foreach($GLOBALS['_PRODUCT'] as $key => $value) {
            foreach($this->search_target as $found_row_name)
                if(strstr($this->lower($value[$found_row_name]),$this->lower($_REQUEST['search']))) $this->search[$key]=$value;
        }

        if(count($this->search)>0) {
            $GLOBALS['_PRODUCT']=$this->search;
            $this->search_message='������� ����������: '.count($this->search);
            $this->enabled_search=true;
        }
        else {
            $this->search_message='������ �� �������';
            $this->enabled_search=false;
        }

    }

    function listcat($category) {


        $dis='<div style="float:left"><form method="get"><SELECT name="category" id="category"><OPTION value="./">��� �������</OPTION>';
        if(is_array($GLOBALS['_CATALOG']))
            foreach($GLOBALS['_CATALOG'] as $val) {
                if($val['id']==$category) $sel="selected"; else $sel='';
                $dis.='<OPTION value="'.$val['id'].'" '.$sel.'>'.$val['name'].'</OPTION>';
            }

        $dis.='</SELECT> <input type="button" value="��������"  height="10"
                title="��������" onclick="window.location.replace(document.getElementById(\'category\').value)"></form></div>';
        return $dis;
    }

    function _($v,$des) {
        echo $des." - ".$v."<br>";
    }

    function paginatorforma() {
        $navigat='��������: ';
        $t=1;
        $num=$this->total/$this->search_limit;
        while ($t<$num+1) {
            if($t != $this->current_page) $navigat.='<a href="?p='.$t.'">'.$t.'</a> | ';
            else $navigat.="<b> $t</b> | ";
            $t++;
        }

        if($this->total>$this->search_limit)
            $navigat='<p>'.substr($navigat,0,strlen($navigat)-2).'</p>';
        else $navigat='';

        return $navigat;
    }

    function paginatorcheck($i) {


        $end=$this->current_page*$this->search_limit;
        $start=$end-$this->search_limit;


        if($i>=$start and $i<$end) return true;
    }

    // ���� ��������� ������ ������� ������=� ��� ������
    function is_search() {
        if(!empty($GLOBALS['LoadItems']['modules']['cart']['enabled_search'])) {
            if(empty($_REQUEST['search'])) return false;
            elseif($this->enabled_search) return true;
            else return false;
        }
        else return true;
    }


    function index() {

        // ��������� �������
        $category=$GLOBALS['_CATALOG'][$this->PHPShopNav->getNav()];

        // ���� ��������� ������ ������� ����� ��� ������
        if(empty($GLOBALS['LoadItems']['modules']['cart']['enabled_search']))
            $dis=$this->listcat($category['id']);
        
        $dis.=$this->searchforma();



        // ��� ��������
        if($category)
            $dis.='<H2>'.$category['name'].'</H2>';
        else $dis.=$this->paginatorforma();

        if(!empty($_REQUEST['search'])) {
            $dis.=$this->search();
            $dis.='<p>'.$this->search_message.'</p>';
        }


        if($this->is_search()) {
            if(count($GLOBALS['_PRODUCT'])>0) {
                $dis.='<p><table cellSpacing="1" cellPadding="3" width="95%" bgColor="#d2d2d2" >
<tr bgColor="#F0F0F0">
    <td><strong>�������</strong></td>
	<td><strong>������������</strong></td>
	<td><strong>����</strong></td>
        <td><strong>���-��</strong></td>
	<td width="100"></td>
</tr>';



                foreach($GLOBALS['_PRODUCT'] as $key=>$val) {

                    // ���� ����� �������
                    if($category and $val['catalog']==$category['id']) {

                        $dis.='<tr bgColor="#ffffff">
    <td>'.$val['art'].'</td>
	<td>'.$val['name'].'</td>
	<td>'.$val['price'].' '.$GLOBALS['LoadItems']['modules']['cart']['valuta'].'</td>
	<td width="40"><form method="get" action="./">
        <input type="text" name="num" size="2" value="1"></td>
	<td align="center">
        <input type="hidden" name="p" value="'.intval($_GET['p']).'">
	<input type="hidden" name="item" value="'.$key.'">
	<input type="submit" value="� �������"  height="10" title="�������� 1 ��.">
	</form>
	</td>
</tr>';
                    }
                    elseif(!$category and $this->paginatorcheck($i)) {
                        $dis.='<tr bgColor="#ffffff">
    <td>'.$val['art'].'</td>
	<td>'.$val['name'].'</td>
	<td>'.$val['price'].' '.$GLOBALS['LoadItems']['modules']['cart']['valuta'].'</td>
        <td width="40"><form method="get" action="./">
        <input type="text" name="num" size="2" value="1"></td>
	<td align="center">
	<input type="hidden" name="item" value="'.$key.'">
        <input type="hidden" name="p" value="'.intval($_GET['p']).'">
        <input type="hidden" name="search" value="'.$_REQUEST['search'].'">
	<input type="submit" value="� �������"  height="10" title="��������">
	</form>
	</td>
</tr>';
                    }
                    $i++;
                }

                $dis.='
</table>
</p>
<p><input type="button" value="������� �����-����" onclick="javascript:window.open(\'../'.$GLOBALS['_ADMIN']['dir'].$GLOBALS['LoadItems']['modules']['cart']['filedir'].'\');">
</p>';


            }else $dis.='��� ������ � ������, ��������� ����� *.csv � '.$GLOBALS['_ADMIN']['dir'];
        }

        // ����
        $this->title="�����-���� - ".$this->PHPShopSystem->getValue("name");

        // ���������� ���������
        $this->set('pageContent',$dis);
        $this->set('pageTitle','�����-����');


        // ���������� ������
        $this->parseTemplate($this->getValue('templates.page_page_list'));

    }

}

?>
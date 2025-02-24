<?php
/**
 * ���������� ������ � ������
 * @author PHPShop Software
 * @version 1.2
 * @package PHPShopClass
 */
class PHPShopDate {
    /**
     * �������������� ���� �� Unix � ��������� ���
     * @param int $nowtime ������ ���� � Unix
     * @param bool $full ����� ����� � �����
     * @param bool $revers �������� ������ ����
     * @return string
     */
    function dataV($nowtime=false,$full=true,$revers=false) {

        if(!$nowtime) $nowtime = date("U");

        $Months = array("01"=>"������","02"=>"�������","03"=>"�����",
                "04"=>"������","05"=>"���","06"=>"����", "07"=>"����",
                "08"=>"�������","09"=>"��������",  "10"=>"�������",
                "11"=>"������","12"=>"�������");
        $curDateM = date("m",$nowtime);
        $delim='-';
        $d_array=array(
            'y'=>date("Y",$nowtime),
            'm'=>date("m",$nowtime),
            'd'=>date("d",$nowtime),
            'h'=>date("h:i",$nowtime)
        );

        if(!empty($revers)) $time=$d_array['y'].$delim.$d_array['m'].$delim.$d_array['d'];
        else $time=$d_array['d'].$delim.$d_array['m'].$delim.$d_array['y'];

        if(!empty($full)) $time.=" ".$d_array['h'];

        return $time;
    }

    /**
     * �������������� ���� �� ���������� ���� � Unix
     * @param string $data ���� � ������� ������
     * @param string $delim ����������� ���� [-] ��� [.]
     * @return <type>
     */
    function GetUnixTime($data,$delim='-') {
        $array=explode($delim,$data);
        return @mktime(12, 0, 0, $array[1], $array[0], $array[2]);
    }

}
?>
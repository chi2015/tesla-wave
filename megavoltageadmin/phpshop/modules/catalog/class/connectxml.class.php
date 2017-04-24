<?php


class PHPShopConnectXML {

    var $connect_path = '/phpshop/modules/partner/lib/catalog.php';


    function PHPShopConnectXML($domain) {
        PHPShopObj::loadClass('xml');
        $this->domain=$domain;
    }

    function send($post) {
        $fp = fsockopen($this->domain, 80, $errno, $errstr, 30);
        if (!$fp) {
            echo "Произошла ошибка XML. Пожалуйста, попробуйте позже!";
            debug('Ошибка связи с '.$this->domain,'fsockopen');
        } else {

            $out = "POST ".$this->connect_path."    HTTP/1.0\r\n";
            $out .= "Host: ".$this->domain."\r\n";
            $out .= "Content-Length: ".strlen($post)."\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n\r\n";
            $out .= $post."\r\n";

            fwrite($fp, $out);
            $res=null;
            while (!feof($fp)) {
                $res.=fgets($fp, 128);
            }
            fclose($fp);
        }
        
        $response=split("\r\n\r\n",$res);
        $header=$response[0];
        $responsecontent=$response[1];
        if(!(strpos($header,"Transfer-Encoding: chunked")===false)) {
            $aux=split("\r\n",$responsecontent);
            for($i=0;$i<count($aux);$i++)
                if($i==0 || ($i%2==0))
                    $aux[$i]="";
            $responsecontent=implode("",$aux);
        }
        $res=chop($responsecontent);

        return  $res;
    }


    function readxml($xml) {
        $db=readDatabase($xml,"row",false);
        return $db;
    }


    function query($from,$method,$vars,$where=false,$order='id',$limit=1000) {
        return 'log='.$this->log.'&pas='.base64_encode($this->pas).'&key='.$this->key.'&url=http://'.$_SERVER['SERVER_NAME'].'&sql=<phpshop><sql><from>'.$from.'</from>
           <method>'.$method.'</method><vars>'.$vars.'</vars>
               <where>'.$where.'</where>
                   <order>'.$order.'</order>
                       <limit>'.$limit.'</limit>
                           </sql></phpshop>';
    }
}

?>
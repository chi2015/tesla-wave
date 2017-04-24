<?php
    
   function normJsonStr($str){
      $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
      return iconv('cp1251', 'utf-8', $str);
   }

    header('Access-Control-Allow-Origin: *');
    $text = normJsonStr(file_get_contents('../megavoltageadmin2/admin/hello/hello.txt')); 
    echo json_encode(array("text" => $text));
?>
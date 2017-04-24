<?php

$TitlePage=__("Новости");



// Новости форма рассылки
$addTab='
<td align="right">
<form name="data_list">
<table cellspacing="0" cellpadding="0" >
<tr>
  <td>
  Новости за 
    <select class=s name=data_news>';

$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
$data = $PHPShopOrm->select(array('distinct date'),false,array('order'=>'id DESC'),array('limit'=>10));
if(is_array($data))
    foreach($data as $row) {
        extract($row);
        $addTab.="<option value=$date>$date";
    }

$addTab.='</select>
  <input type=button value=Разослать class=but3 onclick="Ras(400,300)">
  <input type=hidden name="p" value="news">
  </td>
</tr>
</table>
</form></td>';


function actionStart() {
    global $PHPShopInterface;
    $PHPShopInterface->size="630,550";
    $PHPShopInterface->link="news/adm_newsID.php";
    $PHPShopInterface->setCaption(array("Дата","10%"),array("Заголовок","45%"),array("Краткая информация","45%"));

    if(!empty($_GET['search']))
        $where=array('title'=>" LIKE '%".$_GET['search']."%'",
            'description'=>" LIKE '%".$_GET['search']."%'",
            'content'=>" LIKE '%".$_GET['search']."%'",
            'id'=>"='".$_GET['search']."'",
            'date'=>"='".$_GET['search']."'"
            );
    else $where=false;

    // SQL
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
    $PHPShopOrm->Option['where']=' or ';
    $PHPShopOrm->debug=false;
    $data = $PHPShopOrm->select(array('*'),$where,array('order'=>'id DESC'),array('limit'=>1000));
    if(is_array($data))
        foreach($data as $row) {
            extract($row);
            $PHPShopInterface->setRow($id,$date,$title,substr(strip_tags($description),0,150)."...");
        }

    
    $PHPShopInterface->setAddItem('news/adm_news_new.php');
    $PHPShopInterface->setSearch();
   
    $PHPShopInterface->Compile();
}

?>
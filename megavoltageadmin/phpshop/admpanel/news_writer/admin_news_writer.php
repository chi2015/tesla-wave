<?
$TitlePage=__("Подписка");
PHPShopObj::loadClass("readcsv");


class ReadCsvUnix extends PHPShopReadCsv {
    var $CsvToArray;

    function ReadCsvUnix($file) {
        $this->TableName=$GLOBALS['SysValue']['base']['table_name9'];
        $this->CsvContent = parent::readFile($file);
        parent::PHPShopReadCsv();
    }

    function DoUpdatebase() {
        $CsvToArray = $this->CsvToArray;
        foreach ($CsvToArray as $v)
            $this->UpdateBase($v);
    }

    function UpdateBase($CsvToArray) {
        $sql="INSERT INTO ".$this->TableName."
      VALUES ('','".date("d-m-y")."','".$CsvToArray[0]."')";
        $result=mysql_query($sql) or die ("".$sql);
    }

    function UpdateBaseClean() {
        $sql = "TRUNCATE TABLE ".$this->TableName;
        $result=mysql_query($sql) or die ("".$sql);
    }

}



if(isset($_POST['loadBase'])) {

    // Расширение
    PHPShopObj::loadClass("security");
    $_FILES['file']['ext']=PHPShopSecurity::getExt($_FILES['file']['name']);
    
    if($_FILES['file']['ext']!="csv") exit('Ошибка формата файла');

    // Загружаем
    if(move_uploaded_file(@$_FILES['file']['tmp_name'], "./csv/".@$_FILES['file']['name'])) {

        if($_POST['status'] == 1) {
            $ReadCsv = new ReadCsvUnix("./csv/".@$_FILES['file']['name']);
            $ReadCsv->UpdateBaseClean();
            $Done = $ReadCsv->DoUpdatebase();
        }
        if($_POST['status'] == 2) {
            $ReadCsv = new ReadCsvUnix("./csv/".@$_FILES['file']['name']);
            $Done = $ReadCsv->DoUpdatebase();
        }
    }
}



function dispMail() {
    $PHPShopInterface = new PHPShopInterface();
    $PHPShopInterface->size="400,300";
    $PHPShopInterface->link="news_writer/adm_news_writerID.php";
    $PHPShopInterface->window=true;
    $PHPShopInterface->setCaption(array("Дата","50%"),array("E-mail","50%"));

    // SQL
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name9']);
    $data = $PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array('limit'=>1000));
    if(is_array($data))
        foreach($data as $row) {
            extract($row);
            $PHPShopInterface->setRow($id,$date,$mail);
        }

    $PHPShopInterface->setAddItem('news_writer/adm_news_writer_new.php');
    return $PHPShopInterface->Compile();
}


function actionStart() {
    $PHPShopGUI = new PHPShopGUI();
    $Tab="<div style='width:500px;float:left'>".dispMail().'</div>';
    $Tab.=$PHPShopGUI->setField("Выгрузка:",$PHPShopGUI->setInput('button','unload','OK',"none",100, "miniWin('news_writer/adm_csv.php?DO=news_writer',300,300);",false,false,false,'*Выгрузка базы подписчиков осуществляется в формат CSV'),"none");
    $Tab.=$PHPShopGUI->setForm($PHPShopGUI->setField("Загрузка:",$PHPShopGUI->setInput('file','file','OK',"none",400)
            .$PHPShopGUI->setRadio('status',1,'Заменить базу').$PHPShopGUI->setRadio('status',2,'Добавить новые записи')
            .$PHPShopGUI->setInput("submit","loadBase","ОК","left",100,"","but")
            ,"none"));
    writeLangFile();
    echo $Tab;
}

?>
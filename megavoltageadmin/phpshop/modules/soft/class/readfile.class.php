<?

// Класс чтения из CSV
PHPShopObj::loadClass("readcsv");
class FileCsv extends PHPShopReadCsv {
    var $CsvToArray;

    function FileCsv($file) {
        $this->CsvContent = parent::readFile($file);
        parent::PHPShopReadCsv();
    }

    function CreatBase() {
        $CsvToArray = $this->CsvToArray;
        if(is_array($CsvToArray))
            foreach ($CsvToArray as $items) {
                $_PRODUCT[$items[0]]['id']=$items[0];
                $_PRODUCT[$items[0]]['size']=$items[1];
                $_PRODUCT[$items[0]]['file']=$items[2];
            }
        return @$_PRODUCT;
    }

}


?>

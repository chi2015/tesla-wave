<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("admgui");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

$PHPShopSystem = new PHPShopSystem();


class MainCatalogTree extends CatalogTree {

    function MainCatalogTree($base) {
        if($_COOKIE['winOpenType'] == 'highslide') $this->dot="./photo/";
        else $this->dot="";
        parent::CatalogTree($base);
    }

    function addcat($n,$id,$name,$link=false,$icon=false) {
        $name=__($name);
        $this->dis.="d.add($n,$id,'$name','$link','','','','$icon');";
    }

    function create() {
        $result=$this->sql("select * from ".$this->table." where parent_to=0 order by num");
        $i=0;
        $j=0;
        $dis='';
        while($row = mysql_fetch_array($result)) {
            $id=$row['id'];
            $name=$row['name'];
            $num=$this->chek($id);
            $link='./admin_photo_content.php?pid='.$id;
            if($num>0)
                $this->dis.="
  d.add($id,0,'$name',\"javascript:miniWin('".$this->dot."adm_catalogID.php?id=$id',650,630)\");
                        ".$this->add($id)."
  ";
            else $this->dis.="
  d.add($id,0,'$name','$link');
                        ".$this->add($id)."
  ";
            $i++;
        }
    }

    function add($n) {
        $disp='';
        $result=$this->sql("select * from ".$this->table." where parent_to='$n' order by num");
        while($row = mysql_fetch_array($result)) {
            $i=0;
            $id=$row['id'];
            $name=$row['name'];
            $parent_to=$row['parent_to'];
            $num=$this->chek($id);
            $link='./admin_photo_content.php?pid='.$id;

            if($i<$num)// если есть еще каталоги
            {
                $disp.="d.add($id,$n,'$name',\"javascript:miniWin('".$this->dot."adm_catalogID.php?id=$id',650,630)\");
                        ".$this->add($id);
            }
            else// если нет каталогов
            {
                $disp.="d.add($id,$n,'$name','".$link."');";
            }
        }
        return $disp;
    }

}


?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$GLOBALS['PHPShopLangCharset']?>">
<LINK href="../skins/<?=$PHPShopSystem->getSerilizeParam("admoption.theme")?>/dtree.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../java/dtree.js" type="text/javascript"></SCRIPT>
</head>
<body bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0" bgcolor="#ffffff">
<div style="padding:10px">
     <?

            // Дерево каталогов
            $CatalogTree = &new MainCatalogTree($GLOBALS['SysValue']['base']['table_name22']);
            $CatalogTree->addcat(0,-1,'Фотогалерея','');
            $CatalogTree->create();
            $CatalogTree->disp();
            ?>
</div>
</body>
</html>


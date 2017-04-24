<?php

session_start();

require("watermark/watermark.php");
require("resize/resize.php");


$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("string");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
//$PHPShopBase->chekAdmin();
$PHPShopSystem = new PHPShopSystem();
$PHPShopSystem->getParam("admoption");

$Admoption=unserialize($PHPShopSystem->getParam("admoption"));

// Code for Session Cookie workaround
if (isset($_POST["PHPSESSID"])) {
    session_id($_POST["PHPSESSID"]);
} else if (isset($_GET["PHPSESSID"])) {
    session_id($_GET["PHPSESSID"]);
}


// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
$POST_MAX_SIZE = ini_get('post_max_size');
$unit = strtoupper(substr($POST_MAX_SIZE, -1));
$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
    header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
    echo "POST exceeded maximum allowed size.";
    exit(0);
}

// Settings
//$save_path = getcwd() . "/uploads/";				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
$save_path = $_POST['Filepath'];
$upload_name = "Filedata";
$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
$extension_whitelist = array("jpg", "gif","JPG","GIF","jpeg","JPEG");	// Allowed file extensions
$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)

// Other variables	
$MAX_FILENAME_LENGTH = 260;
$file_name = "";
$file_extension = "";
$uploadErrors = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
);


// Validate the upload
if (!isset($_FILES[$upload_name])) {
    HandleError("No upload found in \$_FILES for " . $upload_name);
    exit(0);
} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
    HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
    exit(0);
} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
    HandleError("Upload failed is_uploaded_file test.");
    exit(0);
} else if (!isset($_FILES[$upload_name]['name'])) {
    HandleError("File has no name.");
    exit(0);
}

// Validate the file size (Warning: the largest files supported by this code is 2GB)
$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
if (!$file_size || $file_size > $max_file_size_in_bytes) {
    HandleError("File exceeds the maximum allowed size");
    exit(0);
}

if ($file_size <= 0) {
    HandleError("File size outside allowed lower bound");
    exit(0);
}


// Validate file name (for our purposes we'll just remove invalid characters)
$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
    HandleError("Invalid file name");
    exit(0);
}


// Validate that we won't over-write an existing file
if (file_exists($save_path . $file_name)) {
    HandleError("File with this name already exists");
    exit(0);
}

// Validate file extension
$path_info = pathinfo($_FILES[$upload_name]['name']);
$file_extension = strtolower($path_info["extension"]);
$is_valid_extension = false;
foreach ($extension_whitelist as $extension) {
    if (strcasecmp($file_extension, $extension) == 0) {
        $is_valid_extension = true;
        break;
    }
}
if (!$is_valid_extension) {
    HandleError("Invalid file extension");
    exit(0);
}


$_REQUEST['id']=$_POST["PID"];
$mycF=$save_path;
$mycReturn=ereg_replace($_SERVER['DOCUMENT_ROOT'],"",$save_path);

// Генерим имя
$myRName=substr(abs(crc32(uniqid(date('U')))),0,5);

$img[ufiletyle] = $file_extension;  // Тип файла
$img[utmpname] = $_FILES[$upload_name]['tmp_name'];   // Временный файл
$img[path] = $mycF."/";  // Куда сохранять
$img[tpath] = $mycF."/"; // Куда сохранять тумбнейл
$img[name] = "img".$_REQUEST['id']."_$myRName";// Имя под которым сохранить (без расширения)
$img[name_big] = "img".$_REQUEST['id']."_".$myRName."_big";// Имя под которым сохранить исходную картинку (без расширения)
$img[tname] = "img".$_REQUEST['id']."_".$myRName."s";   // Имя тумбнейла (без расширения)
$img[q] = $Admoption[width_podrobno]; // Качество
$img[tq] = $Admoption[width_kratko]; // Качество тумбы
$img[wm] = $Admoption[img_wm];  // Поставить копирайт (!!! Только английский !!!)
$img[size]=13; // Размер шрифта
$img[sizet]=10; // Размер шрифта тумбнейл
$img[wmargin] = 20; // отступ
$img[twm] = 1; // Ставить watermark на тумбнейл
$img[twmargin] = 10; // отступ на тумбе
$img[minwater] = 50;   // Минимальный размер сторон для копирайта на картинке
$img[tminwater] = 50; // Минимальный размер сторон для копирайта на тумбе
$img[w] = $Admoption[img_w];            // Макс. ширина оригинала
$img[h] = $Admoption[img_h];            // Макс. высота оригинала
$img[realsize] = false;         // Сохранить оригинальный размер
$img[tw] = $Admoption[img_tw];            // Макс. ширина тумбнейла
$img[th] = $Admoption[img_th];              // Макс. высота тумбнейла
$img[maxsize] = 1024000;    // Макс. размер в Кб

// Сохранение изображений
$SaveImg=SaveImg2($img,$Admoption);




// Номер файла
if(empty($_SESSION['photoNum']))
    $_SESSION['photoNum']=1;
elseif($_SESSION['photoNum']>0 and $_SESSION['photoInfo']!=$_POST["photoInfo"])
    $_SESSION['photoNum']=1;
else $_SESSION['photoNum']++;

$sql='INSERT INTO '.$SysValue['base']['table_name23'].'
SET category='.$_REQUEST['id'].',
enabled="1",
name="'.$mycReturn.'/'.$img['name'].'.'.$file_extension.'",
num="'.$_SESSION['photoNum'].'",
info="'.PHPShopString::utf8_win1251($_POST["photoInfo"]).'"';

mysql_query($sql);

$_SESSION['photoInfo'] = $_POST["photoInfo"];

HandleError("Invalid file extension");
exit(0);


/* Handles the error output. This error message will be sent to the uploadSuccess event handler.  The event handler
will have to check for any error messages and react as needed. */
function HandleError($message) {
    echo $message;
}
?>
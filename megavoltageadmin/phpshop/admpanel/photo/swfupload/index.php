<?

$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();


// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������� �����������";
$PHPShopGUI->reload = "right";

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


$sBase0=$_SERVER['DOCUMENT_ROOT']."/UserFiles/Image";
$sName0="Image";

function writeFolderSelections() {
    global $sBase0;
    global $sBase1;
    global $sBase2;
    global $sBase3;
    global $sName0;
    global $sName1;
    global $sName2;
    global $sName3;
    global $currFolder;

    echo "<select name='selCurrFolder' id='selCurrFolder' onchange='setParam(\"Filepath\",this.value)'>";
    recursive($sBase0,$sBase0,$sName0);
    echo "</select>";
}

function recursive($sPath,$sPath_base,$sName) {
    global $sBase0;
    global $sBase1;
    global $sBase2;
    global $sBase3;
    global $currFolder;

    if($sPath==$sBase0 ||$sPath==$sBase1 ||$sPath==$sBase2 ||$sPath==$sBase3) {
        if($currFolder==$sPath)
            echo "<option value='$sPath' selected>$sName</option>";
        else
            echo "<option value='$sPath'>$sName</option>";
    }

    $oItem=opendir($sPath);
    while($sItem=readdir($oItem)) {
        if($sItem=="."||$sItem=="..") {
        }
        else {
            $sCurrent=$sPath."/".$sItem;
            $fIsDirectory=is_dir($sCurrent);

            $sDisplayed=ereg_replace($sBase0,"",$sCurrent);
            if($sBase1<>"") $sDisplayed=ereg_replace($sBase1,"",$sDisplayed);
            if($sBase2<>"") $sDisplayed=ereg_replace($sBase2,"",$sDisplayed);
            if($sBase3<>"") $sDisplayed=ereg_replace($sBase3,"",$sDisplayed);
            $sDisplayed=$sName.$sDisplayed;

            if($fIsDirectory) {
                if($currFolder==$sCurrent)
                    echo "<option value='$sCurrent' selected>$sDisplayed</option>";
                else
                            echo "<option value='$sCurrent'>$sDisplayed</option>";

                        recursive($sCurrent,$sPath,$sName);
                    }
                }
            }
            closedir($oItem);
        }


        function actionStart() {
            global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;


            $PHPShopGUI->dir="../../";
            $PHPShopGUI->addJSFiles("core/swfupload.js","js/swfupload.queue.js","js/fileprogress.js","js/handlers.js");
            $PHPShopGUI->includeJava.= '
         <script type="text/javascript">
            var swfu;

          function setParam(param, value){
              swfu.addPostParam(param, value);
            }

            window.onload = function() {
                var settings = {
                    flash_url : "core/swfupload.swf",
                    upload_url: "upload.php",
                    post_params: {"PID": "'.$_GET['pid'].'","PHPSESSID" : "'.session_id().'", "Filepath" : document.getElementById("selCurrFolder").value},
                    file_size_limit : "100 MB",
                    file_types : "*.*",
                    file_types_description : "��� �����",
                    file_upload_limit : 100,
                    file_queue_limit : 0,
                    custom_settings : {
                        progressTarget : "fsUploadProgress",
                        cancelButtonId : "btnCancel"
                    },
                    debug: false,

                    // Button settings
                    button_image_url: "images/SmallSpyGlassWithTransperancy_17x18.png",
                    button_width: "220",
                    button_height: "18",
                    button_placeholder_id: "spanButtonPlaceHolder",
                    button_text: \'<span class="theFont">'.__('�������� �����������').' (gif, jpg)</span>\',
                    button_text_style: ".theFont { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; }",
                    button_text_left_padding: 18,
                    button_text_top_padding: 0,

                    // The event handler functions are defined in handlers.js
                    file_queued_handler : fileQueued,
                    file_queue_error_handler : fileQueueError,
                    file_dialog_complete_handler : fileDialogComplete,
                    upload_start_handler : uploadStart,
                    upload_progress_handler : uploadProgress,
                    upload_error_handler : uploadError,
                    upload_success_handler : uploadSuccess,
                    upload_complete_handler : uploadComplete,
                    queue_complete_handler : queueComplete	// Queue plugin event
                };

                swfu = new SWFUpload(settings);
            };
        </script>';

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� �����������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_filemanager_med[1].gif");

    ob_start();
    writeFolderSelections();
    $writeFolderSelections=ob_get_clean();

    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField('��������� �',"<p>$writeFolderSelections</p>");
    $Tab1.=$PHPShopGUI->setField('�����������',$PHPShopGUI->setInput('text','info_new','','none','98%',false,false,false,false,false,'setParam(\'photoInfo\',this.value)'));
    $Tab1.=$PHPShopGUI->setField('����� ��������: ','<p><span id="divStatus" style="font-weight:bold">0 '.__('������ ���������').'</span></p>','left');
    $Tab1.=$PHPShopGUI->setField('����������',
            '<p><div style="border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px; width: 220px;float:left">
                    <span id="spanButtonPlaceHolder"></span></div><input id="btnCancel" type="button" value="'.__('��������').'" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 27px;" />
</p>','none',10);



    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,250));

    // ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));


    // ����� ������ ��������� � ����� � �����
    $ContentFooter=$PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but");
    $ContentFooter.=$PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionReload");


    // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ������� ����������
function actionReload() {
    return true;
}


if($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� �������
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>
<?php

/**
 * ���������
 * @author PHPShop Software
 * @version 1.3
 * @package PHPShopInc
 */

// ��������� ������ ���������� ���������
error_reporting('E_ALL & ~E_NOTICE & ~E_DEPRECATED');

// ����������
$_classPath = 'phpshop/';

// �������� �� ������ /index.php/index.php
if (strstr($_SERVER['REQUEST_URI'], 'index.php')) {
    header('Location: /error/');
    exit();
}

// ���������� ����������
$SysValue['other']['telNum'] = $PHPShopSystem->getValue('tel');
$SysValue['other']['mail'] = $PHPShopSystem->getValue('admin_mail');
$SysValue['other']['pageCss'] = $SysValue['dir']['templates'] . chr(47) . $_SESSION['skin'] . chr(47) . $SysValue['css']['default'];

// �������� �������
include($SysValue['class']['modules']);
$PHPShopModules = new PHPShopModules();
$PHPShopModules->doLoad();

// ���������� ����������
$SysValue['other']['name'] = $PHPShopSystem->getValue('name');
$SysValue['other']['company'] = $PHPShopSystem->getValue('company');

// ����-������
$PHPShopGbookElement = new PHPShopGbookElement();
$PHPShopGbookElement->init('miniGbook');

// �����
$PHPShopOprosElement = new PHPShopOprosElement();
$PHPShopOprosElement->init('oprosDisp');

// ����-�������
$PHPShopNewsElement = new PHPShopNewsElement();
$PHPShopNewsElement->init('miniNews');

// ������
$PHPShopBannerElement = new PHPShopBannerElement();
$PHPShopBannerElement->init('banersDisp');

// ������ �����
$PHPShopCloudElement = new PHPShopCloudElement();
$PHPShopCloudElement->init('cloud');

// ����� �������
$PHPShopSkinElement = new PHPShopSkinElement();
$PHPShopSkinElement->init('skinSelect');

// ��������� ����
$PHPShopTextElement = new PHPShopTextElement();
$PHPShopTextElement->init('leftMenu',true); // ����� ������ �����
$PHPShopTextElement->init('rightMenu',true); // ����� ������� �����
$PHPShopTextElement->init('topMenu',true); // ����� �������� ����

// �������
$PHPShopCatalogElement = new PHPShopCatalogElement();
$PHPShopCatalogElement->init('mainMenuPage');

// �����������
$PHPShopPhotoElement = new PHPShopPhotoElement();
$PHPShopPhotoElement->init('mainMenuPhoto');
$PHPShopPhotoElement->init('getPhotos');

// RSS ������ ��������
$PHPShopRssParser = new PHPShopRssParser();

// ����������� ����
if (!empty($SysValue['nav']['path'])) {
    $core_file = "./phpshop/core/" . $PHPShopNav->getPath() . ".core.php";
    $old_core_file = "pages/" . $PHPShopNav->getPath() . ".php";
    if (is_file($old_core_file)) {
        include_once("pages/" . Open($SysValue['nav']['path']));
    } elseif (!$PHPShopModules->doLoadPath($SysValue['nav']['path'])) {
        if (is_file($core_file)) {
            include_once($core_file);
            $classname = 'PHPShop' . ucfirst($SysValue['nav']['path']);
            if (class_exists($classname)) {
                $PHPShopCore = new $classname ();
                $PHPShopCore->loadActions();
            }else
                echo PHPShopCore::setError($classname, "�� ��������� ����� phpshop/core/$classname.core.php");
        }else
            include("pages/error.php");
    }
}
?>
<?php
error_reporting(0);
define("CACHE_FILE", 0);
define("IN_CRONLITE", true);
$app = $_SERVER['DOCUMENT_ROOT'].'/Index/';
require_once($app .'User/code.php');
require_once($app .'User/includes/Weidong/encipher.php');
$zhushi=daddslashes($_POST['zhushi']);
$dir1 =  $app.'includes/download/'.$space; 
$encipher = new Encipher($dir1, $dir1);
$encipher->advancedEncryption = true;
$encipher->comments = array(''.$zhushi.'');
/**
 * 设置加密模式 false = 低级模式; true = 高级模式
 * 低级模式不使用eval函数
 * 高级模式使用了eval函数
 */
$encipher->encode();
?>
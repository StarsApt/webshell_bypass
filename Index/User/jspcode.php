<?php
error_reporting(0);
error_reporting(E_ALL);  
include './includes/EnJSP.php';
$_SERVER['starttime'] = microtime(1);
$starttime            = explode(' ', $_SERVER['starttime']);
$_SERVER['time']      = $starttime[1];

ob_implicit_flush(1);
$app = $_SERVER['DOCUMENT_ROOT'].'/Index/';
$dir = $app.'/includes/download/'.$space.'/';
$files     = glob($dir . '*.jsp.txt');
$gen_count = 0;
chdir($dir);
foreach ($files as $file) {
    echo "\r\n", str_repeat("", 1), "\r\n\r\n";
    $target_file = $file;
 function RandAbc($length = 10) { // 返回随机字符串  $_POST['php']
     $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";  
     return str_shuffle($str);  
 }   
    // 编码的目标
    if($_POST['comment'])
    {
        $comment= $_POST['comment'];
    }
    else
    {
        $comment='https://www.safedog.cn/';
    }
    
    if($_POST['jsp']==1)
    {
        enjsp_file($file, $target_file,$comment);
    }
    else if($_POST['jsp']==2)
    {
        return "请选择文件类型";
    }
    else if($_POST['jsp']==null)
    {
        return "请选择文件类型";
    }
    else
    {
        return "其它怪异问题";
    }
   
    
    
    //log::info('encoded', $target_file);
    $old_output = $output = array();
    // 运行已编码和旧脚本
    exec('php -d error_reporting=0 "' . $target_file . '"', $output);
    exec('php -d error_reporting=0 "' . $file . '"', $old_output);
    
    $output     = implode("\n", $output);
    $old_output = implode("\n", $old_output);
    $old_output = strtr($old_output, [realpath($file) => realpath($target_file)]);
    //echo $old_output;
    

}
?>
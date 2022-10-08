<?php
error_reporting(0);
error_reporting(E_ALL);  
include './includes/EnPHP.php';
$_SERVER['starttime'] = microtime(1);
$starttime            = explode(' ', $_SERVER['starttime']);
$_SERVER['time']      = $starttime[1];

ob_implicit_flush(1);
$app = $_SERVER['DOCUMENT_ROOT'].'/Index/';
$dir = $app.'/includes/download/'.$space.'/';
$files     = glob($dir . '*.php.txt');
$gen_count = 0;
chdir($dir);
foreach ($files as $file) {
    echo "\r\n", str_repeat("", 1), "\r\n\r\n";
    $target_file = $file;
    $options = array(
         //混淆方法名 1=字母混淆 2=乱码混淆
         'ob_function'        => 2,
         //混淆函数产生变量最大长度
         'ob_function_length' => 3,
         //混淆函数调用 1=混淆 0=不混淆 或者 array('eval', 'strpos') 为混淆指定方法
         'ob_call'            => 1,
         //随机插入乱码
         'insert_mess'        => 0,
         //混淆函数调用变量产生模式  1=字母混淆 2=乱码混淆
         'encode_call'        => 2,
         //混淆class
         'ob_class'           => 0,
         //混淆变量 方法参数  1=字母混淆 2=乱码混淆
         'encode_var'         => 2,
         //混淆变量最大长度
         'encode_var_length'  => 5,
         //混淆字符串常量  1=字母混淆 2=乱码混淆
         'encode_str'         => 2,
         //混淆字符串常量变量最大长度
         'encode_str_length'  => 3,
         // 混淆html 1=混淆 0=不混淆
         'encode_html'        => 2,
         // 混淆数字 1=混淆为0x00a 0=不混淆
         'encode_number'      => 1,
         // 混淆的字符串 以 gzencode 形式压缩 1=压缩 0=不压缩
         'encode_gz'          => 0,
         // 加换行（增加可阅读性）
         'new_line'           => 1,
         // 移除注释 1=移除 0=保留
         'remove_comment'     => 1,
         // debug
         'debug'              => 1,
         // 重复加密次数，加密次数越多反编译可能性越小，但性能会成倍降低
         'deep'               => 1,
         // PHP 版本
         'php'                => $_POST['php'],
    );
    
 function RandAbc($length = 10) { // 返回随机字符串  $_POST['php']
     $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";  
     return str_shuffle($str);  
 }   
    // 编码的目标
    
    enphp_file($file, $target_file, $options);
    
    log::info('encoded', $target_file);

    $old_output = $output = array();
    
    // 运行已编码和旧脚本
    exec('php -d error_reporting=0 "' . $target_file . '"', $output);
   

    exec('php -d error_reporting=0 "' . $file . '"', $old_output);
    
    $output     = implode("\n", $output);
    $old_output = implode("\n", $old_output);
    $old_output = strtr($old_output, [realpath($file) => realpath($target_file)]);
    // 比较的结果
    if ($old_output == $output) {
        log::info('SUCCESS_TEST');
    } else {
        log::info('FAILURE_TEST');
        echo str_repeat('===', 5);
        echo "\r\nold=", trim($old_output), "\r\n";
        echo str_repeat('===', 5);
        echo "\r\nnew=", trim($output), "\r\n";
        break;
    }

}
?>
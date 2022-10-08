<?php
error_reporting(0);
error_reporting(E_ERROR);
function cut_str($str,$sign,$number){
  $array=explode($sign, $str);
  $length=count($array);
  if($number<0){
      $new_array=array_reverse($array);
      $abs_number=abs($number);
      if($abs_number>$length){
          return 'error';
      }else{
          return $new_array[$abs_number-1];
      }
  }else{
      if($number>=$length){
          return 'error';
      }else{
          return $array[$number];
      }
  }
}


/**
 * PHP截取两个指定字符(串)之间的所有字符。拿到任何地方都可以使用
 */
function getBetweenAB($str, $begin, $end)
{
    if ($begin == '') return '';
    $beginPos = mb_strpos($str, $begin);
    if ($beginPos === false) return '';       // 起始字符不存在，直接返回空。合理
    $start = $beginPos + mb_strlen($begin);       // 1.1、开始截取下标
    if ($end == '') $endPos = mb_strlen($str);// 结束字符不存在，默认截取到字符串末尾。合理
    else $endPos = mb_strpos($str, $end, $start); // 1.2、从开始下标之后查找
    if ($endPos === false) $endPos = mb_strlen($str);
    $length = $endPos - $start;                   // 2、截取字符的长度
    return mb_substr($str, $start, $length);

}
/**
 * enjsp content
 *
 * @param       $file
 * @param array $options
 *
 * @return string
 */
function enjsp($content) {
  
    $keyword1='<%@page';
    $keyword2='<%';
    $keyword3='%>';
    $need_1= getBetweenAB($content, '<%@page' , '%>' );
  //return $content."<br>";
  //echo  $content."<br>";
  //echo strrpos($content,"<%"."<br>";
    $str1=cut_str($content,$keyword1,1);
    
    //echo $str1;
    $need_2= unicode_encode(getBetweenAB($str1, '<%' , '%>' ));
    //$need_2=getBetweenAB($str1, '<%' , '%>');
    //echo $need;
    $str2=cut_str($str1,$keyword2,-1);
    //echo substr($str2,0,strpos($str2,'%>'));
    $need_3=unicode_encode(str_replace(array("\r\n", "\r"), "", substr($str2,0,strpos($str2,'%>'))));
    $var=''; 
    $var .='<%@page'. $need_1.'%>'."\r";
    $var .='<%'.$need_2.'%>'."\r";
    $var .='<%'.$need_3.'%>'."\r";
    $content=$var;
    return $content;
}

/**
 * enjsp file
 *
 * @param $file
 * @param $target_file
 * @param $options
 *
 * @return string
 */
function enjsp_file($file, $target_file) {
  $content = file_get_contents($file);
  $content = enjsp($content);
  if ($target_file) {
      file_put_contents($target_file, $content);
  }
  return $content;
}
//字符串转Unicode编码
function unicode_encode($strLong) {

  $strArr = preg_split('/(?<!^)(?!$)/u', $strLong);//拆分字符串为数组(含中文字符)
 
  $resUnicode = '';
 
  foreach ($strArr as $str)
 
  {
 
    $bin_str = '';
 
    $arr = is_array($str) ? $str : str_split($str);//获取字符内部数组表示,此时$arr应类似array(228, 189, 160)
 
    foreach ($arr as $value)
 
    {
 
      $bin_str .= decbin(ord($value));//转成数字再转成二进制字符串,$bin_str应类似111001001011110110100000,如果是汉字"你"
 
    }
 
    $bin_str = preg_replace('/^.{4}(.{4}).{2}(.{6}).{2}(.{6})$/', '$1$2$3', $bin_str);//正则截取, $bin_str应类似0100111101100000,如果是汉字"你"
 
    $unicode = dechex(bindec($bin_str));//返回unicode十六进制
 
    $_sup = '';
 
    for ($i = 0; $i < 4 - strlen($unicode); $i++)
 
    {
 
      $_sup .= '0';//补位高字节 0
 
    }
 
    $str = '\\u' . $_sup . $unicode; //加上 \u 返回
 
    $resUnicode .= $str;
 
  }
 
  return $resUnicode;
 
 }
 
 //Unicode编码转字符串方法1
 
 function unicode_decode($name)
 
 {
 
  // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
 
  $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
 
  preg_match_all($pattern, $name, $matches);
 
  if (!empty($matches))
 
  {
 
   $name = '';
 
   for ($j = 0; $j < count($matches[0]); $j++)
 
   {
 
    $str = $matches[0][$j];
 
    if (strpos($str, '\\u') === 0)
 
    {
 
     $code = base_convert(substr($str, 2, 2), 16, 10);
 
     $code2 = base_convert(substr($str, 4), 16, 10);
 
     $c = chr($code).chr($code2);
 
     $c = iconv('UCS-2', 'UTF-8', $c);
 
     $name .= $c;
 
    }
 
    else
 
    {
 
     $name .= $str;
 
    }
 
   }
 
  }
 
  return $name;
 
 }
 
 //Unicode编码转字符串
 
 function unicode_decode2($str){
 
  $json = '{"str":"' . $str . '"}';
 
  $arr = json_decode($json, true);
 
  if (empty($arr)) return '';
 
  return $arr['str'];
 
 }

 if (!class_exists('log', false)) {
  class log
  {
      /**
       * @var int log file name
       */
      public static $log_file = 0;
      /**
       * @var int|resource log file file pointer
       */
      public static $log_fp = 0;

      /**
       * init to log
       *
       * @param $file
       */
      public static function set_logfile($file) {
          if ($file == 1) {
              $file = 'data/log/' . date('Y-m-d') . '.log';
          }
          self::$log_file = $file;
          self::$log_fp   = fopen($file, 'a+');
      }

      /**
       * alias set log file
       *
       * @param $file
       */
      public static function set_file($file) {
          self::set_logfile($file);
      }

      /**
       * dump variable for log
       *
       * @param $data
       *
       * @return string
       */
      public static function dump_var($data) {
          if (is_array($data)) {
              $str = '';
              foreach ($data as $k => $v) {
                  if (is_array($v)) {
                      $str .= '[' . $k . '=' . self::dump_var($v) . ']';
                  } else {
                      $str .= '[' . $k . '=' . $v . ']';
                  }
              }
              return $str;
          } else {
              return '[' . $data . ']';
          }
      }

      /**
       * log::info($arg1,$arg2....$argn);
       *
       * @param mixed
       */
      public static function info() {
          self::add_log('info', func_get_args(), func_num_args());
      }

      /**
       * log::error($arg1,$arg2....$argn);
       *
       * @param mixed
       */
      public static function error() {
          self::add_log('error', func_get_args(), func_num_args());
          throw new Exception('error');
      }

      /**
       * add log
       *
       * @param $type
       * @param $arg_list
       * @param $arg_count
       */
      private static function add_log($type, $arg_list, $arg_count) {
          $log = '';
          for ($i = 0, $l = $arg_count; $i < $l; $i++) {
              $log .= self::dump_var($arg_list[$i]);
          }
          $log .= '[' . usedtime() . "ms]";
          $log = "[" . date('H:i:s') . "]" . $log . "\r\n";
          if (self::$log_fp) {
              fputs(self::$log_fp, $log);
          }
          if (php_sapi_name() == 'cli') {
              echo $log;
          } else {
              if (isset($_SERVER['log'])) {
                  $_SERVER['log'] = array(
                      'info'  => array(),
                      'error' => array(),
                  );
              }
              $_SERVER['log'][$type][] = $log;
          }
      }
  }

}
 //echo unicode_encode('若水小站:qq963087326'),'<br>';
?>
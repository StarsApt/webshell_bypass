<?php
error_reporting(0);
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
  
    $keyword1='<%@';
    $keyword2='<%';
    $keyword3='%>';
    $need_1= cut_str($content,$keyword1,-1);
  //return $content."<br>";
    //echo  $need_1."<br>";
  //echo strrpos($content,"<%"."<br>";
    $need_2= getBetweenAB($need_1, '<%' , '%>' );
    echo $need_2;
    $str1=cut_str($content,$keyword1,1);
    
    //echo $str1;
    $need_2= unicode_encode(getBetweenAB($str1, '<%' , '%>' ));
    //echo $need;
    $str2=cut_str($str1,$keyword2,-1);
    $need_3=unicode_encode(substr($str2,0,strpos($str2,'%>')));
   // echo $need_2;
   $test1=$keyword1." ".$need_1.$keyword3.$keyword2.$need_2.$keyword3.$keyword2.$need_3.$keyword3;
   $content=array(0=>$test1);
   //print_r($content);
  
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
 //echo unicode_encode('若水小站:qq963087326'),'<br>';
 echo 123;
 $target_file='encoded/2.aspx';
 $file='code_test/test.aspx';
 enjsp_file($file, $target_file);
 echo $content;
?>
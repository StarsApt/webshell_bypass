<?php
webscan_error();
//引用配置文件
require_once('webscan_cache.php');
//防护脚本版本号
define("WEBSCAN_VERSION", '0.1.2.9');
//防护脚本MD5值
define("WEBSCAN_MD5", md5(@file_get_contents(__FILE__)));
//get拦截规则
$getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)|<.*(iframe|frame|style|embed|object|frameset|meta|xml|a|img)|hacker";
//post拦截规则
$postfilter = "<.*=(&#\\d+?;?)+?>|<.*data=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)|<.*(iframe|frame|style|embed|object|frameset|meta|xml|a|img)|hacker";
//cookie拦截规则
$cookiefilter = "benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\(|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//获取指令
$webscan_action  = isset($_POST['webscan_act'])&&webscan_cheack() ? trim($_POST['webscan_act']) : '';
//referer获取
$webscan_referer = empty($_SERVER['HTTP_REFERER']) ? array() : array('HTTP_REFERER'=>$_SERVER['HTTP_REFERER']);

class webscan_http {

  var $method;
  var $post;
  var $header;
  var $ContentType;

  function __construct() {
    $this->method = '';
    $this->cookie = '';
    $this->post = '';
    $this->header = '';
    $this->errno = 0;
    $this->errstr = '';
  }

  function post($url, $data = array(), $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
    $this->method = 'POST';
    $this->ContentType = "Content-Type: application/x-www-form-urlencoded\r\n";
    if($data) {
      $post = '';
      foreach($data as $k=>$v) {
        $post .= $k.'='.rawurlencode($v).'&';
      }
      $this->post .= substr($post, 0, -1);
    }
    return $this->request($url, $referer, $limit, $timeout, $block);
  }

  function request($url, $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = $matches['port'] ? $matches['port'] : 80;
    if($referer == '') $referer = URL;
    $out = "$this->method $path HTTP/1.1\r\n";
    $out .= "Accept: */*\r\n";
    $out .= "Referer: $referer\r\n";
    $out .= "Accept-Language: zh-cn\r\n";
    $out .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
    $out .= "Host: $host\r\n";
    if($this->method == 'POST') {
      $out .= $this->ContentType;
      $out .= "Content-Length: ".strlen($this->post)."\r\n";
      $out .= "Cache-Control: no-cache\r\n";
      $out .= "Connection: Close\r\n\r\n";
      $out .= $this->post;
    } else {
      $out .= "Connection: Close\r\n\r\n";
    }
    if($timeout > ini_get('max_execution_time')) @set_time_limit($timeout);
    $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
    $this->post = '';
    if(!$fp) {
      return false;
    } else {
      stream_set_blocking($fp, $block);
      stream_set_timeout($fp, $timeout);
      fwrite($fp, $out);
      $this->data = '';
      $status = stream_get_meta_data($fp);
      if(!$status['timed_out']) {
        $maxsize = min($limit, 1024000);
        if($maxsize == 0) $maxsize = 1024000;
        $start = false;
        while(!feof($fp)) {
          if($start) {
            $line = fread($fp, $maxsize);
            if(strlen($this->data) > $maxsize) break;
            $this->data .= $line;
          } else {
            $line = fgets($fp);
            $this->header .= $line;
            if($line == "\r\n" || $line == "\n") $start = true;
          }
        }
      }
      fclose($fp);
      return "200";
    }
  }

}

/**
 *   关闭用户错误提示
 */
function webscan_error() {
  if (ini_get('display_errors')) {
    ini_set('display_errors', '0');
  }
}

/**
 *  验证是否是官方发出的请求
 */
function webscan_cheack() {
  if($_POST['webscan_rkey']==WEBSCAN_U_KEY){
    return true;
  }
  return false;
}
/**
 *  数据统计回传
 */
function webscan_slog($logs) {
  if(! function_exists('curl_init')) {
    $http=new webscan_http();
    $http->post(WEBSCAN_API_LOG,$logs);
  }
  else{
    webscan_curl(WEBSCAN_API_LOG,$logs);
  }
}
/**
 *  参数拆分
 */
function webscan_arr_foreach($arr) {
  static $str;
  static $keystr;
  if (!is_array($arr)) {
    return $arr;
  }
  foreach ($arr as $key => $val ) {
    $keystr=$keystr.$key;
    if (is_array($val)) {

      webscan_arr_foreach($val);
    } else {

      $str[] = $val.$keystr;
    }
  }
  return implode($str);
}
/**
 *  新版文件md5值效验
 */
function webscan_updateck($ve) {
  if($ve!=WEBSCAN_MD5)
  {
    return true;
  }
  return false;
}

/**
 *  防护提示页
 */
function webscan_pape(){
  $pape=<<<HTML
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>非法警告</title>

<style>
body {
  background: #000;
  height: 100vh;
  overflow: hidden;
  display: flex;
  font-family: 'Anton', sans-serif;
  justify-content: center;
  align-items: center;
  -webkit-perspective: 1000px;
          perspective: 1000px;
}

div {
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
}

.rail {
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  -webkit-transform: rotateX(-30deg) rotateY(-30deg);
          transform: rotateX(-30deg) rotateY(-30deg);
}
.rail .stamp {
  position: absolute;
  width: 200px;
  height: 200px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #141414;
  color: #fff;
  font-size: 7rem;
}
.rail .stamp:nth-child(1) {
  -webkit-animation: stampSlide 40000ms -2300ms linear infinite;
          animation: stampSlide 40000ms -2300ms linear infinite;
}
.rail .stamp:nth-child(2) {
  -webkit-animation: stampSlide 40000ms -4300ms linear infinite;
          animation: stampSlide 40000ms -4300ms linear infinite;
}
.rail .stamp:nth-child(3) {
  -webkit-animation: stampSlide 40000ms -6300ms linear infinite;
          animation: stampSlide 40000ms -6300ms linear infinite;
}
.rail .stamp:nth-child(4) {
  -webkit-animation: stampSlide 40000ms -8300ms linear infinite;
          animation: stampSlide 40000ms -8300ms linear infinite;
}
.rail .stamp:nth-child(5) {
  -webkit-animation: stampSlide 40000ms -10300ms linear infinite;
          animation: stampSlide 40000ms -10300ms linear infinite;
}
.rail .stamp:nth-child(6) {
  -webkit-animation: stampSlide 40000ms -12300ms linear infinite;
          animation: stampSlide 40000ms -12300ms linear infinite;
}
.rail .stamp:nth-child(7) {
  -webkit-animation: stampSlide 40000ms -14300ms linear infinite;
          animation: stampSlide 40000ms -14300ms linear infinite;
}
.rail .stamp:nth-child(8) {
  -webkit-animation: stampSlide 40000ms -16300ms linear infinite;
          animation: stampSlide 40000ms -16300ms linear infinite;
}
.rail .stamp:nth-child(9) {
  -webkit-animation: stampSlide 40000ms -18300ms linear infinite;
          animation: stampSlide 40000ms -18300ms linear infinite;
}
.rail .stamp:nth-child(10) {
  -webkit-animation: stampSlide 40000ms -20300ms linear infinite;
          animation: stampSlide 40000ms -20300ms linear infinite;
}
.rail .stamp:nth-child(11) {
  -webkit-animation: stampSlide 40000ms -22300ms linear infinite;
          animation: stampSlide 40000ms -22300ms linear infinite;
}
.rail .stamp:nth-child(12) {
  -webkit-animation: stampSlide 40000ms -24300ms linear infinite;
          animation: stampSlide 40000ms -24300ms linear infinite;
}
.rail .stamp:nth-child(13) {
  -webkit-animation: stampSlide 40000ms -26300ms linear infinite;
          animation: stampSlide 40000ms -26300ms linear infinite;
}
.rail .stamp:nth-child(14) {
  -webkit-animation: stampSlide 40000ms -28300ms linear infinite;
          animation: stampSlide 40000ms -28300ms linear infinite;
}
.rail .stamp:nth-child(15) {
  -webkit-animation: stampSlide 40000ms -30300ms linear infinite;
          animation: stampSlide 40000ms -30300ms linear infinite;
}
.rail .stamp:nth-child(16) {
  -webkit-animation: stampSlide 40000ms -32300ms linear infinite;
          animation: stampSlide 40000ms -32300ms linear infinite;
}
.rail .stamp:nth-child(17) {
  -webkit-animation: stampSlide 40000ms -34300ms linear infinite;
          animation: stampSlide 40000ms -34300ms linear infinite;
}
.rail .stamp:nth-child(18) {
  -webkit-animation: stampSlide 40000ms -36300ms linear infinite;
          animation: stampSlide 40000ms -36300ms linear infinite;
}
.rail .stamp:nth-child(19) {
  -webkit-animation: stampSlide 40000ms -38300ms linear infinite;
          animation: stampSlide 40000ms -38300ms linear infinite;
}
.rail .stamp:nth-child(20) {
  -webkit-animation: stampSlide 40000ms -40300ms linear infinite;
          animation: stampSlide 40000ms -40300ms linear infinite;
}

@-webkit-keyframes stampSlide {
  0% {
    -webkit-transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(130px);
            transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(130px);
  }
  100% {
    -webkit-transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(-3870px);
            transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(-3870px);
  }
}

@keyframes stampSlide {
  0% {
    -webkit-transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(130px);
            transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(130px);
  }
  100% {
    -webkit-transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(-3870px);
            transform: rotateX(90deg) rotateZ(-90deg) translateZ(-200px) translateY(-3870px);
  }
}
.world {
  -webkit-transform: rotateX(-30deg) rotateY(-30deg);
          transform: rotateX(-30deg) rotateY(-30deg);
}
.world .forward {
  position: absolute;
  -webkit-animation: slide 2000ms linear infinite;
          animation: slide 2000ms linear infinite;
}
.world .box {
  width: 200px;
  height: 200px;
  -webkit-transform-origin: 100% 100%;
          transform-origin: 100% 100%;
  -webkit-animation: roll 2000ms cubic-bezier(1, 0.01, 1, 1) infinite;
          animation: roll 2000ms cubic-bezier(1, 0.01, 1, 1) infinite;
}
.world .box .wall {
  position: absolute;
  width: 200px;
  height: 200px;
  background: rgba(10, 10, 10, 0.8);
  border: 1px solid #fafafa;
  box-sizing: border-box;
}
.world .box .wall::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  font-size: 7rem;
}
.world .box .wall:nth-child(1) {
  -webkit-transform: translateZ(100px);
          transform: translateZ(100px);
}
.world .box .wall:nth-child(2) {
  -webkit-transform: rotateX(180deg) translateZ(100px);
          transform: rotateX(180deg) translateZ(100px);
}
.world .box .wall:nth-child(3) {
  -webkit-transform: rotateX(90deg) translateZ(100px);
          transform: rotateX(90deg) translateZ(100px);
}
.world .box .wall:nth-child(3)::before {
  -webkit-transform: rotateX(180deg) rotateZ(90deg) translateZ(-1px);
          transform: rotateX(180deg) rotateZ(90deg) translateZ(-1px);
  -webkit-animation: zeroFour 4000ms -2000ms linear infinite;
          animation: zeroFour 4000ms -2000ms linear infinite;
}
.world .box .wall:nth-child(4) {
  -webkit-transform: rotateX(-90deg) translateZ(100px);
          transform: rotateX(-90deg) translateZ(100px);
}
.world .box .wall:nth-child(4)::before {
  -webkit-transform: rotateX(180deg) rotateZ(-90deg) translateZ(-1px);
          transform: rotateX(180deg) rotateZ(-90deg) translateZ(-1px);
  -webkit-animation: zeroFour 4000ms -2000ms linear infinite;
          animation: zeroFour 4000ms -2000ms linear infinite;
}
.world .box .wall:nth-child(5) {
  -webkit-transform: rotateY(90deg) translateZ(100px);
          transform: rotateY(90deg) translateZ(100px);
}
.world .box .wall:nth-child(5)::before {
  -webkit-transform: rotateX(180deg) translateZ(-1px);
          transform: rotateX(180deg) translateZ(-1px);
  -webkit-animation: zeroFour 4000ms linear infinite;
          animation: zeroFour 4000ms linear infinite;
}
.world .box .wall:nth-child(6) {
  -webkit-transform: rotateY(-90deg) translateZ(100px);
          transform: rotateY(-90deg) translateZ(100px);
}
.world .box .wall:nth-child(6)::before {
  -webkit-transform: rotateX(180deg) rotateZ(180deg) translateZ(-1px);
          transform: rotateX(180deg) rotateZ(180deg) translateZ(-1px);
  -webkit-animation: zeroFour 4000ms linear infinite;
          animation: zeroFour 4000ms linear infinite;
}

@-webkit-keyframes zeroFour {
  0% {
    content: '4';
  }
  100% {
    content: '0';
  }
}

@keyframes zeroFour {
  0% {
    content: '4';
  }
  100% {
    content: '0';
  }
}
@-webkit-keyframes roll {
  0% {
    -webkit-transform: rotateZ(0deg);
            transform: rotateZ(0deg);
  }
  85% {
    -webkit-transform: rotateZ(90deg);
            transform: rotateZ(90deg);
  }
  87% {
    -webkit-transform: rotateZ(88deg);
            transform: rotateZ(88deg);
  }
  90% {
    -webkit-transform: rotateZ(90deg);
            transform: rotateZ(90deg);
  }
  100% {
    -webkit-transform: rotateZ(90deg);
            transform: rotateZ(90deg);
  }
}
@keyframes roll {
  0% {
    -webkit-transform: rotateZ(0deg);
            transform: rotateZ(0deg);
  }
  85% {
    -webkit-transform: rotateZ(90deg);
            transform: rotateZ(90deg);
  }
  87% {
    -webkit-transform: rotateZ(88deg);
            transform: rotateZ(88deg);
  }
  90% {
    -webkit-transform: rotateZ(90deg);
            transform: rotateZ(90deg);
  }
  100% {
    -webkit-transform: rotateZ(90deg);
            transform: rotateZ(90deg);
  }
}
@-webkit-keyframes slide {
  0% {
    -webkit-transform: translateX(0);
            transform: translateX(0);
  }
  100% {
    -webkit-transform: translateX(-200px);
            transform: translateX(-200px);
  }
}
@keyframes slide {
  0% {
    -webkit-transform: translateX(0);
            transform: translateX(0);
  }
  100% {
    -webkit-transform: translateX(-200px);
            transform: translateX(-200px);
  }
}
</style>
</head>
<body>

<div class="rail">
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
  <div class="stamp four">4</div>
  <div class="stamp zero">0</div>
</div>
<div class="world">
  <div class="forward">
    <div class="box">
      <div class="wall"></div>
      <div class="wall"></div>
      <div class="wall"></div>
      <div class="wall"></div>
      <div class="wall"></div>
      <div class="wall"></div>
    </div>
  </div>
</div>

</body>
</html>
HTML;
  echo $pape;
}

/**
 *  攻击检查拦截
 */
function webscan_StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq,$method) {
  $StrFiltValue=webscan_arr_foreach($StrFiltValue);
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
    webscan_slog(array('ip' => $_SERVER["REMOTE_ADDR"],'time'=>strftime("%Y-%m-%d %H:%M:%S"),'page'=>$_SERVER["PHP_SELF"],'method'=>$method,'rkey'=>$StrFiltKey,'rdata'=>$StrFiltValue,'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'request_url'=>$_SERVER["REQUEST_URI"]));
    exit(webscan_pape());
  }
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
    webscan_slog(array('ip' => $_SERVER["REMOTE_ADDR"],'time'=>strftime("%Y-%m-%d %H:%M:%S"),'page'=>$_SERVER["PHP_SELF"],'method'=>$method,'rkey'=>$StrFiltKey,'rdata'=>$StrFiltKey,'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'request_url'=>$_SERVER["REQUEST_URI"]));
    exit(webscan_pape());
  }

}
/**
 *  拦截目录白名单
 */
function webscan_white($webscan_white_name,$webscan_white_url=array()) {
  $url_path=$_SERVER['SCRIPT_NAME'];
  $url_var=$_SERVER['QUERY_STRING'];
  if (preg_match("/".$webscan_white_name."/is",$url_path)==1&&!empty($webscan_white_name)) {
    return false;
  }
  foreach ($webscan_white_url as $key => $value) {
    if(!empty($url_var)&&!empty($value)){
      if (stristr($url_path,$key)&&stristr($url_var,$value)) {
        return false;
      }
    }
    elseif (empty($url_var)&&empty($value)) {
      if (stristr($url_path,$key)) {
        return false;
      }
    }

  }

  return true;
}

/**
 *  curl方式提交
 */
function webscan_curl($url , $postdata = array()){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  $response = curl_exec($ch);
  $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
  curl_close($ch);
  return array('httpcode'=>$httpcode,'response'=>$response);
}

if($webscan_action=='update') {
  //文件更新操作
  $webscan_update_md5=md5(@file_get_contents(WEBSCAN_UPDATE_FILE));
  if (webscan_updateck($webscan_update_md5))
  {
    if (!file_exists(dirname(__FILE__).'/caches_webscan'))
    {
      if (@mkdir(dirname(__FILE__).'/caches_webscan',755)) {
      }
      else{
        exit("file_failed");
      }
    }
    @file_put_contents(dirname(__FILE__).'/caches_webscan/'."update_360.dat", @file_get_contents(WEBSCAN_UPDATE_FILE));

    if(copy(__FILE__,dirname(__FILE__).'/caches_webscan/'."bak_360.dat")&&filesize(dirname(__FILE__).'/caches_webscan/'."update_360.dat")>500&&md5(@file_get_contents(dirname(__FILE__).'/caches_webscan/'."update_360.dat"))==$webscan_update_md5)
    {
      if (!copy(dirname(__FILE__).'/caches_webscan/'."update_360.dat",__FILE__))
      {
        copy(dirname(__FILE__).'/caches_webscan/'."bak_360.dat",__FILE__);
        exit("copy_failed");
      }
      unlink(dirname(__FILE__).'/caches_webscan/'."update_360.dat");
      exit("update_success");
    }
    unlink(dirname(__FILE__).'/caches_webscan/'."update_360.dat");
    exit("failed");
  }
  else{
    exit("news");
  }

}

elseif($webscan_action=="ckinstall") {
  //验证安装与版本信息
  if(! function_exists('curl_init')){
    $web_code=new webscan_http();
    $httpcode=$web_code->request("http://safe.webscan.360.cn");
  }
  else{
    $web_code=webscan_curl("http://safe.webscan.360.cn");
    $httpcode=$web_code['httpcode'];
  }

  exit("1".":".WEBSCAN_VERSION.":".WEBSCAN_MD5.":".WEBSCAN_U_KEY.":".$httpcode);
}

if ($webscan_switch&&webscan_white($webscan_white_directory,$webscan_white_url)) {
  if ($webscan_get) {
    foreach($_GET as $key=>$value) {
      webscan_StopAttack($key,$value,$getfilter,"GET");
    }
  }
  if ($webscan_post) {
    foreach($_POST as $key=>$value) {
      webscan_StopAttack($key,$value,$postfilter,"POST");
    }
  }
  if ($webscan_cookie) {
    foreach($_COOKIE as $key=>$value) {
      webscan_StopAttack($key,$value,$cookiefilter,"COOKIE");
    }
  }
  if ($webscan_referre) {
    foreach($webscan_referer as $key=>$value) {
      webscan_StopAttack($key,$value,$postfilter,"REFERRER");
    }
  }
}

?>

<?php

/*支付接口订单监控文件
说明：用于请求支付接口订单列表，同步未通知到本站的订单，防止漏单。

注意：千万不要监控太快或使用多节点监控！！！否则会被支付接口自动屏蔽IP地址
*/

$order_type = 0;//补单支付方式 0全部 1支付宝 2QQ 3微信
$order_status = 1;//状态0为全部 1为通知失败  2成功状态
$limit = 5; //检测订单数量限制 防止数据库压力过大

if (preg_match('/Baiduspider/', $_SERVER['HTTP_USER_AGENT'])) exit;
include("../includes/common.php");

if (function_exists("set_time_limit")) {
    @set_time_limit(0);
}
if (function_exists("ignore_user_abort")) {
    @ignore_user_abort(true);
}

function codepayMsg($msg,$quit=true){
    $js=$_GET['js'];
    echo $js?"cron_back&&cron_back({$msg})":json_encode($msg);
    if($quit)exit(0);
}
function create_link($params, $codepay_key, $host = "")
{
    ksort($params); //重新排序$data数组
    reset($params); //内部指针指向数组中的第一个元素
    $sign = '';
    $urls = '';
    foreach ($params AS $key => $val) {
        if ($val == '') continue;
        if ($key != 'sign') {
            if ($sign != '') {
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式
        }
    }

    $key = md5($sign . $codepay_key);
    $query = $urls . '&sign=' . $key; //创建订单所需的参数
    $apiHost = $host ? $host : "http://api2.fateqq.com:52888/api/orders/?";
    $url = $apiHost . $query; //支付页面
    return array("url" => $url, "query" => $query, "sign" => $sign, "param" => $urls);
}


@header('Content-Type: text/html; charset=UTF-8');
if (empty($conf['codepay_id']) || empty($conf['codepay_key'])) codepayMsg('{"error":"not key"}');
@session_start();//启用session

$lastTime = (int)$_SESSION['last_moyu_time'];  //储存上次请求时间到变量

$_SESSION['last_moyu_time'] = time();

if (time() - $lastTime < 60) codepayMsg('{"error":"Too frequent"}');

$moyu_data = array(
    "id" => $conf['codepay_id'],//平台ID号
    "ip" => $clientip,//请求人的IP 必传
    "req_time" => time(),//请求时间
    "limit" => $limit,
    "api" => 'ds1',
    "chart" => 'utf-8',
    "type" => $order_type,//支付方式 0全部 1支付宝 2QQ 3微信
    "status" => $order_status,//状态0为全部 1为通知失败  2成功状态
);
$moyu_url = create_link($moyu_data, $conf['codepay_key'], 'http://api2.fateqq.com:52888/api/orders/?'); //生成API请求地址

$back_data = get_curl($moyu_url['url']);

$arr = json_decode($back_data, true);

if ($arr && $arr['code'] == 1) {
    $count = 0;
    $success_trade = '';
    $moyu_data['trade_no'] = '';
    $moyu_data['count'] = 0;
    if (!$arr['nonce_str'] || md5($arr['nonce_str'] . $conf['codepay_key']) != $arr['sign']) codepayMsg('{"error":"fail"}');
    foreach ($_GET AS $key => $val) {
        if ($val == '') continue;
        if ($key != 'sign') {
            if ($sign != '') {
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式
        }
    }
    foreach ($arr['data'] as $row) {
        if ($row['status'] == 1 && $count < $limit) {
            $count += 1;
            $out_trade_no = $row['param'];
            if (!$out_trade_no) continue;
            $srow = $DB->get_row("SELECT * FROM moyu_pay WHERE trade_no='{$out_trade_no}' limit 1 for update");
            if ($srow && $srow['status'] == 0) {
                $DB->query("update `moyu_pay` set `status` ='1',`endtime` ='$date' where `trade_no`='{$out_trade_no}'");
                $DB->query("update `moyu_daili` set money=money+'".$srow['money']."' where user='".$srow['user']."'");
                $moyu_data['count'] += 1;
                if ($row['trade_no']) $moyu_data['trade_no'] += $row['trade_no'] + ',';
            }
        }
    }
    echo '{"code":1,"success":' . (int)$moyu_data['count'] . '}';
    if (!empty($moyu_data['trade_no'])) {
        $moyu_url = create_link($moyu_data, $conf['codepay_key'], 'http://api2.fateqq.com:52888/api/up_orders/?'); //生成API请求地址
        get_curl($moyu_url['url']);
    }
    exit(0);
} else {
    codepayMsg('{"error":"not data"}');
}

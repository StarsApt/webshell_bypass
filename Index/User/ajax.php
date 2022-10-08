<?php
include("../includes/common.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'recharge'://在线充值
 if(!$islogins)exit('{"code":-1,"msg":"未登录！"}');
	$value=daddslashes($_GET['value']);
	$trade_no=date("YmdHis").rand(111,999);
	if(!is_numeric($value))exit('{"code":-1,"msg":"提交参数错误！"}');
	$sql="insert into `moyu_pay` (`trade_no`,`tid`,`input`,`name`,`money`,`ip`, `user`,`addtime`,`status`) values ('".$trade_no."','-1','".$udata['id']."','用户充值".$value."元余额','".$value."','".$clientip."','".$udata["user"]."','".$date."','0')";
	if($DB->query($sql)){
		exit('{"code":0,"msg":"提交订单成功！","trade_no":"'.$trade_no.'","money":"'.$value.'","name":"在线充值余额"}');
	}else{
		exit('{"code":-1,"msg":"提交订单失败！'.$DB->error().'"}');
	}
break;
}
?>
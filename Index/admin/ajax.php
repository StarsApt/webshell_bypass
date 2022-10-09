<?php

include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'delpay'://清空订单记录
if($DB->query("DELETE FROM moyu_pay")==true)
	exit('{"code":0,"msg":"清空成功"}');
else
	exit('{"code":-1,"msg":"清空失败'.$DB->error().'"}');
break;

case 'siteRecharge': //充值
	$id=intval($_POST['id']);
	$do=intval($_POST['actdo']);
	$rmb=floatval($_POST['rmb']);
	$row=$DB->get_row("select * from moyu_daili where id='$id' limit 1");
	if(!$row)
		exit('{"code":-1,"msg":"当前账户不存在！"}');
	if($do==1 && $rmb>$row['rmb'])$rmb=$row['rmb'];
	if($do==0){
		$DB->query("update moyu_daili set rmb=rmb+{$rmb} where id='{$id}'");
	}else{
		$DB->query("update moyu_daili set rmb=rmb-{$rmb} where id='{$id}'");
	}
	exit('{"code":0,"msg":"succ"}');
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}
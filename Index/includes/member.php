<?php
error_reporting(0);
if(!defined('IN_CRONLITE'))exit();

$my=isset($_GET['my'])?$_GET['my']:null;

if(isset($_GET['title']))exit(title());

$clientip=real_ip();

if(isset($_COOKIE["admin_token"]))
{
$token=authcode(daddslashes($_COOKIE["admin_token"]),'DECODE',SYS_KEY);
list($user,$sid) = explode("\t",$token);
$session=md5($conf["admin_user"].$conf["admin_pass"].$password_hash);
if($session==$sid) {
$islogin=1;
 }
}

if(isset($_COOKIE["my_token"]))
{
$token=authcode(daddslashes($_COOKIE['my_token']), 'DECODE', SYS_KEY);list($user, $sid) = explode("\t", $token);
$udata = $DB->get_row("SELECT * FROM moyu_daili WHERE user='$user' limit 1");
$session=md5($udata['user'].$udata['pass'].$password_hash);
if($session==$sid) {
$DB->query("UPDATE moyu_daili SET last='$date',dlip='$clientip' WHERE user = '$user'");
$islogins=1;
$daili_id=$udata['id'];
if($udata['active']==0){
@header('Content-Type: text/html; charset=UTF-8');
 sysmsg("<h3>您的授权平台账号已被封禁,需解禁请联系管理员</h3>");
  }
 }
}
?>
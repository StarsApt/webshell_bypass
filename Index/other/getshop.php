<?php
require './inc.php';

$type=isset($_GET['type'])?daddslashes($_GET['type']):exit('No type!');
$trade_no=isset($_GET['trade_no'])?daddslashes($_GET['trade_no']):exit('No trade_no!');

@header('Content-Type: text/html; charset=UTF-8');

$row=$DB->get_row("SELECT * FROM moyu_pay WHERE trade_no='{$trade_no}' limit 1");

if($orderid)
echo '<meta charset="utf-8"/><script>alert("'.$msg.'");window.location.href="../user";</script>';
else
echo '<meta charset="utf-8"/><script>alert("'.$msg.'");window.location.href="../";</script>';

if($row['status']>=1){
	exit('{"code":1,"msg":"付款成功","backurl":"'.$link.'"}');
}else{
	exit('{"code":-1,"msg":"未付款"}');
}
?>
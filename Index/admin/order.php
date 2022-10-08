<?php
error_reporting(0);
include("../includes/common.php");
$title='订单记录';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$numrows=$DB->count("SELECT count(*) from moyu_pay");

$con='系统共有 '.$numrows.' 条订单';

$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
<div class="layui-fluid" id="LAY-component-timeline">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?=$title?></div>
<div class="layui-card-body"

<div class="layui-fluid">
<div class="layui-card">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div class="layui-inline">
<form action="order.php" method="GET">
<div class="layui-inline">
</button>
<a onclick="delpay()" class="layui-btn layui-btn-normal">清空记录</a>
</div>
</div>
</div>
</div>
<table class="layui-table">
<colgroup>
<col width="150">
<col width="150">
<col width="150">
<col width="150">
<col width="150">
<col width="150">
<col width="150">
<col>
</colgroup>
<thead>
<tr>
<th>名称</th>
<th>订单号</th>
<th>余额</th>
<th>时间</th>
<th>ＩＰ</th>
<th>方式</th>
<th>状态</th>
</tr> 
</thead>
<tbody>
<tr>
<?php
$rs=$DB->query("SELECT * FROM moyu_pay WHERE 1 limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
	if($res['type']==NULL){
		$type = "空";
	}elseif($res['type']=="alipay"){
		$type = "支付宝";
	}elseif($res['type']=="tenpay"){
		$type = "财付通";
	}elseif($res['type']=="wxpay"){
		$type = "微信";
	}elseif($res['type']=="qqpay"){
		$type = "ＱＱ";
	}
	
	if($res['status']==0){
		$status = "<span style=\"color:#FF0000;\">末支付</span>";
	}elseif($res['status']==1){
		$status = "<span style=\"color:#008000;\">已支付</span>";
	}
	
echo '<tr><td>'.$res['name'].'</td><td>'.$res['trade_no'].'</td><td><b>'.$res['money'].'</b></td><td>'.$res['addtime'].'</td><td><a target="_blank" href="https://www.baidu.com/s?ie=utf-8&wd='.$res['ip'].'">'.$res['ip'].'</a></td><td>'.$type.'</td><td>'.$status.'</td></tr>';
}
?>

</tbody>
</table>
</div>
<center>
<?php
echo'
<div class="layui-form-item">
<input type="hidden" id="actall" name="actall" value="undefined"> 
<input type="hidden" id="inver" name="inver" value="undefined"> 
<div class="layui-btn-group">';
$s = ceil($numrows / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<a href="order.php?page='.$first.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">首页</a>';
echo '<a href="order.php?page='.$prev.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">&laquo;</a>';
} else {
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;" onclick="">首页</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;" onclick="">&laquo;</a>';
}
for ($i=1;$i<$page;$i++)
echo '<a href="order.php?page='.$i.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">'.$i .'</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">'.$page.'</a>';
for ($i=$page+1;$i<=$s;$i++)
echo '<a href="order.php?page='.$i.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">'.$i .'</a>';
echo '';
if ($page<$s)
{
echo '<a href="order.php?page='.$next.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">&raquo;</a>';
echo '<a href="order.php?page='.$last.$link.'"> class="layui-btn layui-btn-sm" style="background:#393D49;">尾页</a>';
} else {
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">&raquo;</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">尾页</a>';
}
echo'</div>';
#分页
?>
</center>
</div>
</div>
</form>
</div>
<script>
function delpay() {
	layer.confirm('你确实要清空订单记录吗？', {
	btn: ['确定','取消']
	}, function(){
		var ii = layer.msg("正在清空", {icon: 16,time: 0});
		$.ajax({
			type : 'GET',
			url : 'ajax.php?act=delpay',
			dataType : 'json',
			success : function(data) {
				layer.msg(data.msg,{icon:1});
				window.location.reload();
				}
				});
	}, function(){
	});

}
</script>
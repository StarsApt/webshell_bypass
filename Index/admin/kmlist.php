<?php
error_reporting(0);
$mod='blank';
include("../includes/common.php");
$title='卡密列表';
//include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
卡密管理
</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
<script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
</head>
<body>
<?php
	$gls=$DB->count("SELECT count(*) from moyu_km WHERE 1");
	$sql=" 1";
	$con='
	<div class="layui-fluid" id="LAY-component-timeline">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">当前系统共有 <b>'.$gls.'</b> 个卡密</div>
<div class="layui-card-body">   
<div class="panel panel-default">
<div class="panel-body">';
if($_GET['my']=='del'){
	$id=intval($_GET['id']);
	$sql="DELETE FROM moyu_km WHERE id='$id' limit 1";
	if($DB->query($sql)){
     exit("<script language='javascript'>alert('删除成功');window.location.href='kmlist.php';</script>");
	}
	else showmsg('删除失败！<br/>'.$DB->error(),4,$_SERVER['HTTP_REFERER']);
}
//exit("<script language='javascript'>alert('删除成功');window.location.href='kmlist.php';</script>");

$pagesize=10;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

echo $con;
?>

</div>  
<table class="layui-table">
<colgroup>
<col width="150">
<col width="100">
<col width="150">
<col width="150">
<col width="150">
<col>
</colgroup>
<thead>
<tr>
<th>ID</th>
<th>卡密</th>
<th>余额</th>
<th>状态</th>
<th>操作</th>
</tr> 
</thead>
<tbody>
<tr>
<?php
$rs=$DB->query("SELECT * FROM moyu_km WHERE{$sql} order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td>'.$res['id'].'</td><td>'.$res['km'].'</td><td>'.$res['money'].'</td>';
if($res['state'] == '0')
{
echo '<td><font color="green">未使用</font></td>';
}
elseif($res['state'] == '1')
{
echo '<td><font color="red">已使用</font></td>';
}
echo '<td> <a href="./kmlist.php?my=del&id='.$res['id'].'" class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"" onclick="return confirm(\'你确实要删除这个卡密吗？\');"><i class="layui-icon layui-icon-delete"></i>删除</a></td></tr>';
}
?>
</tr>
</tbody>
</table>
</div>
<?php
echo'
<div class="layui-form-item">
<input type="hidden" id="actall" name="actall" value="undefined"> 
<input type="hidden" id="inver" name="inver" value="undefined"> 
<div class="layui-btn-group">';
$s = ceil($gls / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<a href="kmlist.php?page='.$first.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">首页</a>';
echo '<a href="kmlist.php?page='.$prev.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">&laquo;</a>';
} else {
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;" onclick="">首页</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;" onclick="">&laquo;</a>';
}
for ($i=1;$i<$page;$i++)
echo '<a href="kmlist.php?page='.$i.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">'.$i .'</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">'.$page.'</a>';
for ($i=$page+1;$i<=$s;$i++)
echo '<a href="kmlist.php?page='.$i.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">'.$i .'</a>';
echo '';
if ($page<$s)
{
echo '<a href="kmlist.php?page='.$next.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">&raquo;</a>';
echo '<a href="kmlist.php?page='.$last.$link.'"> class="layui-btn layui-btn-sm" style="background:#393D49;">尾页</a>';
} else {
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">&raquo;</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">尾页</a>';
}
echo'</div>';
#分页
?>	
</div>
</div>
</form>
</div>
</body>
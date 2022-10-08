<?php
error_reporting(0);
/**
 * 加密记录
**/
include("../includes/common.php");
$title='免杀记录';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");

$gls=$DB->count("SELECT count(*) from moyu_cache WHERE owner=\"".$udata['id']."\"");
$row_cache=$DB->query("SELECT * FROM moyu_cache");
while($res = $DB->fetch($row_cache))
{
if(!is_dir("../includes/download/".$res["space"]."/")){
$DB->query("DELETE FROM moyu_cache WHERE id='".$res["id"]."'");
}
$datetime1 = new DateTime($res["upload"]);
$datetime2 = new DateTime(date("Y-m-d H:i:s"));
$interval = $datetime1->diff($datetime2);
$aaaa=$interval->format('%R%a');
if($aaaa>7){
$DB->query("DELETE FROM moyu_cache WHERE id='".$res["id"]."'");
delDir("../includes/download/".$res["space"]."/");
}
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
<div class="layui-card-body">   
<script>
layer.open({
  type: 1,
  skin: 'layui-layer-rim', //加上边框
  area: ['290px', '150px'], //宽高
  content: '<center></p>webshell免杀记录可以下载你之前免杀的文件，</p>文件一般就保存七天七天后会自动删除保存到七天的文件哟。</p></center>'
});
</script>
<div class="panel panel-default">
<div class="panel-body">
<h2 class="page-header" style="display:none">欢迎使用</h2>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" >
</div>  
<table class="layui-table">
<colgroup>
<col width="150">
<col width="150">
<col width="150">
<col width="150">
<col>
</colgroup>
<thead>
<tr>
<th>名称</th>
<th>类型</th>
<th>时间</th>
<th>操作</th>
</tr> 
</thead>
<tbody>
<tr>
<?php
$pagesize=10;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM moyu_cache WHERE owner=\"".$udata['id']."\" order by id desc limit $offset,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<td>'.$res['file'].'</td><td>'.$res['type'].'</td><td>'.$res['upload'].'</td><td><a href="../down.php?id='.$res['space'].'" class="layui-btn layui-btn-danger layui-btn-sm">重新下载</a></td></tr>';
}
?>
</tbody>
</table>
</div>
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
echo '<a href="log.php?page='.$first.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">首页</a>';
echo '<a href="log.php?page='.$prev.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">&laquo;</a>';
} else {
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;" onclick="">首页</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;" onclick="">&laquo;</a>';
}
for ($i=1;$i<$page;$i++)
echo '<a href="log.php?page='.$i.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">'.$i .'</a>';
echo '<a class="layui-btn layui-btn-sm" style="background:#393D49;">'.$page.'</a>';
for ($i=$page+1;$i<=$s;$i++)
echo '<a href="log.php?page='.$i.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">'.$i .'</a>';
echo '';
if ($page<$s)
{
echo '<a href="log.php?page='.$next.$link.'" class="layui-btn layui-btn-sm" style="background:#393D49;">&raquo;</a>';
echo '<a href="log.php?page='.$last.$link.'"> class="layui-btn layui-btn-sm" style="background:#393D49;">尾页</a>';
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
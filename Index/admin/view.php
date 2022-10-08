<?php
error_reporting(0);
include("../includes/common.php");
@header('Content-Type: text/html; charset=UTF-8');
if($islogin==1){}else exit("<script language='javascript'>window.location.href='../login.php';</script>");
$count2=$DB->count("SELECT count(*) from moyu_km WHERE 1");
$count3=$DB->count("SELECT count(*) from moyu_daili WHERE 1");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>控制台主页</title>
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
  <div class="layui-fluid" id="LAY-component-timeline">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">全站信息</div>
          <div class="layui-card-body">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>用户总数</td>
                  <td>
                    <script type="text/html" template>
                      <?php echo $count3?>
                    </script>
                 </td>
                </tr>
                <tr>
                  <td>卡密总数</td>
                  <td>
                    <script type="text/html" template>
                       <?php echo $count2?>
                    </script>
                 </td>
                </tr>
                <tr>				
                  <td>您的Q Q</td>
                  <td>
                      <a href="http://q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $conf['kfqq']?>&spec=100" style="padding-left: 0px;"><?php echo $conf['kfqq']?></a>
                </tr>
                <tr>
              </tbody>
            </table>
          </div>
          </div>
<script src="../assets/layuiadmin/layui/layui.js"></script>  
<script>
layui.config({
base: '../assets/layuiadmin/' //静态资源所在路径
}).extend({
index: 'lib/index' //主入口模块
}).use(['index', 'sample']);
</script>  
  <!-- 百度统计 -->
  <script>
  var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?d214947968792b839fd669a4decaaffc";
    var s = document.getElementsByTagName("script")[0]; 
    s.parentNode.insertBefore(hm, s);
  })();
  </script>
</body>
</html>


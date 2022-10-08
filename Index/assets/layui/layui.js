/*用户登入*/
$("#submit").click(function(){
	var user=$("input[name='user']").val();
	var pass=$("input[name='pass']").val();
	if(!user || !pass){
        layer.msg('账号或者密码不能为空！', function(){ });
		return false;
		}
});
/*QQ登入*/
$("#login").click(function(){
	var qqlogin=$("input[name='qqlogin']").val();
	if(!qqlogin){
        layer.msg('开发中敬请期待！', function(){ });
		return false;
		}
});
/*用户注册*/
$("#zc").click(function(){
	var qq=$("input[name='qq']").val();
	var pass=$("input[name='pass']").val();
	var user=$("input[name='user']").val();
	if(!qq || !pass || !user){
        layer.msg('输入框内容不能为空！', function(){ });
		return false;
		}
});
/*卡密*/
$("#km").click(function(){
	var count=$("input[name='count']").val();
	var money=$("input[name='money']").val();
	if(!count || !money){
        layer.msg('输入框内容不能为空！', function(){ });
		return false;
		}
});
/*加密注释*/
$("#wd").click(function(){
	var zhushi=$("input[name='zhushi']").val();
	if(!zhushi){
		layer.msg('注释输入不能为空哟 ！', function(){ });
		return false;
	}
});
/*在线充值*/
function dopay(type){
	var value=$("input[name='value']").val();
	if(value=='' || value==0){
	layer.msg('充值金额不能为空');
	return false;
	}else if(value[0]=='.'){
		layer.msg("金额不能以点开头，请重新填写！");
		return false;
	}
	$.get("ajax.php?act=recharge&type="+type+"&value="+value, function(data) {
		if(data.code == 0){
			window.location.href='../other/submit.php?type='+type+'&orderid='+data.trade_no;
		}else{
			layer.alert(data.msg);
		}
	}, 'json');
}
$("#buy_alipay").click(function(){
	dopay('alipay')
});
$("#buy_qqpay").click(function(){
	dopay('qqpay')
});
$("#buy_wxpay").click(function(){
	dopay('wxpay')
});
$("#buy_tenpay").click(function(){
	dopay('tenpay')
});
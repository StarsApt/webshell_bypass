<?php

//---------------------------------------------------------
//财付通即时到帐支付后台回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once("./inc.php");
require (SYSTEM_ROOT."tenpay/ResponseHandler.class.php");
require (SYSTEM_ROOT."tenpay/RequestHandler.class.php");
require (SYSTEM_ROOT."tenpay/client/ClientResponseHandler.class.php");
require (SYSTEM_ROOT."tenpay/client/TenpayHttpClient.class.php");
@header('Content-Type: text/html; charset=UTF-8');

/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($conf['tenpay_key']);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//通知id
	$notify_id = $resHandler->getParameter("notify_id");
	
	//通过通知ID查询，确保通知来至财付通
	//创建查询请求
	$queryReq = new RequestHandler();
	$queryReq->init();
	$queryReq->setKey($conf['tenpay_key']);
	$queryReq->setGateUrl("https://gw.tenpay.com/gateway/verifynotifyid.xml");
	$queryReq->setParameter("partner", $conf['tenpay_pid']);
	$queryReq->setParameter("notify_id", $notify_id);
	
	//通信对象
	$httpClient = new TenpayHttpClient();
	$httpClient->setTimeOut(5);
	//设置请求内容
	$httpClient->setReqContent($queryReq->getRequestURL());
	
	//后台调用
	if($httpClient->call()) {
		//设置结果参数
		$queryRes = new ClientResponseHandler();
		$queryRes->setContent($httpClient->getResContent());
		$queryRes->setKey($conf['tenpay_key']);
		
		//判断签名及结果
		//只有签名正确,retcode为0，trade_state为0才是支付成功
		if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $queryRes->getParameter("trade_state") == "0" && $queryRes->getParameter("trade_mode") == "1" ) {
			//取结果参数做业务处理
			$out_trade_no = $queryRes->getParameter("out_trade_no");
			//财付通订单号
			$transaction_id = $queryRes->getParameter("transaction_id");
			//金额,以分为单位
			$total_fee = $queryRes->getParameter("total_fee");
			//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
			$discount = $queryRes->getParameter("discount");
		
			//------------------------------
			//处理业务开始
			//------------------------------
			$srow=$DB->get_row("SELECT * FROM mulin_pay WHERE trade_no='{$out_trade_no}' limit 1 for update");
			
			if($srow['status']==0){
				$DB->query("update `moyu_pay` set `status` ='1' where `trade_no`='{$out_trade_no}'");
				if($DB->affected()>=1){
					$DB->query("update `moyu_pay` set `endtime` ='$date' where `trade_no`='{$out_trade_no}'");
					$DB->query("update `moyu_daili` set rmb=rmb+'".$srow['money']."' where user='".$srow['user']."'");
				}
			}
			//------------------------------
			//处理业务完毕
			//------------------------------
					echo "success";
			
		} else {
			//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
			//echo "验证签名失败 或 业务错误信息:trade_state=" . $queryRes->getParameter("trade_state") . ",retcode=" . $queryRes->getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
			echo "fail";
		}
		
		//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
		/*
		echo "<br>------------------------------------------------------<br>";
		echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
		echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
		echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
		*/
	}else {
		//通信失败
		echo "fail";
		//后台调用通信失败,写日志，方便定位问题
		//echo "<br>call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>";
	} 
	
	
} else {
	//回调签名错误
	echo "fail";
	//echo "<br>签名失败<br>";
}

//获取debug信息,建议把debug信息写入日志，方便定位问题
//echo $resHandler->getDebugInfo() . "<br>";
 

?>
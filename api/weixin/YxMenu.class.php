<?php
require_once 'config.inc.php';
require_once 'HttpUtil.php';

class YxMenu {
	var $menu_data =
			'{"button":[{	
					"name":"阅读",
					"sub_button":[{
						"type":"click",
						"name":"经典美文",
						"key":"mryw"
					},{
						"type":"click",
						"name":"随机笑话",
						"key":"joke"
					},{
						"type":"click",
						"name":"鸡汤美女",
						"key":"soup"
					}]
				},{	
					"name":"小工具",
					"sub_button":[{
						"type":"click",
						"name":"城市天气",
						"key":"weather"
					},{
						"type":"click",
						"name":"有道翻译",
						"key":"youdao_trans"
					},{
						"type":"click",
						"name":"手机归属地",
						"key":"mobile"
					}]
				},{
					"name":"其他",
					"sub_button":[{
						"type":"click",
						"name":"跟我聊天",
						"key":"robot"
					},{
						"type":"click",
						"name":"关于我",
						"key":"about"
					}]
				}]}';
	public function __construct() {
		
	}

	private function getAccessToken($app_id, $app_secret) {
		$url = "https://api.yixin.im/cgi-bin/token?grant_type=client_credential&appid=" . $app_id . "&secret=" . $app_secret;
		echo $url;
		$content = file_get_contents($url);
		$info = json_decode($content);
		$access_token = $info->access_token;
		echo $access_token;
		
		return $access_token;
	}

	public function create_menu($app_id, $app_secret) {
		$access_token = $this->getAccessToken($app_id, $app_secret);
		$url = "https://api.yixin.im/cgi-bin/menu/create?access_token=" . $access_token;
		$returnValue = HttpUtil::post($url, $this->menu_data);
		var_dump($returnValue);
	}

}

header("Content-type: text/html; charset=utf-8");
$yx_menu = new YxMenu();
$yx_menu->create_menu('5a32b0ba52c94dc7ba174e7a8fd48105', 'dd8b57391bfe4aec9ae85213ec1203df');
?>

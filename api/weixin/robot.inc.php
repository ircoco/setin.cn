<?php

class Robot {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	public function getReply() {
		
		$url = 'http://www.tuling123.com/openapi/api?key=dcf3cbb80ca1904890dec45113c74ae3&userid=11032&info=' . $this->keyword;
		$reply = json_decode ( file_get_contents ( $url ), true );
		if ($reply['code'] == 100000) {
			return $reply['text']."\n\n【输入Q/q返回主界面！】";
		}
		else if ($reply['code'] == 200000) {
			return $reply['text'].$reply['url']."\n\n【输入Q/q返回主界面！】";
		}
		else if ($reply['code'] == 302000) {
			return $this->arrayInfo2wxNewList($reply['list']);
		}
		else {
			return "我不知道怎么回答您，换个主题咯！\n\n【输入Q/q返回主界面！】";
		}
	}
	private function arrayInfo2wxNewList($artileInfo) {
		$records = array();
		$cnt = 0;
		foreach ($artileInfo as $item) {
			if ($cnt > 5) {
				break;
			}
			$cnt ++;
			$records[] = array(
					'title' => $item['article'],
					'description' => $item['article'] . "\n来源于：" . $item['source'] . "\n\n输入Q/q返回上级菜单",
					'picurl' => 'http://50vip.com/yixin/random_img/' . rand(1,20) . '.jpg',
					'url'=> $item['detailurl']
			);
		}
		return $records;
	}
}

//$robot = new Robot('我想看新闻');
//echo $robot->getReply();
?>
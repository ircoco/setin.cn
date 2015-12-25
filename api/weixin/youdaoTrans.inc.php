<?php

class YouDaoTrans {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	
	public function getTransContent() {
		$url = "http://fanyi.youdao.com/openapi.do?keyfrom=redstones&key=1997757567&type=data&doctype=json&version=1.1&q=" . urlencode($this->keyword);
// 		$url = urlencode($url);
		$value = file_get_contents($url);
		$jsonValue = json_decode ( $value, true );
		//翻译成功
		if ($jsonValue['erroeCode'] == 0) {
			$content = "【$jsonValue[query]】\n";
			foreach ($jsonValue['translation'] as $item) {
				$content .= $item . "\n";
			}
			$content .= "--------\n【基本释义】\n";
			$basic = $jsonValue['basic'];
			if (count($basic) == 0 ) {
				$content .= "无基本释义\n";
			}
			else {
				if (! empty($basic[phonetic])) {
					$content .= "$basic[phonetic]\n";
				}
				foreach ($basic['explains'] as $item) {
					$content .= "$item\n";
				}
			}
			$content .= "--------\n【网络释义】\n";
			$web = $jsonValue['web'];
			if (count($web) == 0) {
				$content .= "无网络释义\n";
			}
			else {
				foreach ($web as $item) {
					$content .= "√ $item[key]\n";
					foreach ($item[value] as $s) {
						$content .= "＊ $s\n";
					}
				}
			}
			$content .= "\n【输入Q/q返回主界面！】";
			return $content;
		}
		elseif ($jsonValue['erroeCode'] == 20) {
			return "翻译的词语/单词超过文本长度限制，请重试！\n【输入Q/q返回主界面！】";
		}
		elseif ($jsonValue['erroeCode'] == 40) {
			return "不支持的您输入的语言类型，请重试！\n【输入Q/q返回主界面！】";
		}
		else {
			return "因为不明原因，有道翻译失败，换个单词试试，并且欢迎您到http://50vip.com/进行反馈！\n【输入Q/q返回主界面！】";
		}
	}
}
?>
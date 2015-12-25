<?php

class Beautiful {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	public function getBeautifulPic() {
//		$url = 'http://pomelo.sinaapp.com/picture.php?num=' . $this->keyword;
		$url = 'http://pomelo-setin.stor.sinaapp.com/'.(rand(1,4751)).'.jpg';
		$records = array();
		$records[] = array(
			'title' => "看个美女咯",
			'description' => "看个美女咯！\n更多美女到 www.setin.cn\n输入Q/q返回上级菜单",
			'picurl' => $url,
			'url'=> $url
		);
		return $records;
	}
}
?>
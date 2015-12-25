<?php

class Mryw {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	public function get() {
		$url = 'http://www.setin.cn/www/random_one.php';
		$reply = json_decode ( file_get_contents ( $url ), true );

		$records[] = array(
			'title' => $reply['m_title'],
			'description' => $reply['m_content'] . "\n输入Q/q返回上级菜单",
			'picurl' => $reply['m_pic'],
			'url'=> 'http://www.setin.cn/' . $reply['m_id'] . '.html'
		);
		return $records;
	}
}

?>
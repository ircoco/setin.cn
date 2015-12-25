<?php

class Joke {
	public $keyword = '';
	public function __construct($keyword) {
		$this->keyword = $keyword;
	}
	public function getJoke() {
		$url = 'http://joke.setin.cn/joke/random_one.php';
		$reply = json_decode ( file_get_contents ( $url ), true );

		$records[] = array(
			'title' => "来个笑话段子",
			'description' => $reply['j_content'] . "\n输入Q/q返回上级菜单",
			'picurl' => $reply['j_pic'],
			'url'=> 'http://joke.setin.cn/' . $reply['j_id'] . '.html'
		);
		return $records;
	}
}

?>
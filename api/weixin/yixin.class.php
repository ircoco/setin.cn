<?php
class YiXin {
	public $token = ''; // token
	public $debug = false; // 是否debug的状态标示，方便我们在调试的时候记录一些中间数据
	public $setFlag = false;
	public $msgtype = 'text'; // ('text','image','location'，'event')
	public $msg = array ();
	
	public function __construct($token, $debug) {
		$this->token = $token;
		$this->debug = $debug;
	}
	public function getMsg() {
		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
		if ($this->debug) {
			$this->write_log ( $postStr );
		}
		if (! empty ( $postStr )) {
			$this->msg = ( array ) simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$this->msgtype = strtolower ( $this->msg ['MsgType'] );
		}
	}
	public function makeText($text = '') {
		$CreateTime = time ();
		$FuncFlag = $this->setFlag ? 1 : 0;
		$textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
            <CreateTime>{$CreateTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
		return sprintf ( $textTpl, $text, $FuncFlag );
	}
	public function makeNews($newsData) {
		$CreateTime = time ();
		$FuncFlag = $this->setFlag ? 1 : 0;
		$newTplHeader = "<xml>
            <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
            <CreateTime>{$CreateTime}</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <ArticleCount>%s</ArticleCount><Articles>";
		$newTplItem = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
		$newTplFoot = "</Articles>
            <FuncFlag>%s</FuncFlag>
            </xml>";
		$Content = '';
		$itemsCount = count ( $newsData );
		$itemsCount = $itemsCount < 10 ? $itemsCount : 10; // 微信公众平台图文回复的消息一次最多10条
		if ($itemsCount) {
			foreach ( $newsData as $key => $item ) {
				if ($key <= 9) {
					$Content .= sprintf ( $newTplItem, $item ['title'], $item ['description'], $item ['picurl'], $item ['url'] );
				}
			}
		}
		$header = sprintf ( $newTplHeader, $newsData ['content'], $itemsCount );
		$footer = sprintf ( $newTplFoot, $FuncFlag );
		return $header . $Content . $footer;
	}
	public function makeMusic($musicData) {
		$FuncFlag = $this->setFlag ? 1 : 0;
		$CreateTime = time ();
		$result = "<xml>
						 <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
						<FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
						<CreateTime>{$CreateTime}</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<MusicUrl><![CDATA[%s]]></MusicUrl>
						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
						</Music>
					</xml>";
		
		return sprintf ( $result, $musicData['Title'], $musicData['Description'], $musicData['MusicUrl'], $musicData['HQMusicUrl'] );
//		return sprintf ( $result, 'wfwe', 'q21wdfqw', 'http://stream16.qqmusic.qq.com/3165137.mp3', 'http://stream16.qqmusic.qq.com/3165137.mp3' );
	}
	public function reply($data) {
		if ($this->debug) {
			$this->write_log ( $data );
		}
		echo $data;
	}
	public function valid() {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
	private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	private function write_log($log) {
		// TODO 写文件
        //file_put_contents('log.log', $log, LOCK_EX | FILE_APPEND);
	}
}

?>
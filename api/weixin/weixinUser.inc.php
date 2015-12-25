<?php

class WxUser extends Mysql {
	public function __construct() {
		parent::__construct();
	}
	public function queryByUserId($uid) {
		if (empty($uid) || ltrim($uid)=='') {
			$uid = '-1';
		}
		$sql = "select wx_id, wx_name, wx_state, wx_info from weixin_user where wx_id = '$uid';";
		$rows = $this->exec_query($sql);
		if ($rows && count($rows) > 0) {//返回第一个类型
			return $rows[0];
		}
		return false;
	}

	public function insertOrUpdate($wx_id, $wx_name = '', $wx_state = '0', $wx_info = '') {
		$sql = "insert into weixin_user(wx_id, wx_name, wx_state, wx_info, wx_lasttime) values ('$wx_id', '$wx_name', '$wx_state', '$wx_info', NOW()) ON DUPLICATE KEY UPDATE wx_name='$wx_name', wx_state = '$wx_state', wx_info = '$wx_info', wx_lasttime = NOW();";
		return $this->exec_update($sql);
	}
}
?>
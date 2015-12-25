<?php
/**
 * 记录用户状态
 * @author http://50vip.com/
 *        
 */
class UserState {
	public static function getUserState($userId) {
		$wxUser = new WxUser();
		$wxUserRow = $wxUser->queryByUserId($userId);
		if ($wxUserRow == null) {
			return array ("state" => '0', "info" => '');
		}
		return array ("state" => $wxUserRow['wx_state'], "info" => '');
	}
	public static function setUserState($userId, $state, $info) {
		$wxUser = new WxUser();
		$wxUser->insertOrUpdate($userId, '', $state, $info);
	}
}
?>
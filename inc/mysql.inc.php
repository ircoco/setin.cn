<?php

/**
 * 数据库连接，关闭类
 * @author Xewee.Zhiwei.Wang
 */
class Mysql {

	public static $CONN = null;

	/**
	 * 初始化构造函数，连接数据库
	 * 2012-5-2 上午10:13:52
	 * Xewee.Zhiwei.Wang
	 */
	public function __construct() {
		try {
			if (empty(Mysql::$CONN)) {
				Mysql::$CONN = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
				mysql_select_db(SAE_MYSQL_DB, Mysql::$CONN);
				mysql_query('set names utf8');
			}
		} catch (Exception $e) {
			$msg = $e;
			include (ERROR_PAGE);
		}
	}

	public function exec_update($sql = "") {
		//sql为空，返回false
		if (empty($sql)) {
			return false;
		}
		//其他情况采用数据库查询
		//连接为空，返回false
		if (empty(Mysql::$CONN)) {
			return false;
		}
		try {
			$result = mysql_query($sql, Mysql::$CONN);
		} catch (Exception $e) {
			$msg = $e;
			include (ERROR_PAGE);
		}
		return $result;
	}

	/**
	 * 查询
	 * 2012-5-2 上午10:21:10
	 * Xewee.Zhiwei.Wang
	 * @return false 或者二维数组
	 */
	public function exec_query($sql = "") {
		//sql为空，返回false
		if (empty($sql)) {
			return false;
		}
		if (empty(Mysql::$CONN)) {
			return false;
		}
		try {
			$result = mysql_query($sql, Mysql::$CONN);
		} catch (Exception $e) {
			$msg = $e;
		}
		//查询结果为空
		if ((!$result) or ( empty($result))) {
			mysql_free_result($result);
			return false;
		}
		$data = array();
		$count = 0;
		//将查询数据放到数组中
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$data[$count] = $row;
			$count ++;
		}
		mysql_free_result($result);
		return $data;
	}

	/**
	 * 定义事务
	 * 2012-5-2 上午10:20:18
	 * Xewee.Zhiwei.Wang
	 */
	public function beginTrans() {
		mysql_query("set autocommit=0");
		mysql_query("begin");
	}

	/**
	 * 回滚
	 * 2012-5-2 上午10:20:28
	 * Xewee.Zhiwei.Wang
	 */
	public function rollBack() {
		mysql_query("rollback");
	}

	/**
	 * 提交
	 * 2012-5-2 上午10:20:31
	 * Xewee.Zhiwei.Wang
	 */
	public function commit() {
		mysql_query("commit");
	}

	public function close() {
		if (!empty(Mysql::$CONN)) {
			mysql_close(Mysql::$CONN);
			Mysql::$CONN = null;
		}
	}

	public static function closeConn() {
		if (!empty(Mysql::$CONN)) {
			mysql_close(Mysql::$CONN);
			Mysql::$CONN = null;
		}
	}
}

?>
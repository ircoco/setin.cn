<?php

require_once 'mysql.inc.php';

class Mryw extends Mysql {

	public function __construct() {
		parent::__construct();
	}

	public function is_mryw_exist($m_md5) {
		$sql = "select m_md5 from mryw where m_md5 = '$m_md5';";
		$rows = $this->exec_query($sql);
		if (count($rows) > 0) {
			return true;
		}
		return false;
	}

	public function insert_mryw($m_title, $m_content, $m_author, $m_md5, $m_time) {
//	if (empty($m_time)) {
//	    $sql = "insert into mryw(m_title, m_content, m_author, m_md5, m_time) values ('$m_title', '$m_content', '$m_author', '$m_md5', NOW())";
//	} else {
		$sql = "insert into mryw(m_title, m_content, m_author, m_md5, m_time) values ('$m_title', '$m_content', '$m_author', '$m_md5', '$m_time')";
//	}
		$this->exec_update($sql);
		return true;
	}

	public function find_by_id($m_id) {
		$sql = "select * from mryw where m_id = $m_id;";
		$rst = $this->exec_query($sql);
		if ($rst == null || empty($rst) || count($rst) == 0) {
			return false;
		}
		return $rst[0];
	}

	public function get_lastest_article($all = false) {
		if ($all) {
			$sql = "select * from mryw order by m_time desc limit 1";
		} else {
			$sql = "select * from mryw where m_time < NOW() order by m_time desc limit 1";
		}

		$rst = $this->exec_query($sql);
		if ($rst == null || empty($rst) || count($rst) == 0) {
			return false;
		}
		return $rst[0];
	}

	public function search_next_article_id($id) {
		$sql = "select m_id,m_time from mryw where m_id > $id and m_time < NOW() order by m_id asc limit 1";
		return $this->exec_query($sql);
	}

	public function search_prev_article_id($id) {
		$sql = "select m_id,m_time from mryw where m_id < $id and m_time < NOW() order by m_id desc limit 1";
		return $this->exec_query($sql);
	}

	public function count_all() {
		$sql = "select count(m_id) as cnt from mryw;";
		$rst = $this->exec_query($sql);

		if ($rst == null || empty($rst) || count($rst) == 0) {
			return false;
		}
		return $rst[0]['cnt'];
	}

	public function count_all_Online() {
		$sql = "select count(m_id) as cnt from mryw where m_time < NOW();";
		$rst = $this->exec_query($sql);

		if ($rst == null || empty($rst) || count($rst) == 0) {
			return false;
		}
		return $rst[0]['cnt'];
	}

	public function update_m_time($m_id, $m_time) {
		$sql = "update mryw set m_time = '$m_time' where m_id = $m_id;";
		return $this->exec_update($sql);
	}

	public function select_4_sitemap() {
		$sql = "select m_id, m_time from mryw where m_time < NOW() order by m_time desc;";
		return $this->exec_query($sql);
	}
	
	public function random_one($i) {
		$sql = "select * from mryw limit $i, 1;";
		$rst = $this->exec_query($sql);

		if ($rst == null || empty($rst) || count($rst) == 0) {
			return false;
		}
		return $rst[0];
	}
}

?>
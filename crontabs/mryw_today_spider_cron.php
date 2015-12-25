<?php

require_once '../inc/QueryList/QueryList.class.php';
header('Content-type:text/html;charset=utf-8');

$url = "http://meiriyiwen.com/";
$reg = array(
	"title"=>array("#article_show h1","text"),
	"author"=>array("#article_show .article_author span","text"),
	"content"=>array("#article_show .article_text","html")
);

$mryw_rst = QueryList::Query($url, $reg);
$mryw_array = $mryw_rst->jsonArr;
if ($mryw_array) {
	$m_title = $mryw_array[0]['title'];
	$m_author = $mryw_array[0]['author'];
	$m_content = $mryw_array[0]['content'];
	$m_md5 = md5($m_content);
	if (empty($m_title) || empty($m_author) || empty($m_content) || empty($m_md5)) {
		echo 'empty mryw, ' . date('Y-m-d H:i:s',time());
	}
	else {
		require_once '../inc/mryw.inc.php';
		$mryw_dao = new Mryw();
		if ($mryw_dao->is_mryw_exist($m_md5)) {
			echo 'exist mryw, ' . date('Y-m-d H:i:s',time());
		}
		else {
			$lastest = $mryw_dao->get_lastest_article(true);
			$n_time = strtotime($lastest['m_time']) + 3600 * 23 + 57;
			$mryw_dao->insert_mryw($m_title, $m_content, $m_author, $m_md5, date('Y-m-d H:i:s', $n_time));//
			echo 'success mryw, ' . date('Y-m-d H:i:s',time());
			Mysql::closeConn();
		}
	}
}
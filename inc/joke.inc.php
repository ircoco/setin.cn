<?php

require_once 'mysql.inc.php';

class Joke extends Mysql {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询，分页
     */
    public function query_page($page_size, $page_index, $tag) {
        $start = $page_size * ($page_index - 1);
        if ($start < 0) {
            $start = 0;
        }
        if (empty($tag)) {
            $sql = "select j_id, j_content, j_tag, j_time from abc where j_time < NOW() ORDER BY j_time DESC limit $start, $page_size";
        } else {
            $sql = "select j_id, j_content, j_tag, j_time from abc where j_time < NOW() and j_content like '%" . $tag . "%' ORDER BY j_time DESC limit $start, $page_size";
        }
//		echo $sql;
        $rows = $this->exec_query($sql);
        return $rows;
    }

    /**
     * 查询，按id查询
     */
    public function find_by_id($id) {
        $sql = "SELECT j_id, j_content, j_tag, j_time FROM abc WHERE j_id  = $id";
        $rows = $this->exec_query($sql);
        if ($rows && count($rows) > 0) {
            return $rows[0];
        }
        return null;
    }

    public function searchNextArticleID($id) {
        $sql = "select j_id from abc where j_id>$id and j_time < NOW() order by j_id asc limit 1";
        return $this->exec_query($sql);
    }

    public function searchPreArticleID($id) {
        $sql = "select j_id from abc where j_id<$id and j_time < NOW() order by j_id desc limit 1";
        return $this->exec_query($sql);
    }

    public function select_4_sitemap() {
        $sql = "select j_id, j_time from abc where j_time < NOW() order by j_time desc limit 0,1000;";
        return $this->exec_query($sql);
    }

    /**
     * 查询所有上线的
     */
    public function count_online($tag) {
        if (empty($tag)) {
            $sql = "select count(j_time) as cnt from abc where j_time < NOW();";
        } else {
            $sql = "select count(*) as cnt from abc where j_time < NOW() and j_content like '%" . $tag . "%';";
        }

        $rows = $this->exec_query($sql);
        return $rows[0]['cnt'];
    }

    /**
     * 查询所有
     */
    public function count_all() {
        $sql = "select count(j_id) as cnt from abc;";
        $rows = $this->exec_query($sql);
        return $rows[0]['cnt'];
    }

    public function update_j_time($j_id, $j_time) {
        $sql = "update abc set j_time = '$j_time' where j_id = $j_id;";
        $rows = $this->exec_update($sql);
        return true;
    }

    public function update_j_tag($j_id, $j_tag) {
        $sql = "update abc set j_tag = '$j_tag' where j_id = $j_id;";
        $rows = $this->exec_update($sql);
        return true;
    }

}

?>
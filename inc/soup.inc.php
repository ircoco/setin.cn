<?php

require_once 'mysql.inc.php';
define('pagesize', 10);

/**
 * 仅供参考
 */
class SoupDao extends Mysql {

    public function __construct() {
        parent::__construct();
    }

    public function searchNextArticleID($id) {
        $sql = "select id from soup where id>$id order by id asc limit 1";
        return $this->exec_query($sql);
    }
    public function searchPreArticleID($id) {
        $sql = "Select id from soup where id<$id order by id desc limit 1";
        return $this->exec_query($sql);
    }
    public function findAllTitle() {
        $sql = "select id,category, title from dream order by category";
        return $this->exec_query($sql);
    }
    public function findAllContentNotTitle() {
        $sql = "select id,content from soup where title ='心灵鸡汤'";
        return $this->exec_query($sql);
    }
    public function findById($id) {
        $sql = "SELECT * FROM soup WHERE id  = $id";
        $rows =$this->exec_query($sql);
         if ($rows && count($rows) > 0) {
            return $rows[0];
        }
        return null;
    }
    public function updatetitle($title,$id) {
        $sql = "update soup set title ='$title' WHERE id  = $id";
        echo $sql;
        return $this->exec_update($sql);
    }
      public function updatetag($tag,$id) {
        $sql = "update soup set tag ='$tag' WHERE id  = $id";
        echo $sql;
        return $this->exec_update($sql);
    }
    
    
    public function count($tag) {
         if (empty($tag)) {
         $sql = "SELECT count(*) as num FROM soup;";
         }else{
         $sql = "select count(*) as num from soup where  content like '%" . $tag . "%';";    
         }
      
        $rows = $this->exec_query($sql);
        return $rows[0]['num'];
    }
	
    public function findByPage($page,$tag) {
         if (empty($tag)) {
            $sql = "select * from  soup order by posttime desc limit " . (($page-1) * pagesize) . "," . pagesize;
        } else {
            $sql = "select * from  soup where content like '%" . $tag . "%'  order by posttime desc limit " . (($page-1) * pagesize) . "," . pagesize;
        }
       
        return $this->exec_query($sql);
    }

    public function getRandom($n) {
        $ids = array();
        for ($i = 0; $i < $n; $i++) {
            $ids[] = mt_rand(1, 13000);
        }
        $ids = array_unique($ids);
        $id_str = '';
        foreach ($ids as $value) {
            $id_str = $id_str . $value . ',';
        }
        $id_str = substr($id_str, 0, -1);
        $sql = "select id, ChengYu,PingYin from chengyu where id in($id_str);";
        return $this->exec_query($sql);
    }

}
//
//$soupdao = new SoupDao;
//$soup=$soupdao->count();
//echo $soup[0]['num'];
//$soup=$soupdao->searchPreArticleID(7);
//echo $soup[0]['id'];
//echo $soup[0]['title'];
        
//$soup = $soupdao->findByPage(2);
//$soup_len = count($soup);
//for ($i = 0; $i < $soup_len; $i ++) {
//    $date = $soup[$i]['posttime'];
//    $aa=strtotime($date);
//    $day = date("d", $aa);
//    $month = date("n", $aa);
//    echo $month . "</br>";
//    echo $day . "</br>";
//}
?>
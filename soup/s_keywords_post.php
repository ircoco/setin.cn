<!DOCTYPE html>
<?php
define('PAGE_SIZE', 10);
require_once('../inc/mysql.inc.php');
require_once('../inc/soup.inc.php');
$id = $_GET['id'];
$tag = $_POST['tag'];
$SoupDao = new SoupDao;
if (empty($tag)) {
	$content = $SoupDao->findById($id);
	echo $content['content'];
}
else {
	$SoupDao->updatetag($tag,$id);
}


Mysql::close();
?>
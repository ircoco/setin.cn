<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$j_id = $_GET['j_id'];
$j_tag = $_POST['j_tag'];

//传入参数j_id和j_tag，如果j_tag为空，则返回content的值，否则更新tag到数据库中。

require_once 'joke.inc.php';

$joke = new Joke();
if (empty($j_tag)) {
	$content = $joke->find_by_id($j_id);
	echo $content['j_content'];
}
else {
	$joke->update_j_tag($j_id, $j_tag);
}


echo 'test';

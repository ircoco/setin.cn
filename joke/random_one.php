<?php
require_once('../inc/mysql.inc.php');
require_once('../inc/joke.inc.php');

$joke_dao = new Joke;
$joke_cnt = $joke_dao->count_all();

$num = rand(1, $joke_cnt);
$joke = $joke_dao->find_by_id($num);
$joke['j_pic'] =  'http://pomelo-setin.stor.sinaapp.com/'.(rand(1,4751)).'.jpg';
echo json_encode($joke);

Mysql::close();
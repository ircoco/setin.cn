<?php
require_once('../inc/mryw.inc.php');
require_once('../inc/utils.inc.php');

$mryw = new Mryw();
$cnt = $mryw->count_all();
$num = rand(0, $cnt * 2) % $cnt;
$data = $mryw->random_one($num);
$descrip = substr_ext(strip_tags($data['m_content']), 0, 80);
$descrip = preg_replace("/\s/", "", $descrip);
$data['m_content'] = $descrip . '...';
$data['m_pic'] = 'http://pomelo-setin.stor.sinaapp.com/'.(rand(1,4751)).'.jpg';

echo json_encode($data);
Mysql::close();

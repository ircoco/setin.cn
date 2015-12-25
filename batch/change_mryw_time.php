<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../inc/mryw.inc.php';
$mryw_dao = new Mryw();
$start = '2014-11-11 11:11:11';
for ($i = 1; $i < 900; $i ++) {
    //$mryw = $mryw_dao->find_by_id($i);
    $n_time = strtotime($start) + 3600 * 5 + 57;
    $start = date('Y-m-d H:i:s', $n_time);
    $mryw_dao->update_m_time($i, $start);
}
echo 'su';

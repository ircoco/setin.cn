<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$j_id = $_POST['j_id'];
$j_time = $_POST['j_time'];

require_once 'joke.inc.php';

$joke = new Joke();
$joke->update_j_time($j_id, $j_time);

echo 'test';

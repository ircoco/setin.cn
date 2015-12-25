<?php
if (!empty($_GET['num'])) {
    if(is_numeric($_GET['num']))
	$num = $_GET['num'];
    else
    {
       
        $num = rand(1,4751);
    }
}
 else {
    $num = 1;
}
$url = 'http://pomelo-setin.stor.sinaapp.com/'.($num%4752).'.jpg';
echo $url;

?>

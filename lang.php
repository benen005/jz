<?php 
require_once('jz_inc.php');
$f = date('Ymd');
$date = $_GET['date'];
if($date)
	$f = 'txt_' . $date . '.txt';
else
	$f = 'txt_' . $f . '.txt';
$file = 'txt/'.$f;

$r = lang_2_1($file);
//print_r($r);




$arr1 = $r[0][$r[3][1]];
$arr2 = $r[1][$r[3][2]];
$dan = $r[3][0];
if($dan == 0){
	$arr1[3] = 1;
	$arr2[3] = 0;
}
else{
	$arr1[3] = 0;
	$arr2[3] = 1;
}
$arr4 = array($arr1, $arr2);
print_r($arr4);

?>
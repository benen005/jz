<?php 
$t1 = microtime(true);

require_once 'inc.php';

timer::init();
logger::init();


//输出数据
//$date = $_POST['date'];
$type = $_POST['type'];
$date = date('Ymd');
$f = date('Ymd');
$ex = "";
if($type == 3)
    $ex = "b_";
elseif($type == 4 || $type == 5)
    $ex = "14_";
$f = 'txt_' . $ex . $date . '_recommend_' . $type . '.txt';


$file = 'txt/' . $f;

$c = $_POST['content'];
$c = str_replace("\\", "", $c);

if($c){
    $t = date('Y-m-d H:i:s');
    //$c = str_replace("\r\n", "", $c);
    logger::jl($file, $c);
    echo "{type:1, time: '$t'}";
}
else
    echo "{type:0}";
?>
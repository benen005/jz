<?php 
$t1 = microtime(true);

require_once 'inc.php';

timer::init();
logger::init();


//输出数据
$date = $_POST['date'];
$f = date('Ymd');
$f = 'txt_' . $date . '.txt';


$file = 'txt/' . $f;

$c = $_POST['content'];

if($c){
    $t = date('Y-m-d H:i:s');
    //$c = str_replace("\r\n", "", $c);
    logger::jl($file, $c);
    echo "{type:1, time: '$t'}";
}
else
    echo "{type:0}";
?>
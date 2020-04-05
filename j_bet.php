<?php 
$t1 = microtime(true);

require_once 'inc.php';

timer::init();
logger::init();



$file = 'bet.txt';

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="竞彩足球预测" />
<meta name="description" content="竞彩足球预测" />
<title>竞彩足球预测 - 首页</title>
<link rel="stylesheet" href="style/css.css" type="text/css" media="all" />
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/js.js" type="text/javascript"></script>
</head>
<body>
<?php include_once('head.php'); ?>

<div class="page">
<?php 
session_start();
require_once('jz_inc.php');
$f = date('Ymd');
$date = $_GET['date'];
if($date)
	$f = 'txt_' . $date . '.txt';
else
	$f = 'txt_' . $f . '.txt';
$file = 'txt/'.$f;
?>
<div id="main">
    <h1>竞彩足球2串1预测</h1>
	<hr />
	<?php require_once('date.php'); ?>
<div id="text2"><img src="images/1.png" /></div>
<?php if(file_exists($file)){ ?>
	<div id="text1">
		<div id="text8"><span>
<?php
$arr = read($file);
$table = read_arr_match($file);
//print_r($table);
$p = read($file);  //读取数据
//print_r($p);


$money = 100;        
$double_string = array();  //双选
$single_string = array();  //单选
$r = null;

if(isset($_SESSION['view1']) && $flag){
	$r = $_SESSION['view1'];
}
else{
	$p = arr_maopao($p);
	//print_r($p);
	$r = generate_2_1($p);
	$_SESSION['view1'] = $r;
	//session_destroy();
}
//print_r($r);
$dan = $r[3][0];  //胆
$c1 = $r[2][0];   //第一队索引
$c2 = $r[2][1];   //第二队索引
$d = $dan + 1;

?>
<?php if($date){ ?>
	<p class="p1"><?php echo $date . "竞赛足彩预测<br />"; ?></p> 
<?php }else{ ?>
	<p class="p1"><?php echo date('Y-m-d') . "竞赛足彩预测<br />"; ?></p> 
<?php } ?>

<?php


$r = draw_2_1($file);
//print_r($r);


echo "<p class='p2'>为你选择的场次:</p><div id='div_recommend'>";

for($i=0;$i<count($r);$i++){
    $single_string = array($r[$i][1]);
    //echo $single_string[0];
    echo "<p class='p2'>" . render_red($table[$i], $single_string[0]) . "</p>";

}

echo "</div>";




?>
        </span></div>
	</div>

	
	
<?php }else{ ?>
<div id='text3'><span>未及时更新，等待版主更新  <a href="/photo/">先看看美女吧</a></span></div>
<?php } ?>
<?php require_once('advise.php'); ?>
	<div class="text">
<?php require_once 'ssq_head.php'; ?>
<?php
require_once 'm_inc.php';
$act = $_GET['act'];
$title = $_POST['title'];
$file = 'write.txt';
if($act == 1){
	$user_IP = get_userip();
	echo $user_IP;
    if($title){
        if($title == 'clear'){
            $c = jl($file, '');
            echo 'clear';
        }
        else{
            $c = add($file, "[".$user_IP."]".$title);
            echo 'ok';
        }
    }
    else 
        echo 'null';
}
elseif($act == 2){
	
	$bet_content = $_POST['bet_content'];
	$user_IP = get_userip();
	echo $user_IP;
    if($bet_content){
        if($bet_content == 'clear'){
            $c = jl($file2, '');
            echo 'clear';
        }
        else{
            $c = add($file2, $bet_content);
            echo 'ok';
        }
    }
    else 
        echo 'null';
}
?>
		<form action="?act=1" method="post" >
			<textarea name="title" cols=40 ></textarea> <input type="submit" value="评论"   />
		</form>
		
<?php 
$f = file_get_contents($file);
$f = comment_filt($f);

foreach($f as $k => $v){
    echo $v."<br />";
}
?>
	</div>
	
</div>

</div>


<div id="block_footer">
	<div class="foot"><span>Copyright © 2015-2015 design by J</span></div>
</div>

</body></html>
<?php include_once('foot.php'); ?>
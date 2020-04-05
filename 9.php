<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="竞彩足球预测" />
<meta name="description" content="竞彩足球预测" />
<title>竞彩足球预测 - 14场</title>
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
	$f = 'txt_14_' . $date . '.txt';
else
	$f = 'txt_14_' . $f . '.txt';
$file = 'txt/'.$f;
?>
<div id="main">
    <h1>任9场预测</h1>
	<hr /><?php require_once('date.php'); ?>
	<div id="text2"><img src="images/1.png" /></div>
<?php if(file_exists($file)){ ?>
	<div id="text1">
		<div id="text3"><span>
<?php 
$table = read_14_2($file);

$p = read_14($file);  //读取数据
//print_r($p);exit;


$money =64;        
$double_string = array();  //双选
$single_string = array();  //单选
$r = null;

if(isset($_SESSION['view5']) && $flag){
	$r = $_SESSION['view5'];
}
else{
	$p = arr_maopao($p);
    //print_r($p);exit;
	$r = generate_9_n($p, 9);
	$_SESSION['view5'] = $r;
	//session_destroy();
}
//print_r($r);exit;

$table4 = array();
for($i=0;$i<count($table);$i++){
	for($j=0;$j<count($r[15]);$j++){
		if($i == $r[15][$j])
			$table4[$i] = $table[$i];
	}
}

$dan = $r[16];  //胆


?>
<?php if($date){ ?>
	<p class="p1"><?php echo $date . "竞赛足彩预测<br />"; ?></p>
<?php }else{ ?>
	<p class="p1"><?php echo date('Y-m-d') . "竞赛足彩预测<br />"; ?></p> <div class="recommend_btn"><input name="secret" id="btn_secret" size="2" /><input type="button" value="推荐" name="btn_recommend" id="btn_recommend" /><input type="hidden" id="recommend_type" value="5" /></div>
<?php } ?>

<?php

	

//$s1 = sfp($table[$c1], $table[$c2], $double_string[0]);
//$s2 = sfp($table[$c1], $table[$c2], $double_string[1]);
//$s3 = sfp($table[$c1], $table[$c2], $single_string[0]);

echo "<p class='p2'>为你选择的场次:</p>";
	

echo "<p>预测选项为: <br /><div id='div_recommend'>";

//$table2 = array();
//print_r($table4);
//for($i=0;$i<count($table4);$i++)

$sfp = array();

foreach($table4 as $k => $v){
	$table2[$k] = render_red($v, $p[$k][0]) . " ". sfp_310($table[$k], $p[$k][0]);  //第一轮渲染
	//echo $table[$i]."</br>";
	$sfp[$k] = sfp_310($table[$k], $p[$k][0]);
}

$t = array();

for($i=0;$i<count($dan);$i++){
	$rand = rand(1,2);
	$t[$dan[$i]] = $p[$dan[$i]][$rand];
}
//print_r($t);exit;

$table3 = array();

foreach($table2 as $k => $v){
	if($t[$k]){
		$table3[] = "<p class='p2'>" . render_red($table2[$k], $t[$k]) . sfp_310($table[$k], $t[$k]) . "</p>";  //第二轮渲染
		$sfp[$k] = $sfp[$k] . sfp_310($table[$k], $t[$k]);
	}
	else
		$table3[] = "<p class='p2'>" . render_red($table2[$k], $t[$k]) . "</p>"; 
}

for($i=0;$i<count($table3);$i++){
		echo $table3[$i];
}
			
//$r = rate_2_1($r);

$s = null;

for($i=0;$i<14;$i++){
	if($sfp[$i])
		$s = $s . $sfp[$i] . " ";
	else
		$s = $s . "<font color=red>*</font> ";
}

//foreach($sfp as $k => $v){
//	$kk = $k + 1;
//	$s = $s . " [$kk]" . $v;
//}

echo "<p class='p2'>" . $s . "</p>"; 

//$r = compute($r, $money);
echo "<p>你需要投入了 $money 元<br/></p></div>";





?>
        </span></div>
	</div>
	<div class="text">
		<span>今日必红推荐</span><?php echo $web; ?>
		<div class="content">
				<?php get_recommend($file, 5); ?>
		</div>
	</div>
	<div id="text4">
		<div class="text5">
			<?php
				for($i=0;$i<count($table);$i++)
				echo $table[$i]."</br>";
			?>
		</div> 
		<div class="text6">GOOD LUCK FOR YOU
		</div>
		
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
	$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
	$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
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
?>
		<form action="?act=1" method="post" >
			<textarea name="title" cols=40 ></textarea> <input type="submit" value="评论"   />
		</form>
		
<?php 
$f = file_get_contents($file);
//$f = preg_match_all('/http:\/\/[^\s]*\.((jpg)|(JPG)|(gif)|(GIF)|(png)|(PNG))/', $f, $r);
$f = str_replace("http://", "<img src=\"http://", $f);
$f = str_replace("jpg", "jpg\" />", $f);
$f = str_replace("JPG", "JPG\" />", $f);
$f = str_replace("png", "png\" />", $f);
$f = str_replace("PNG", "PNG\" />", $f);
$f = str_replace("gif", "gif\" />", $f);
$f = str_replace("GIF", "GIF\" />", $f);
$f = str_replace("(", "<font color='#ccc'>", $f);
$f = str_replace(")", "</font>", $f);
$f = explode("<br />", $f);
$f = array_reverse($f);

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
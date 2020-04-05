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
<div id="text2">
	<img src="images/1.png" />
	<a href="#" id="show_settings" class="show_settings">请帮我点击以下广告，显示推荐二串一</a>
	<div id="ql_ad" style="border:5px solid red; cursor:pointer; width:200px; height:200px;">
		let's go
	</div>
</div>
<?php if(file_exists($file)){ ?>
	<div id="text1">
		<div id="text3" style="display:none;"><span>
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
	<p class="p1"><?php echo date('Y-m-d') . "竞赛足彩预测<br />"; ?></p> <div class="recommend_btn"><input name="secret" id="btn_secret" size="2" /><input type="button" value="推荐" name="btn_recommend" id="btn_recommend" /><input type="hidden" id="recommend_type" value="1" /></div>
<?php } ?>

<?php


$r = lang_2_1($file);
//print_r($r);




$arr1 = $r[0][$r[3][1]];
$arr1[3] = $r[3][1];
$arr2 = $r[1][$r[3][2]];
$arr2[3] = $r[3][2];
$dan = $r[3][0];

$c1 = $r[2][0];   //第一队索引
$c2 = $r[2][1];   //第二队索引

$arr4 = array($arr1, $arr2, $dan);;

$dan = $r[2][$r[3][0]];

$single_string = array($arr4[$arr4[2]][0]);
$double_string = array($arr4[1-$arr4[2]][0], $arr4[1-$arr4[2]][1], $arr4[1-$arr4[2]][2]);


$rand = rand(1,2);
//$rand = 2;
//print_r($table);
$s1 = sfp($table[$c1], $table[$c2], $double_string[0]);
$s2 = sfp($table[$c1], $table[$c2], $double_string[$rand]);
$s3 = sfp($table[$c1], $table[$c2], $single_string[0]);
$s1=$s2=$s3="";

echo "<p class='p2'>为你选择的场次:</p><div id='div_recommend'>";

if($dan == $c1){  //若第一队为胆
	echo "<p class='p2'>" . render_red($table[$c1], $single_string[0]) . "</p>";
	echo "<p class='p2'>" . render_red2($table[$c2], $double_string[0], $double_string[$rand]) . "</p>";	
}
else{           //若第二队为胆
	echo "<p class='p2'>" . render_red2($table[$c1], $double_string[0], $double_string[$rand]) . "</p>";
	echo "<p class='p2'>" . render_red($table[$c2], $single_string[0]) . "</p>";	
}

echo "<p>预测选项为: [".$double_string[0].$s1.",".$double_string[$rand].$s2."] " . "*" .  " [".$single_string[0].$s3 ."] " . " <br/></p>";
$r = rate_arr_2_1($r, $rand);

$r = compute($r, $money);
echo "<p>若你投入了 $money 元, 预计中奖奖金为 $r[0] - $r[1]元<br/></p></div>";

$kj = kj(count($table), 0.7);
if(is_zj($kj, $dan)){
        echo "<p>预测中奖概率为70%, 想要稳稳的幸福</p>";
}
else{
        echo "<p>不中奖概率为30%<br/><br /></p>";
}


?>
        </span></div>
	</div>
	<div class="text" id="text_h" style="display:none;">
		<span>今日必红推荐</span><?php echo $web; ?>
		<div class="content">
				<?php get_recommend($file); ?>
		</div>
	</div>
	<div class="text">
		<span>倍投测试</span>
		<div class="content">
			针对以上每日必红推荐，以倍投方式进行投注，测试一个月盈利能力
			<form action="?act=2" method="post" >
				<textarea name="bet_content" cols=40 ></textarea> <input type="submit" value="评论"   />
			</form>
			
<?php 
$file2 = "bet.txt";
$f = file_get_contents($file2);
$f = comment_filt($f);

foreach($f as $k => $v){
    echo $v."<br />";
}
?>

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
<?php include_once('sogou_ad.php'); ?>
</body></html>
<?php include_once('foot.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="竞彩篮球预测" />
<meta name="description" content="竞彩篮球预测" />
<title>竞彩篮球预测 2串1</title>
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
	$f = 'txt_b_' . $date . '.txt';
else
	$f = 'txt_b_' . $f . '.txt';
$file = 'txt/'.$f;
?>
<div id="main">
    <h1>竞彩篮球2串1预测</h1>
	<hr /><?php require_once('date.php'); ?>
	<div id="text2"><img src="images/1.png" /></div>
<?php if(file_exists($file)){ ?>
	<div id="text1">
		<div id="text3"><span>
<?php 
$table = read_b($file);
//print_r($table);
$p = read_basketball($file);  //读取数据
//print_r($p);


$money = 100;        
$double_string = array();  //双选
$single_string = array();  //单选
$r = null;

if(isset($_SESSION['view3']) && $flag){
	$r = $_SESSION['view3'];
}
else{
	$p = arr_maopao_2($p);
	//print_r($p);
	$r = generate_2_1($p);
	$_SESSION['view3'] = $r;
	//session_destroy();
}
//print_r($r);
$dan = $r[3][0];  //胆
$c1 = $r[2][0];   //第一队索引
$c2 = $r[2][1];   //第二队索引
$d = $dan + 1;

?>
<?php if($date){ ?>
	<p class="p1"><?php echo $date . "竞赛篮彩预测<br />"; ?></p>
<?php }else{ ?> 
	<p class="p1"><?php echo date('Y-m-d') . "竞赛篮彩预测<br />"; ?></p> <div class="recommend_btn"><input name="secret" id="btn_secret" size="2" /><input type="button" value="推荐" name="btn_recommend" id="btn_recommend" /><input type="hidden" id="recommend_type" value="3" /></div>
<?php } ?>

<?php



	$single_string = array($r[0][0]);
	$double_string = array($r[1][0], $r[1][1]);


	

//$s1 = sfp($table[$c1], $table[$c2], $double_string[0]);
//$s2 = sfp($table[$c1], $table[$c2], $double_string[1]);
//$s3 = sfp($table[$c1], $table[$c2], $single_string[0]);

echo "<p class='p2'>为你选择的场次:</p><div id='div_recommend'>";


	echo "<p class='p2'>" . render_red($table[$c1], $single_string[0]) . "</p>";
	echo "<p class='p2'>" . render_red($table[$c2], $double_string[0]) . "</p>";	



echo "<p>预测选项为: [".$double_string[0]."] " . "*" .  " [".$single_string[0].$s3 ."] " . " <br/></p>";
$r = rate_2_1_b($r);

//print_r($r);

$r = compute_b($r, $money);
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
	<div class="text">
		<span>今日必红推荐</span><?php echo $web; ?>
		<div class="content">
				<?php get_recommend($file, 3); ?>
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
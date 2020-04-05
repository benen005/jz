<?php include_once('action.php'); ?>
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
//session_start();
require_once('jz_inc.php');

$type = $_GET['type'];
if (isMobile() && !$type)  
    header("location:phone.php");;  
	
$f = date('Ymd');
$date = $_GET['date'];
if($date)
	$f = 'txt_' . $date . '.txt';
else
	$f = 'txt_' . $f . '.txt';
$file = 'txt/'.$f;
?>
<div id="main">
    <h1>竞彩足球2串1预测 <font color="red" size="4">QQ群：478709617</font></h1>
	<hr />
	<?php require_once('date.php'); ?>
<div id="text2">
	<img src="images/1.png" />
	<!--<a href="#" id="show_settings" class="show_settings">请帮我点击以下广告，显示推荐二串一</a>-->
	<div id="ql_ad" style="border:5px solid red; cursor:pointer; width:200px; height:200px;display:none;">
		<!--<script src="http://e.e708.net/cpc/index.php?76135_2_15_0|1|2_d70000__" charset="gb2312"></script>-->
	</div>
</div>
<?php if(file_exists($file)){ ?>
	<div id="text1">
		<div id="text3" style="display:none;"><span>
<?php
$arr = read($file);
$table = read_match($file);
//print_r($table);
$p = read($file);  //读取数据
//print_r($p);


$money = 100;        
$double_string = array();  //双选
$single_string = array();  //单选
$r = null;

//if(isset($_SESSION['view1']) && $flag){
//	$r = $_SESSION['view1'];
//}
//else{
	$p = arr_maopao($p);
	//print_r($p);
	$r = generate_2_1($p);
	//$_SESSION['view1'] = $r;
	//session_destroy();
//}
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


if($dan == $c1){  //若第一队为胆
	$single_string = array($r[0][0]);
	$double_string = array($r[1][0], $r[1][1], $r[1][2]);
}
else{             //若第二队为胆
	$single_string = array($r[1][0]);
	$double_string = array($r[0][0], $r[0][1], $r[0][2]);
}
	
$rand = rand(1,2);
//$rand = 2;
$s1 = sfp($table[$c1], $table[$c2], $double_string[0]);
$s2 = sfp($table[$c1], $table[$c2], $double_string[$rand]);
$s3 = sfp($table[$c1], $table[$c2], $single_string[0]);

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
$r = rate_2_1($r, $rand);

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
        </span>
				<div style="margin-left:150px;">
				<!-- 一键分享 -->
				<div class="right_fx">
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_huaban" data-cmd="huaban" title="分享到花瓣"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["weixin","tsina","douban","huaban","tqq","renren","sqq","qzone"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","douban","huaban","tqq","renren","sqq","qzone"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
				</div>
				<!-- 一键分享 end -->
				</div>
		</div>

	</div>
	<div class="text" id="text_h" >
		<span>今日必红推荐</span><?php echo $web; ?> <font color="red" style="font-size:9px;">每天16:00前推单(<?php echo $date ? $date : date('Ymd'); ?>)</font>
		<div class="content">
				<?php get_recommend($file); ?>
		</div>
		<div width="100%" align="center"><div name="dashmain" id="dash-main-id-878aff" class="dash-main-4 878aff-1"></div><script type="text/javascript" charset="utf-8" src="http://www.dashangcloud.com/static/ds.js"></script></div>
	</div>
	
	<div class="text">
		<span>投注记录</span>
		<div class="content">
				<?php get_table(); ?>
		</div>
	</div>
	
	<div class="text">
		<span><?php echo date('m'); ?>月份盈利模拟</span>
		<div class="content">
				<?php moni(); ?>
		</div>
	</div>

	<div class="text">
		<span>倍投测试</span>
		<div class="content">
			针对以上每日必红推荐，以倍投方式进行投注，测试一年盈利能力
			<img src="images/1.jpg" />
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
<div id='text3'><span style="color:red;">加入QQ群，获得版主每日推荐，qq群: 478709617</span>
				<div style="margin-left:150px;">
				<!-- 一键分享 -->
				<div class="right_fx">
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_huaban" data-cmd="huaban" title="分享到花瓣"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["weixin","tsina","douban","huaban","tqq","renren","sqq","qzone"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","douban","huaban","tqq","renren","sqq","qzone"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
				</div>
				<!-- 一键分享 end -->
				</div>
</div>

	<div class="text">
		<span>投注记录</span>
		<div class="content">
				<?php get_table(); ?>
		</div>
	</div>
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
	<div class="foot"><span>Copyright © 2015-2016 design by J</span></div>
</div>

</body></html>
<?php include_once('foot.php'); ?>
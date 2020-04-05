<?php include_once('action.php'); ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="竞彩足球预测" />
<meta name="description" content="竞彩足球预测" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>稳稳二串一单子记录</title>
<style type="text/css">
<!--
img {max-width: 100%;}
#block_header {
	float:left;
	border:0px solid #000;
	width:100%;
}
div{border:0px solid #000;}
#text1 {border:1px dotted #000;}
div.recommend_btn{
	float:right;
	width:50%;
}

.text {margin:1em 0; border:1px dotted #000;}


span.red{display:inline;background-color:pink;color:black;font-weight:bold;}
div.text span{color:red;font-weight:bold;}
div.text span.web {color:black;font-size:14px;background-color:yellow;}
div.text span.red{display:inline;background-color:pink;color:black;}

table.jz_table {
	width:100%;
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #999999;
	border-collapse: collapse;
}
table.jz_table th {
	background:#b5cfd2 url('./images/cell-blue.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
}
table.jz_table td {
	background:#dcddc0 url('./images/cell-grey.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
	text-align:center;
}
table.jz_table td.just_red {
	background:#dcddc0 url('./images/cell-red.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
	text-align:center;
}
-->
</style>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/js.js" type="text/javascript"></script>
</head>
<body>
<?php 
$flag = 0;  //是否开启缓存
$web = "<span class='web'>(来自 benen005.cn/jz)</span>";
?>
<div id="block_header">
	<div id="head">
		<a href="index.php">二串一预测</a> | 
		<a href="index2.php">（混投）</a> | 
		<a href="three.php">三串一预测</a> | 
		<a href="basketball_two.php">篮彩二串一预测</a> | 
		<a href="14.php">14场预测</a> | 
		<a href="9.php">任九预测</a> | 
		<a href="/photo/" target="_blank">美女</a>| 
		<a href="theory.php">预测方法</a> |
		<a href="log.php">Logistic回归</a>
		<a href="index.php?type=computer">(电脑版)</a>
		<a href="phone.php">(手机版)</a> |
		<a href="show.php">我的日志</a> |
		
	</div>
	<div id="head2">
		<div class="head3" onclick="document.getElementById('block_header').style.background='#164E87';document.getElementById('block_footer').style.background='#164E87';"></div>
		<div class="head4" onclick="document.getElementById('block_header').style.background='green';document.getElementById('block_footer').style.background='green';"></div>
		<div class="head5" onclick="document.getElementById('block_header').style.background='yellow';document.getElementById('block_footer').style.background='yellow';"></div>
		<div class="head6" onclick="document.getElementById('block_header').style.background='orange';document.getElementById('block_footer').style.background='orange';"></div>
		<div class="head7" onclick="document.getElementById('block_header').style.background='red';document.getElementById('block_footer').style.background='red';"></div>
	</div>
</div>

<div class="page">
<?php 
//session_start();
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
    <h1>竞彩足球2串1预测</h1><font color="red" size="4">QQ群：478709617</font>
	<hr />
	<?php require_once('date.php'); ?>
	<!--
<div id="text2"><img src="images/1.png" /><br /><a href="#">请帮我点击下面广告</a><br />
<script src="http://e.e708.net/cpc/index.php?76135_2_15_0|1|2_d70000__" charset="gb2312"></script>
</div>
-->
<?php if(file_exists($file)){ ?>
	<div id="text1" style="display:none;">
		<div id="text3"><span>
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
        </span></div>
	</div>
	<div class="text">
		<span>今日必红推荐</span><?php echo $web; ?>
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
		<span>倍投测试</span>
		<div class="content">
			针对以上每日必红推荐，以倍投方式进行投注，测试一个月盈利能力<br />
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
				<!-- 一键分享 -->
				<div class="right_fx">
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_huaban" data-cmd="huaban" title="分享到花瓣"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["weixin","tsina","douban","huaban","tqq","renren","sqq","qzone"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","douban","huaban","tqq","renren","sqq","qzone"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
				</div>
				<!-- 一键分享 end -->
<div id='text3'><span>人称没输过</span></div>

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
	<div class="foot"><span>Copyright © 2015-2015 design by J</span></div>
</div>

</body></html>
<?php include_once('foot.php'); ?>
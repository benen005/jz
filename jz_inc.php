<?php 

//让胜平负
function lang_2_1($file){
        $r = read($file);
        $r2 = read_lang($file);  //读取赔率
        //$arr_table = read_match_lang($file);  //读取文字
        $r = arr_maopao($r);
        $r2 = arr_maopao($r2);
        $r = generate_2_1($r);
        $r2 = generate_2_1($r2);
        
        $r3 = read_both($file);
        $r3 = arr2_maopao($r3);
        $r3 = generate_arr_2_1($r3);
        return $r3;
}

function draw_2_1($file){
        $r = read_both($file);
        $r2 = arr2_maopao($r);
        //$r3 = generate_arr_2_1($r);
        $t = array();
        for($i=0;$i<count($r);$i++){
            if($r2[$i][0][0] > 2){
                    $t[$i] = $r[$i][0];
                    $t[$i][3] = 0;
            }
            else{
                    $t[$i] = $r[$i][1];
                    $t[$i][3] = 1;
            }
        }
        
        return $t; 
}

function comment_filt($f){
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
        return $f;
}

function get_recommend($file, $type = 1){
        $s = explode(".", $file);
        $s[0] .= "_recommend_" . $type;
        $s = implode(".", $s);
        $file2 = $s;
        if(file_exists($file2)){
            $r = file_get_contents($file2);
            echo $r;
        }
        else
            echo "今日无推荐";
}

function get_userip(){
	$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
	$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
    return $user_IP;
}

function render_red($string, $find){
        $f = str_replace($find, "<span class='red'>".$find."</span>", $string);
        return $f;
}
function render_red2($string, $find1, $find2){
        $string = str_replace($find1, "<span class='red'>".$find1."</span>", $string);
        $f = str_replace($find2, "<span class='red'>".$find2."</span>", $string);
        return $f;
        

}

function sfp_310($string, $search){
    $s = strlen($string);
    if(strpos($string, $search)){
        $pos = strpos($string, $search);
        $pos = $s - $pos;
    } 
    if($pos == 14 || $pos == 15 || $pos == 16)
        return '<font color="red">3</font>';
    elseif($pos == 4 || $pos == 5 || $pos == 3)
        return '<font color="red">0</font>';
    else
        return '<font color="red">1</font>';
}
        /*胜 平 负*/
        function sfp($string1, $string2, $search){
            $s1 = strlen($string1);
            $s2 = strlen($string2);
            if(strpos($string1, $search)){
                $pos = strpos($string1, $search);
                $pos = $s1 - $pos;
            }
            else{
                $pos = strpos($string2, $search);
                $pos = $s2 - $pos;
            }
            if($pos == 14)
                return '胜';
            elseif($pos == 4)
                return '负';
            else
                return '平';
        }

    /* 读取数据库中的胜平负赔率 */
    function read($file) {
        $temp = file($file);
        $t = array();
        $j = 0;
        for($i = 5; $i < count($temp); $i=$i+7){
            $temp[$i] = trim(substr($temp[$i], 2));
            $t[$j] = explode(" ", $temp[$i]);
            $j++;
        }
        //sort($t);
        
        return $t;
    }
    
    /* 读取数据库中的胜平负赔率 */
    function read_both($file) {
        $temp = file($file);
        $t = array();
        $j = 0;
        for($i = 5; $i < count($temp); $i=$i+7){
            $temp[$i] = trim(substr($temp[$i], 2));
            $temp[$i+1] = trim(substr($temp[$i+1], 2));
            $t[$j][0] = explode(" ", $temp[$i]);
            $t[$j][1] = explode(" ", $temp[$i+1]);
            $j++;
        }
        //sort($t);
        
        return $t;
    }
    
    /* 读取数据库中的让胜平负赔率 */
    function read_lang($file) {
        $temp = file($file);
        $t = array();
        $j = 0;
        for($i = 6; $i < count($temp); $i=$i+7){
            $temp[$i] = trim(substr($temp[$i], 2));
            $t[$j] = explode(" ", $temp[$i]);
            $j++;
        }
        //sort($t);
        
        return $t;
    }
    
    /* 读取数据库中的让胜平负赔率 */
    function read_arr_match($file) {
        $temp = file($file);
        $t = array();
        $j = 0;
        for($i = 1; $i < count($temp); $i=$i+7){
                $tt = trim(substr($temp[$i+5], 0, 2));
                if($tt == 1)
                    $tt = "+" . $tt;
                $t[] = $temp[$i-1] . " " .  $temp[$i+2] . ":" . $temp[$i+3] . "  " . trim(substr($temp[$i+4], 2)) . " (让" . $tt . " " . trim(substr($temp[$i+5], 2)) . ")";
            
        }
        //sort($t);
        
        return $t;
    }
    
    function read_match($file) {
        $temp = file($file);
        $t = array();
        $j = 0;
        for($i = 1; $i < count($temp); $i=$i+7){
            
                $t[] = $temp[$i-1] . " " .  $temp[$i+2] . ":" . $temp[$i+3] . "  " . trim(substr($temp[$i+4], 2));
            
        }
        //sort($t);
        
        return $t;
    }
    
    function read_match_lang($file) {
        $temp = file($file);
        $t = array();
        $j = 0;
        for($i = 1; $i < count($temp); $i=$i+7){
            
                $t[] = $temp[$i-1] . " " .  $temp[$i+2] . ":" . $temp[$i+3] . "  " . trim(substr($temp[$i+5], 2));
            
        }
        //sort($t);
        
        return $t;
    }
    
//读取14场数据, 返回二维数组
function read_14($file){
        $temp = file($file); 
        $t = array();
        $r = array();
        for($i = 0; $i < count($temp); $i++){
            //$temp[$i] = trim($temp[$i]);
            $t[$j] = explode("	", $temp[$i]);
            $r[] = array($t[$j][5], $t[$j][6], $t[$j][7]);
            $j++;
        }
        return $r;
}

//读取14场数据, 返回一维数组
function read_14_2($file){
        $temp = file($file);
        $t = array();
        $r = array();
        for($i = 0; $i < count($temp); $i++){
            //$temp[$i] = trim($temp[$i]);
            $t[$j] = explode("	", $temp[$i]);
            //$r[] = array($t[$j][6], $t[$j][7]);
            $r[] = $t[$j][0] . " " . $t[$j][1] . " ". $t[$j][2] . " ". $t[$j][3] . " ". $t[$j][5] . " ". $t[$j][6] . " ". $t[$j][7];
            $j++;
        }
        return $r;
}

//$file = 'txt/txt_b_20150203.txt';
//$s = read_basketball($file);
//$s = arr_maopao_2($s);
//print_r($s);
//$s = generate_2_1($s);
//print_r($s);

function read_b($file){
        $temp = file($file);
        $t = array();
        $r = array();
        $j = 0;
        for($i = 0; $i < count($temp); $i++){
                $t[$j] = explode(" ", $temp[$i]);
                $r[] = $t[$j][0] . " " . $t[$j][1] . " ". $t[$j][3] . " ". $t[$j][4];
                //$t[] = trim(substr($temp[$i], 0));
                $j++;
        }
        //sort($t);
        
        return $r;
}

function read_basketball($file){
        $temp = file($file);
        $t = array();
        $r = array();
        for($i = 0; $i < count($temp); $i++){
            $temp[$i] = trim($temp[$i]);
            $t[$j] = explode(" ", $temp[$i]);
            $r[] = array($t[$j][3], $t[$j][4]);
            $j++;
        }
        return $r;
}
    
    
function compute($arr, $n){
        return array($arr[0] * $n / 2, $arr[1] * $n / 2);
}

function compute_b($arr, $n){
        return array($arr[0] * $n, $arr[1] * $n);
}


//array(array(2,3,4),array(1,2,3))  => array(2*1, 3*1)
function rate_2_1($arr, $rand = 1){
        if($arr[3][0] == $arr[2][0]) //胆是第一个索引
                $r = array($arr[0][0] * $arr[1][0], $arr[0][0] * $arr[1][$rand]);
        else                         //胆是第二个索引
                $r = array($arr[0][0] * $arr[1][0], $arr[0][$rand] * $arr[1][0]);
        //asort($r);
        return $r;
}

function rate_arr_2_1($arr, $rand = 1){
        if($arr[3][0] == 0) //胆是第一个索引
                $r = array($arr[0][$arr[3][1]][0] * $arr[1][$arr[3][2]][0], $arr[0][$arr[3][1]][0] * $arr[1][$arr[3][2]][$rand]);
        else                         //胆是第二个索引
                $r = array($arr[1][$arr[3][1]][0] * $arr[0][$arr[3][2]][0], $arr[1][$arr[3][1]][0] * $arr[0][$arr[3][2]][$rand]);
        //asort($r);
        return $r;
}

//array(array(2,3,4),array(1,2,3), array(4,5,6))  => array(2*1, 3*1)
function rate_3_1($arr){
        if($arr[4][0] == $arr[3][0])  //双选是第一个索引
                $r = array($arr[0][0] * $arr[1][0] * $arr[2][0], $arr[0][1] * $arr[1][0] * $arr[2][0]);
        elseif($arr[4][0] == $arr[3][1]) //双选是第二个索引
                $r = array($arr[0][0] * $arr[1][0] * $arr[2][0], $arr[0][0] * $arr[1][1] * $arr[2][0]);
        else
                $r = array($arr[0][0] * $arr[1][0] * $arr[2][0], $arr[0][0] * $arr[1][0] * $arr[2][1]);
        //asort($r);
        return $r;
}

function rate_2_1_b($arr){
        $r = array($arr[0][0] * $arr[1][0], $arr[0][0] * $arr[1][0]);
        return $r;    
}

//14 中选 9场
function generate_9_n($arr, $n = 9, $m = 5){
        srand((float) microtime() * 10000000);
        $index = array_rand($arr, $n);
        $index2 = array_rand($index, $m);
        sort($index);

        $new_arr = $arr;

        $new_arr[15] = $index; //返回索引
        $r = array();
        for($i=0;$i<$m;$i++){
                $r[] = $index[$index2[$i]];
        }
        
        $new_arr[16] = $r;
        $t = array();
        
        return $new_arr;
       
}

//array(4) => array(2) 随机抽2个,再返回索引
function generate_14_n($arr, $n = 5){
        srand((float) microtime() * 10000000);
        $index = array_rand($arr, $n);
        sort($index);
        //print_r($index);
        //$new_arr = array($arr[$index[0]], $arr[$index[1]], $arr[$index[2]], $arr[$index[3]], $arr[$index[4]]);
        $new_arr = $arr;
        //print_r($new_arr);
        
        //$dan = rand(0,1);
        //if($dan == 0)
        //        $other = 1;
        //else
        //        $other = 0;
        //shuffle($new_arr);
        
        //$new_arr = array($new_arr[$other], $new_arr[$dan]);
        $new_arr[15] = $index; //返回索引
        $t = array();
        
        return $new_arr;
       
}

//
function generate_arr_2_1($arr){
        srand((float) microtime() * 10000000);
        $index = array_rand($arr, 2);
        sort($index);

        $new_arr = array($arr[$index[0]], $arr[$index[1]]);

        
        $d = array(rand(0,1), rand(0,1), rand(0,1));

        $new_arr[2] = $index; //返回索引
        $new_arr[3] = array($d[0], $d[1], $d[2]);
        
        return $new_arr;
       
}

//array(4) => array(2) 随机抽2个,再返回索引
function generate_2_1($arr){
        srand((float) microtime() * 10000000);
        $index = array_rand($arr, 2);
        sort($index);
        //print_r($index);
        $new_arr = array($arr[$index[0]], $arr[$index[1]]);
        //print_r($new_arr);
        
        $dan = rand(0,1);
        if($dan == 0)
                $other = 1;
        else
                $other = 0;
        //shuffle($new_arr);
        
        //$new_arr = array($new_arr[$other], $new_arr[$dan]);
        $new_arr[2] = $index; //返回索引
        $new_arr[3] = array($index[$dan]);
        return $new_arr;
       
}

//array(4) => array(2) 随机抽2个,再返回索引
function generate_3_1($arr){
        srand((float) microtime() * 10000000);
        $index = array_rand($arr, 3);
        //print_r($index);
        sort($index);
        $new_arr = array($arr[$index[0]], $arr[$index[1]], $arr[$index[2]]);
        //print_r($new_arr);
        
        $dan = rand(0,2);

        $new_arr[3] = $index; //返回索引
        $new_arr[4] = array($index[$dan]);
        return $new_arr;
       
}
function arr2_maopao($arr){
        for($i=0;$i<count($arr);$i++){
                for($j=0;$j<2;$j++)
                        $arr[$i][$j] = maopao($arr[$i][$j]);
        }
        return $arr;
}

//array(array(3,2,1,), array(4,3,2)) => array(array(1,2,3), array(2,3,4)) 排序
function arr_maopao($arr){
        for($i=0;$i<count($arr);$i++){
                $arr[$i] = maopao($arr[$i]);
        }
        return $arr;
}

//array(3,2,1) => array(1,2,3) 排序
function maopao($arr){
        
        if($arr[1] > $arr[2]){
                $tmp = $arr[1];
                $arr[1] = $arr[2];
                $arr[2] = $tmp;
        }
        
        if($arr[0] > $arr[1]){
                $tmp = $arr[0];
                $arr[0] = $arr[1];
                $arr[1] = $tmp;
        }  
        
        if($arr[1] > $arr[2]){
                $tmp = $arr[1];
                $arr[1] = $arr[2];
                $arr[2] = $tmp;
        }  
        
        return $arr;
}

//针对竞彩篮球
function arr_maopao_2($arr){
        for($i=0;$i<count($arr);$i++){
                $arr[$i] = maopao_2($arr[$i]);
        }
        return $arr;  
}

function maopao_2($arr){
        if($arr[1] < $arr[0]){
                $tmp = $arr[0];
                $arr[0] = $arr[1];
                $arr[1] = $tmp;
        }
        return $arr;
}

    /* 读取文件中数据 返回一维数组 */
    function read_it($file) {
        $temp = file($file);
        return $temp;
    }
    
    /* 读取文件 返回二维数组 */
    function read2($file) {
        $temp = file($file);

        $t = array();

        for($i = 0; $i < count($temp); $i++){
            $temp[$i] = trim($temp[$i]);
            $t[$i] = explode(" ", $temp[$i]);}
        //sort($t);
        
        return $t;
    }

//模拟开奖
function kj($n, $rate){
        $zone1 = range(1, $n);
        $int = (int)$n * $rate;
        $keys = array_rand($zone1, $int);
        return $keys;
}

//如果中奖 返回1
function is_zj($arr, $n){
        for($i=0;$i<count($arr);$i++){
                if($arr[$i] == $n)
                        return 1;
        }
        return 0;
}


function moni(){
    $t = tz_n(0, 200, 0.55, 20);
    //print_r($t);
    $s = '';
    for($i=0;$i<count($t[0]);$i++){
        $s = $s . $t[0][$i][1][0] ."(". $t[0][$i][1][1] . ") ";
    }
    echo "参数: 中奖概率0.55, 赔率2.5倍, 每次投200, 共20轮<br />";
    echo "共计: $t[2]天";
    echo "<br />模拟盈利: 累计盈利金额(每轮天数)<br />";
    echo $s;
}


function touzhu($money, $m, $n, $a){
    $total = $money;
    for($i=1;$i<=$n;$i++){
        if(g2($a)){
            $total = $total + $m * p2();
        }
        else{
            $total = $total - $m;
            
        }
    }
    return $total;
}

//设置赔率
function p2(){
    return 2.5;
}

//$money 初始资金, $m 每次投注额, $a 中奖概率
function tz($money, $m, $a){
    $total = $money;
    $n = 0;
    $arr = array();
    do{
        $is_prize = g2($a);
        $arr[] = array($total, $n, $is_prize);
        if($is_prize){
            $total = $total + ($m * pow(2, $n)) * (p2() - 1);
        }
        else{
            $is_prize = 0;
            $total = $total - $m * pow(2, $n);
        }
        $n++;
        
    } while(!$is_prize);    //若不中奖继续循环
    return array($arr, array($total, $n));
}

function tz_n($money, $m, $a, $n){
    $arr = array();
    $total = $money;
    $ci = 0;
    for($i=1;$i<=$n;$i++){
        $tz = tz($total, $m, $a);
        $arr[] = $tz;
        $total = $tz[1][0];
        $ci = $ci + $tz[1][1];
    }
    return array($arr, $total, $ci);
}



function g2($probility){
    $r = rand(1, 10);
    $a = 10 * $probility;
    if($r >= 1 and $r <= $a){
        return 1;
    }
    else
        return 0;
}



function isMobile(){    
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';    
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';      
    function CheckSubstrs($substrs,$text){    
        foreach($substrs as $substr)    
            if(false!==strpos($text,$substr)){    
                return true;    
            }    
            return false;    
    }  
    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');  
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');    
                
    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||    
              CheckSubstrs($mobile_token_list,$useragent);    
                
    if ($found_mobile){    
        return true;    
    }else{    
        return false;    
    }    
}  
/*
if (isMobile())  
    echo '手机登录m.php.com';  
else
    echo '电脑登录www.php.com';  
*/

?>
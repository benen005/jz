<?php 

/* 为目录服务 */
if (DIRECTORY_SEPARATOR === '\\') {
    define('root_dir', str_replace('\\', '/', dirname(__DIR__)));
} else {
    define('root_dir', dirname(__DIR__));
}


/**
 * 日志记录对象
 */
final class logger {
    public static function init() {
        self::$log_query = true;
    }
    public static function log_error($message) {
        self::log(root_dir . '/www/cp_data/ddt.txt', $message);
    }
    public static function log_query($type, $message) {
        if (self::$log_query) {
            self::log(root_dir . '/data/log/' . $type . '.log', $message);
        }
    }
    private static function log($file, $message) {
        $fp = fopen($file, 'a');
        if ($fp !== false) {
            flock($fp, LOCK_EX);
            fwrite($fp, '[' . timer::get_datetime() . '] - ' . $message . "\n");
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
    /* 读取文件中倒数 $n 行 返回二维数组 */
    public static function read($file, $n = 10) {
        $temp = file($file);
        $n1 = count($temp);
        $num = $n1;
        $n1--;
        
        if($n < $num)
            $num = $n;
        $n2 = $n1 - $num;
        
        $t = array();
        
        
        
        for($i = $n1; $i > $n2; $i--){
            $temp[$i] = trim($temp[$i]);
            $t[$i] = explode(" ", $temp[$i]);}
        sort($t);
        
        return $t;
    }
    
    /* 读取文件中数据 返回一维数组 */
    public static function read_it($file) {
        $temp = file($file);
        return $temp;
    }
    
    public static function read_pl3($file) {
        $f = self::read_it($file);
        $r = array();
        

        foreach($f as $k => $v){
            $r[$k][] = substr($v, 0, 1);
            $r[$k][] = substr($v, 1, 1);
            $r[$k][] = substr($v, 2, 1);
            
        }
        
        return $r;
    }
    
    public static function read_che($file) {
        $f = self::read_it($file);
        $r = array();
        foreach($f as $k => $v){
            $r[] = substr($v, 21, 12);
        }
        return $r;
    }
    
    // 过滤 ddt ssq 见 gl.php
    public static function guolv_ddt($read_file, $file) {
        
        $fp = fopen($file, 'w');
        if ($fp !== false) {
            flock($fp, LOCK_EX);

            $f = file($read_file);
            foreach($f as $key => $value){
                $value = substr($value, 6, 20);
                fwrite($fp, $value . "\n");
            }
        
            flock($fp, LOCK_UN);
            fclose($fp);
        }        
        
    }
    
    public static function guolv_500wan_ddt($read_file, $file) {
        
        $fp = fopen($file, 'w');
        if($fp !== false){
            flock($fp, LOCK_EX);
            
            $f = file($read_file);
            foreach($f as $k => $v){
                $v = str_replace("|", " ", $v);
                $v = str_replace(",", " ", $v);
                fwrite($fp, $v);
            }
            
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
    
    public static function tag($c) {
        $c = str_replace("<", "[", $c);
        $c = str_replace(">", "]", $c);
        return $c;
    }
    
    public static function tag_($c) {
        $c = str_replace("[", "<", $c);
        $c = str_replace("]", ">", $c);
        return $c;
    }
    
    public static function jl($file, $c) {
        
        $fp = fopen($file, 'w');
        if($fp !== false){
            flock($fp, LOCK_EX);
            
            //$f = file($read_file);
 
            
            fwrite($fp, $c);

            
            flock($fp, LOCK_UN);
            fclose($fp);
            
            
        }
        
    }
    
    public static function jl_array($file, $c) {
        
        $fp = fopen($file, 'w');
        if($fp !== false){
            flock($fp, LOCK_EX);
            
            //$f = file($read_file);
 
            foreach($c as $k => $v){
                fwrite($fp, $v."\n");
            }

            flock($fp, LOCK_UN);
            fclose($fp);
            
            
        }
        
    }
    
    private static $log_query = false;
}

/*
 *  分析双色球
 */
final class fx_ssq {

    /* 分析 按红球或蓝球在近 $n 期中出现的频率进行分层, 是频率分析的基础性工作 */
    public static function fx_base() {
        $array = self::$array;
        // $array is a two-dementional array
        $arr_Total = array();
        $arr_ararage = array();
        $arr_ararage2 = array();
        $arr_red_rate = array();
        $arr_blue_rate = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        
        $temp1 = 0;
        $temp2 = 0;
        
        for($i = 0; $i < count($array); $i++){
            for($j=0;$j<count($array[$i]);$j++){
                $arr_Total[$j] += $array[$i][$j];
                if($j <= 5){
                    // todo
                    $temp1 = intval($array[$i][$j]);
                    $arr_red_rate[$temp1] += 1;
                }
                else{
                    // todo
                    $temp2 = intval($array[$i][$j]);
                    $arr_blue_rate[$temp2] += 1;
                }
            }
        }
        
        for($k = 0;$k<count($arr_Total);$k++){
            $arr_avarage[$k] = $arr_Total[$k] / $i;
            $arr_avarage2[$k] = round($arr_avarage[$k]);
        }

        self::$arr_Count = $arr_Total;
        self::$arr_avarage = $arr_avarage;
        self::$arr_avarage2 = $arr_avarage2;
        
        ksort($arr_red_rate);
        ksort($arr_blue_rate);
        
        self::$red_rate = $arr_red_rate;
        
        
        /* 处理一下 $arr_blue 除去 第一个 0 */
        $temp = array();
        foreach($arr_blue_rate as $k => $v){
            if($k <> 0)
                $temp[$k] = $v;
        }
        
        $arr_blue_rate = $temp;
        /* 处理结束 */
        
        
        self::$blue_rate = $arr_blue_rate;
        
        asort($arr_red_rate);
        asort($arr_blue_rate);
        
        self::$red_rate_sort = $arr_red_rate;
        self::$blue_rate_sort = $arr_blue_rate;
    }
    
    public function fx_ssq($arr = array()) {
        self::$array = $arr;
    }
    
    public function init() {
        self::fx_base();
    }
    
    /* 得到  和 */
    public function get_arr_Count() {
        return self::$arr_Count;
    }
    
    /* 得到平均数 */
    public function get_arr_Avarage() {
        return self::$arr_avarage;
    }
    
    /* 得到平均整数 */
    public function get_arr_Avarage2() {
        return self::$arr_avarage2;
    }
    
    /* 得到 红球 频率 */
    public function get_arr_Red_Rate() {
        return self::$red_rate;
    }
    
    /* 得到 红球 频率 并 排序 */
    public function get_arr_Red_Rate_sort() {
        return self::$red_rate_sort;
    }
    
    /* 得到 蓝球 频率 并 排序 */
    public function get_arr_Blue_Rate_sort() {
        return self::$blue_rate_sort;
    }
    
    /* 得到 蓝球 频率 */
    public function get_arr_Blue_Rate() {
        return self::$blue_rate;
    }
    
    /* 输入 待分析数组  */
    public function input_array($arr) {
        self::$array = $arr;
    }
    
    /* 频率 提取 以字符串形式输出 */
    public static function rate_report_string($s, $arr_red, $arr_blue) {
        $t = self::rate_report($s, $arr_red, $arr_blue);
        $ss = '';
        foreach($t as $k => $v){
            foreach($v as $key => $value){
                $ss .= $value . " ";
            }
        }
        $ss = trim($ss);
        return $ss;
    }
    
    /* 频率 提取 以二维数组输出 */
    public static function rate_report($s, $arr_red, $arr_blue) {
        $r_array = array();
        $b_array = array();
        $result = array();
        
        $s = trim($s);
        $arr = explode(" ", $s);
        foreach($arr as $key => $value)
            $arr[$key] = intval($value);
        
        foreach($arr_red as $key => $value){
            foreach($arr as $k => $v){
                if($k <= 5){
                    if($key == $v){
                        
                        $r_array[$key] = $value;
                        
                    }
                }
            }
        }
        
        foreach($arr_blue as $key => $value){
            foreach($arr as $k => $v){
                if($k > 5){
                    if($key == $v){
                        $b_array[$key] = $value;
                    }
                }
            }
        }
        
        array_push($result, $r_array, $b_array);
        return $result;
        
    }
    
    /* 随机分层为选号的一种策略 */
    /* 随机在分层频率里抽取一个红球 */
    public static function rate_red_seize($arr_red, $num = 6) {
        $array = array_unique($arr_red);
        sort($array);
        //$array2 = array_count_values($arr_red);
        
        $array3 = array();
        
        
        for($i=0;$i<count($array);$i++){
            foreach($arr_red as $r_k => $r_v){
                if($r_v == $array[$i]){
                    $array3[$r_v][] = $r_k;
                }
            }
        }
        
        /* 防止 array_rand 产生随机错误 */
        if(count($array) < $num)
            $num = count($array);
            
        if($num == 1)
            $array4 = array(array_rand($array3));
        else
            $array4 = array_rand($array3, $num);
        //$array4 = array_rand($array3[$array4]);
        $array5 = array();
        
        foreach($array4 as $k => $v){
            $a = array_rand($array3[$v]);
            $array5[] = $array3[$v][$a];
        }
        
        sort($array5);
        //print_r($array3);
        //print_r($array4);
        //print_r($array5);
        foreach($array5 as $k => $v){
            if($v < 10){
                $array5[$k] = "0" . $v;
            }
        }
        
        $r = implode(" ", $array5);
        
        return $r;
        
    }
    

    
    /* 随机在分层频率里抽取一个蓝球 */
    public static function rate_blue_seize($arr_blue, $num = 1) {
        $array = array_unique($arr_blue);
        sort($array);
        
        //$array2 = array_count_values($arr_red);
        
        $array3 = array();
        
        
        for($i=0;$i<count($array);$i++){
            foreach($arr_blue as $r_k => $r_v){
                if($r_v == $array[$i]){
                    $array3[$r_v][] = $r_k;
                }
            }
        }
        
        /* 防止 array_rand 产生随机错误 */
        if(count($array) < $num)
            $num = count($array);
            
            
            
        if($num == 1)
            $array4 = array(array_rand($array3));
        else
            $array4 = array_rand($array3, $num);
            
            
        //$array4 = array_rand($array3[$array4]);
        $array5 = array();
        
        foreach($array4 as $k => $v){
            $a = array_rand($array3[$v]);
            $array5[] = $array3[$v][$a];
        }
        
        sort($array5);
        //print_r($array3);
        //print_r($array4);
        //print_r($array5);
        foreach($array5 as $k => $v){
            if($v < 10){
                $array5[$k] = "0" . $v;
            }
        }
        
        $r = implode(" ", $array5);
        
        return $r;
        
    }
    
    /* 合并 抽取结果 显示为字符串 */
    public static function merge_rate_seize($arr_red, $arr_blue, $n_r = 6, $n_b = 1) {
        $a = self::rate_red_seize($arr_red, $n_r);
        $b = self::rate_blue_seize($arr_blue, $n_b);
        return $a . " " . $b;
    }
    
    /* 合并 抽取结果 显示 二维数组 */
    public static function merge_rate_seize_generate_array($arr_red, $arr_blue, $n_r = 6, $n_b = 1) {
        $a = self::rate_red_seize($arr_red, $n_r);
        $b = self::rate_blue_seize($arr_blue, $n_b);
        return array($a, $b);
    }
    
    /* 匹配 6 + 1 模式 $arr = {'1 2 3 4 5 6 7','2 3 4 5 6 7 8'} $s = '1 2 3 4 5 6 7' */
    public static function match_6_1($arr, $s) {
        $ss = '';
        $r_arr = array();
        foreach($arr as $k => $v){
            $arr[$k] = trim($v);
            $arr[$k] = explode(" ", $v);
        }
        $s = trim($s);
        $arr2 = explode(" ", $s);
        
        //print_r($arr);
        $pp = 0;
        $blue_num = 0;
        $array_blue = array();
        foreach($arr as $arr_k => $arr_v){
            $n = 0;    //记录红球相同数
            $bn = 0;   //记录蓝球相同数
            $flag = 0;
            $ss = $ss . "[$arr_k] ";
            for($i=0;$i<6;$i++){
                for($j=0;$j<6;$j++){
                    if($arr_v[$i] == $arr2[$j]){
                        $ss = $ss . "<font color='red'>".$arr_v[$i]."</font>"." ";
                        $n++;
                        $flag++;
                    }

                }
                if($flag == 0){
                    $ss = $ss . $arr_v[$i] . " ";
                }
                $flag = 0;
            }
            
            if($arr_v[6] == $arr2[6]){
                $ss = $ss . "<font color='blue'>".$arr_v[6]."</font>"." ";
                $bn++;
                $blue_num++;
                $array_blue[] = $arr_k;
            }
            else
                $ss = $ss . $arr_v[6] . " ";
            $pp++;
            if($pp % 5 == 0)
                $ss = $ss . "<br />";
            else
                $ss = $ss . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $r_arr[$arr_k][0] = $n;
            $r_arr[$arr_k][1] = $bn;
        }
        
        echo $ss;
        $rr_arr = array();
        foreach($r_arr as $k => $v){
            if($v[0] >= 4){
                $rr_arr[$k][0] = $v[0];
                $rr_arr[$k][1] = $v[1];
            }
        }
        echo "红球相同>=4: " . count($rr_arr);
        print_r($rr_arr);
        echo "蓝球相同:" . $blue_num;
        print_r($array_blue);
        
    }
    
    /* 匹配 n + m 模式 $arr = { [0] => array('1 2 3 4 5 6 7', '1 2'), [1] => array('2 3 4 5 6 7 8','2 3')} $s = '1 2 3 4 5 6 7' */
    public static function match_n_m($arr, $s) {
        $ss = '';
        $r_arr = array();
        $s = trim($s);
        $arr2 = explode(" ", $s);
        
        //print_r($arr);
        $pp = 0;
        $blue_num = 0;  //蓝球相同数
        $array_blue = array();
        
        
        foreach($arr as $arr_k => $arr_v){
            $n = 0;    //记录红球相同数
            $bn = 0;   //记录蓝球相同数
            $flag = 0;
            $ss = $ss . "[$arr_k] ";
            
            
            
            $temp_arr_red  = explode(" ", $arr_v[0]);
            $temp_arr_blue = explode(" ", $arr_v[1]);
            
            foreach($temp_arr_red as $r_k => $r_v){
                for($j=0;$j<6;$j++){
                    if($r_v == $arr2[$j]){
                        $ss = $ss . "<font color='red'>".$r_v."</font>"." ";
                        $n++;
                        $flag++;
                    }

                }
                if($flag == 0){
                    $ss = $ss . $r_v . " ";
                }
                $flag = 0;
            }
            
            foreach($temp_arr_blue as $b_k => $b_v){
                if($b_v == $arr2[6]){
                    $ss = $ss . "<font color='blue'>".$b_v."</font>"." ";
                    $bn++;
                    $blue_num++;
                    $array_blue[] = $arr_k;
                }
                else
                    $ss = $ss . $b_v . " ";                
            }
            

            $pp++;
            if($pp % 5 == 0)
                $ss = $ss . "<br />";
            else
                $ss = $ss . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $r_arr[$arr_k][0] = $n;
            $r_arr[$arr_k][1] = $bn;
        }
        
        echo $ss;
        $rr_arr = array();
        $arr_6 = array();
        $arr_5 = array();
        $arr_3 = array();
        $arr_3 = array();
        $arr_2 = array();
        $arr_1 = array();
        foreach($r_arr as $k => $v){
            if($v[0] >= 5){
                $rr_arr[$k][0] = $v[0];
                $rr_arr[$k][1] = $v[1];
            }
            if(($v[0] == 0 && $v[1] == 1) || ($v[0] == 1 && $v[1] == 1) || ($v[0] == 2 && $v[1] == 1)){
                $arr_6[$k][0] = $v[0];
                $arr_6[$k][1] = $v[1];
            }
            if(($v[0] == 3 && $v[1] == 1) || ($v[0] == 4 && $v[1] == 0)){
                $arr_5[$k][0] = $v[0];
                $arr_5[$k][1] = $v[1];
            }
            if(($v[0] == 4 && $v[1] == 1) || ($v[0] == 5 && $v[1] == 0)){
                $arr_4[$k][0] = $v[0];
                $arr_4[$k][1] = $v[1];
            } 
            if(($v[0] == 5 && $v[1] == 1)){
                $arr_3[$k][0] = $v[0];
                $arr_3[$k][1] = $v[1];
            } 
            if(($v[0] == 6 && $v[1] == 0)){
                $arr_2[$k][0] = $v[0];
                $arr_2[$k][1] = $v[1];
            } 
            if(($v[0] == 6 && $v[1] == 1)){
                $arr_1[$k][0] = $v[0];
                $arr_1[$k][1] = $v[1];
            } 
            
        }
        
        echo "6等奖:" . count($arr_6) . "  5等奖:" . count($arr_5) . "  4等奖:" . count($arr_4) . "  3等奖:" . count($arr_3) . "  2等奖:" . count($arr_2) . "  1等奖:" . count($arr_1);
        echo "<br />";
        $total = count($arr_6) * 5 + count($arr_5) * 10 + count($arr_4) * 200 + count($arr_3) * 3000 + count($arr_2) * 300000 + count($arr_1) * 5000000;
        echo "共计:" . $total;
        echo "<br />";
        echo "红球相同>=5:" . count($rr_arr);
        print_r($rr_arr);
        echo "蓝球相同:" . $blue_num;
        print_r($array_blue);

    }
    
    
    /* 从 1-10 里抽取 $n1 个 11 - 20 $n2  21 - 30 $n3  31 - 35 $n4 */
    public static function zone_seize($n1, $n2, $n3, $n4, $bn = 1, $set = 0, $blue = '01') {
        
        $zone1 = array('01','02','03','04','05','06','07','08','09','10');
        $zone2 = array('11','12','13','14','15','16','17','18','19','20');
        $zone3 = array('21','22','23','24','25','26','27','28','29','30');
        $zone4 = array('31','32','33');
        
        if($n1 > 0)
            if($n1 == 1)
                $rand_keys_1 = array(array_rand($zone1, $n1));
            else
                $rand_keys_1 = array_rand($zone1, $n1);
        
        if($n2 > 0)
            if($n2 == 1)
                $rand_keys_2 = array(array_rand($zone2, $n2));
            else
                $rand_keys_2 = array_rand($zone2, $n2);
            
        if($n3 >0)    
            if($n3 ==1 )
                $rand_keys_3 = array(array_rand($zone3, $n3));
            else
                $rand_keys_3 = array_rand($zone3, $n3);
                
        if($n4 > 0)
            if($n4 == 1)
                $rand_keys_4 = array(array_rand($zone4, $n4));
            else
                $rand_keys_4 = array_rand($zone4, $n4);
        
        $r = array();
        for($i=0;$i<$n1;$i++)
            array_push($r, $zone1[$rand_keys_1[$i]]);
        

        for($i=0;$i<$n2;$i++)
            array_push($r, $zone2[$rand_keys_2[$i]]);
            

        for($i=0;$i<$n3;$i++)
            array_push($r, $zone3[$rand_keys_3[$i]]);
            

        for($i=0;$i<$n4;$i++)
            array_push($r, $zone4[$rand_keys_4[$i]]);
        
        $r = implode(" ", $r);
        $r1 = self::create_blue_ball_2($bn);
        $r1 = implode(" ", $r1);
        
        if($set){
            $r1 = $blue;
        }
        
        $r = array($r, $r1);
        
        
        
        return $r;
    }
    
    
    /* 对 1 - 10 11-20 21-30 31-35 里 报告在几个落入该区间 */
    public static function zone_report($s, $set = 0) {
        $r = explode(" ", $s);
        $n1 = 0;
        $n2 = 0;
        $n3 = 0;
        $n4 = 0;
        $n5 = 0;
        $n6 = 0;
        foreach($r as $k => $v){
            $r[$k] = intval($v);
            if($k <= 5){
                
                if($r[$k] < 11)
                    $n1++;
                if($r[$k] > 10 && $r[$k] < 21)
                    $n2++;
                if($r[$k] > 20 && $r[$k] < 31)
                    $n3++;
                if($r[$k] > 30)
                    $n4++;
            }
            if($k > 5){
                if($r[$k] < 11)
                    $n5++;
                if($r[$k] > 10)
                    $n6++;
            }
            
        }
        
        if($set)
            $r = $n1.$n2.$n3.$n4;
        else
            $r = $n1 . " " . $n2 . " " . $n3 . " " . $n4 . " " . $n5 . " " . $n6 . " ";
        
        return $r;
    }

    
    /* 01 02 03 04 05 06 07 => 01,02,03,04,05|06,07 */
    public static function format_array($r) {
        for($i=0;$i<count($r);$i++){
            $temp1 = explode(" ", $r[$i][0]);
            $temp2 = implode(",", $temp1);
            $temp3 = explode(" ", $r[$i][1]);
            $temp4 = implode(",", $temp3);
            $temp5 = $temp2 . "|" . $temp4;
            
            $r2[] = $temp5;
        }

        foreach($r2 as $k => $v)
            echo $v . "<br />";
    }
    
    /* array(01 02 03 04 05 06 07) => array(array(), array()) */
    public static function format_to_two_array($r) {
        $rr = array();
        foreach($r as $k => $v){
            $t = explode(" ", $v);
            $t1 = '';
            $t2 = '';
            
            foreach($t as $t_k => $t_v){
                if($t_k <= 5){
                    $t1 .= $t_v . " ";
                }
                if($t_k > 5){
                    $t2 .= $t_v . " ";
                }
            }
            $t1 = trim($t1);
            $t2 = trim($t2);
            $rr[] = array($t1, $t2);
        }
        
        return $rr;
    }
    
    /* 产生 $n1 个奇数 $n2 个偶数 返回二维数组 */
    public static function odd_even_seize($odd_num, $even_num, $bn = 1, $set = 0) {
        
        $arr = array();
        
        if($odd_num > 0){
            if($odd_num == 1)
                $r_ks = array(array_rand(self::$odd_array));
            else
                $r_ks = array_rand(self::$odd_array, $odd_num);
            
            $num = count($r_ks);
            for($i=0;$i<$num;$i++)
                $arr[] = self::$odd_array[$r_ks[$i]];
        }
        
        if($even_num > 0){
            if($even_num == 1)
                $r_ks = array(array_rand(self::$even_array));
            else
                $r_ks = array_rand(self::$even_array, $even_num);
            
            $num = count($r_ks);
            for($i=0;$i<$num;$i++)
                $arr[] = self::$even_array[$r_ks[$i]];
        }
        
        sort($arr);
        $r1 = self::create_blue_ball_2($bn);
        $r1 = implode(" ", $r1);
        $r = implode(" ", $arr);
        
        if($set)
            $r = $r . " " . $r1;
        else
            $r = array($r, $r1);

        return $r;
    }
    
    /* 奇偶分析 */
    public static function odd_even_report($s, $set = 0) {
        $r = explode(" ", $s);
        $arr = array(1,1,1,1,1,1,1);
        foreach($r as $k => $v){
            $r[$k] = intval($v);
            if($r[$k] % 2 == 0)
                $arr[$k] = 2;
        }
        
        if($set)
            array_pop($arr);

        return implode(" ", $arr);
    }
    
    public static function create_ssq_array($red_num, $blue_num){
          $r = self::create_red_ball_2($red_num);
          $b = self::create_blue_ball_2($blue_num);
          $r_string = '';
          $b_string = '';
          
          for($i = 0;$i<$red_num;$i++){
              $r_string .= $r[$i] . " ";
          }


          for($i = 0;$i<$blue_num;$i++){
              $b_string .= $b[$i] . " ";
          }

          $r_string = trim($r_string);
          $b_string = trim($b_string);
          return array($r_string, $b_string);
    }

    public static function create_ssq($red_num, $blue_num){
          $r = self::create_red_ball_2($red_num);
          $b = self::create_blue_ball_2($blue_num);
          $string = '';
          
          for($i = 0;$i<$red_num;$i++){
              $string .= $r[$i] . " ";
          }

          $string .= "+ ";

          for($i = 0;$i<$blue_num;$i++){
              $string .= $b[$i] . " ";
          }

          $string = trim($string);
          return $string;
    }





    public static function create_red_ball($num){
      $array = array();
      for($i=1;$i<=$num;$i++)
        array_push($array, self::c_r());
        
      $array = array_unique($array);
      while(count($array) != $num){  //不重复
        array_push($array, self::c_r());
      }
      sort($array);
      return $array;
    }

    public static function create_red_ball_2($num){
      
      srand((float) microtime() * 10000000);
      $array = array();
      $input = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33');
      $rand_keys = array_rand($input, $num);
      
      for($i=0;$i<$num;$i++)
        array_push($array, $input[$rand_keys[$i]]);
      
      return $array;
    }

    public static function create_blue_ball_2($num){
      srand((float) microtime() * 10000000);
      $array = array();
      $input = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16');
      if($num == 1)
        $rand_keys = array(array_rand($input));  //如果是1, 返回的是键名, 非数组
      else 
        $rand_keys = array_rand($input, $num);
      
      for($i=0;$i<$num;$i++)
        array_push($array, $input[$rand_keys[$i]]);
      
      return $array;
    }

    public static function create_blue_ball($num){
      $array = array();
      for($i=1;$i<=$num;$i++)
        array_push($array, self::c_b());
        
      $array = array_unique($array);
      while(count($array) != $num){  //不重复
        array_push($array, self::c_b());
      }
      sort($array);
      return $array;
    }

    public static function c_r(){
      $t = rand(1,33);
      if($t < 10)
          $t = "0" . $t;
      return $t;
    }

    public static function c_b(){
      $t = rand(1,16);
      if($t < 10)
          $t = "0" . $t;
      return $t;
    }
    
    /*
    *  01 02 03 04 05 06 07 | 01 => {(01 02 03 04 05 06 | 01 
                                      01 02 03 04 05 07 | 01
                                      01 02 03 04 06 07 | 01 
                                      .
                                      .
                                      . 
                                      02 03 04 05 06 07 | 01)}
    */
    public static function fj($s, $r_type = 0) {
        $s = trim($s);
        $arr = explode("|", $s);
        $red = explode(",", $arr[0]);
        $blue = explode(",", $arr[1]);
        
        
        $r = array();
        $r2 = array();
        
        for($o=0;$o<count($blue);$o++){
            for($i = 5; $i < count($red); $i++){
                for($j = 4; $j < $i; $j++){
                    for($k = 3; $k < $j; $k++){
                        for($l=2;$l<$k;$l++){
                            for($m=1;$m<$l;$m++){
                                for($n=0;$n<$m;$n++){
                                    
                                    
                                        $r[] = array(
                                                    array($red[$n], $red[$m], $red[$l], $red[$k], $red[$j], $red[$i]),
                                                    array($blue[$o])
                                                    );
                                        $r2[] = $red[$n] . " " . $red[$m]. " " . $red[$l]. " " . $red[$k]. " " . $red[$j]. " " . $red[$i]. " | " . $blue[$o];
                                    
                                }
                            }
                        }
                    }
                }
            }
        }
        
        if($r_type)
            return $r;
        else
            return $r2;
    }
    
    //c(6, 33) = ?
    public static function c($m, $n) {
        
        $c = $n - $m;
        if($c < $m)
            $m = 5;
        $c = $n - $m;
        
        $fm = 1;
        $fz = 1;
        for($i=1;$i<=$m;$i++)
        {
            $fm = $fm * $i;
            }
            
        for($j=$n;$j>$c;$j--){
            $fz = $fz * $j;
        }
        
        $r = $fz / $fm;
        return $r;
    }
    
    
    public static $arr_Count = array();
    
    public static $array = array();
    
    public static $arr_avarage = array();
    
    public static $arr_avarage2 = array();
    
    public static $red_ball = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33');
    
    public static $blue_ball = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16');
    
    public static $odd_array = array('01', '03', '05', '07', '09', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31','33');
    
    public static $even_array = array('02', '04', '06', '08', '10', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32');
    
    public static $red_rate = array();
    
    public static $blue_rate = array();
    
    public static $red_rate_sort = array();
    
    public static $blue_rate_sort = array();
}

/**
 * 分析 大乐透
 */

final class fx_ddt {

    /* 分析 */
    public static function fx() {
        $array = self::$array;
        // $array is a two-dementional array
        $arr_Total = array();
        $arr_ararage = array();
        $arr_ararage2 = array();
        $arr_red_rate = array();
        $arr_blue_rate = array();
        
        $temp1 = 0;
        $temp2 = 0;
        
        for($i = 0; $i < count($array); $i++){
            for($j=0;$j<count($array[$i]);$j++){
                $arr_Total[$j] += $array[$i][$j];
                if($j <= 4){
                    // todo
                    $temp1 = intval($array[$i][$j]);
                    $arr_red_rate[$temp1] += 1;
                }
                else{
                    // todo
                    $temp2 = intval($array[$i][$j]);
                    $arr_blue_rate[$temp2] += 1;
                }
            }
        }
        
        for($k = 0;$k<count($arr_Total);$k++){
            $arr_avarage[$k] = $arr_Total[$k] / $i;
            $arr_avarage2[$k] = round($arr_avarage[$k]);
        }
        

        self::$arr_Count = $arr_Total;
        self::$arr_avarage = $arr_avarage;
        self::$arr_avarage2 = $arr_avarage2;
        
        ksort($arr_red_rate);
        ksort($arr_blue_rate);
        
        self::$red_rate = $arr_red_rate;
        self::$blue_rate = $arr_blue_rate;
        
        asort($arr_red_rate);
        asort($arr_blue_rate);
        
        self::$red_rate_sort = $arr_red_rate;
        self::$blue_rate_sort = $arr_blue_rate;
    }
    
    public function fx_ddt($arr = array()) {
        self::$array = $arr;
    }
    
    public function init() {
        self::fx();
    }
    
    /* 得到  和 */
    public function get_arr_Count() {
        return self::$arr_Count;
    }
    
    /* 得到平均数 */
    public function get_arr_Avarage() {
        return self::$arr_avarage;
    }
    
    /* 得到平均整数 */
    public function get_arr_Avarage2() {
        return self::$arr_avarage2;
    }
    
    /* 得到 红球 频率 */
    public function get_arr_Red_Rate() {
        return self::$red_rate;
    }
    
    /* 得到 红球 频率 并 排序 */
    public function get_arr_Red_Rate_sort() {
        return self::$red_rate_sort;
    }
    
    /* 得到 蓝球 频率 并 排序 */
    public function get_arr_Blue_Rate_sort() {
        return self::$blue_rate_sort;
    }
    
    /* 得到 蓝球 频率 */
    public function get_arr_Blue_Rate() {
        return self::$blue_rate;
    }
    
    /* 输入 待分析数组  */
    public function input_array($arr) {
        self::$array = $arr;
    }
    
    /* 频率 提取 简写 */
    public static function rate_report_string_r_or_b($s, $arr_red, $arr_blue, $z = 'r') {
        $t = self::rate_report($s, $arr_red, $arr_blue);
        $ss = '';
        $c = 0;
        if($z == 'b')
            $c = 1;
        foreach($t[$c] as $k => $v){
            $ss .= $v . " ";
        }
        $ss = trim($ss);
        return $ss;
    }
    
    /* 频率 提取 简写 */
    public static function rate_report_string($s, $arr_red, $arr_blue) {
        $t = self::rate_report($s, $arr_red, $arr_blue);
        $ss = '';
        foreach($t as $k => $v){
            foreach($v as $key => $value){
                $ss .= $value . " ";
            }
        }
        $ss = trim($ss);
        return $ss;
    }
    
    /* 频率 提取 */
    public static function rate_report($s, $arr_red, $arr_blue) {
        $r_array = array();
        $b_array = array();
        $result = array();
        
        $s = trim($s);
        $arr = explode(" ", $s);
        foreach($arr as $key => $value)
            $arr[$key] = intval($value);
        
        foreach($arr_red as $key => $value){
            foreach($arr as $k => $v){
                if($k <= 4){
                    if($key == $v){
                        
                        $r_array[$key] = $value;
                        
                    }
                }
            }
        }
        
        foreach($arr_blue as $key => $value){
            foreach($arr as $k => $v){
                if($k > 4){
                    if($key == $v){
                        $b_array[$key] = $value;
                    }
                }
            }
        }
        
        array_push($result, $r_array, $b_array);
        return $result;
        
    }
    
    /* 随机在分层频率里抽取一个红球 */
    public static function rate_red_seize($arr_red, $num = 6) {
        $array = array_unique($arr_red);
        sort($array);
        //$array2 = array_count_values($arr_red);
        
        $array3 = array();
        
        
        for($i=0;$i<count($array);$i++){
            foreach($arr_red as $r_k => $r_v){
                if($r_v == $array[$i]){
                    $array3[$r_v][] = $r_k;
                }
            }
        }
        
        /* 防止 array_rand 产生随机错误 */
        if(count($array) < $num)
            $num = count($array);
            
        if($num == 1)
            $array4 = array(array_rand($array3));
        else
            $array4 = array_rand($array3, $num);
        //$array4 = array_rand($array3[$array4]);
        $array5 = array();
        
        foreach($array4 as $k => $v){
            $a = array_rand($array3[$v]);
            $array5[] = $array3[$v][$a];
        }
        
        sort($array5);
        //print_r($array3);
        //print_r($array4);
        //print_r($array5);
        foreach($array5 as $k => $v){
            if($v < 10){
                $array5[$k] = "0" . $v;
            }
        }
        
        $r = implode(" ", $array5);
        
        return $r;
        
    }
    
    /* 随机在分层频率里抽取一个蓝球 */
    public static function rate_blue_seize($arr_blue, $num = 1) {
        $array = array_unique($arr_blue);
        sort($array);
        
        //$array2 = array_count_values($arr_red);
        
        $array3 = array();
        
        
        for($i=0;$i<count($array);$i++){
            foreach($arr_blue as $r_k => $r_v){
                if($r_v == $array[$i]){
                    $array3[$r_v][] = $r_k;
                }
            }
        }
        
        /* 防止 array_rand 产生随机错误 */
        if(count($array) < $num)
            $num = count($array);
            
            
            
        if($num == 1)
            $array4 = array(array_rand($array3));
        else
            $array4 = array_rand($array3, $num);
            
            
        //$array4 = array_rand($array3[$array4]);
        $array5 = array();
        
        foreach($array4 as $k => $v){
            $a = array_rand($array3[$v]);
            $array5[] = $array3[$v][$a];
        }
        
        sort($array5);
        //print_r($array3);
        //print_r($array4);
        //print_r($array5);
        foreach($array5 as $k => $v){
            if($v < 10){
                $array5[$k] = "0" . $v;
            }
        }
        
        $r = implode(" ", $array5);
        
        return $r;
        
    }
    
    /* 从某个区间里取几个 */
    public static function rate_seize() {
        $args = func_get_args();
        $arr_red = $args[0];
        $arr_blue = $args[1];
        $red = $args[2];
        $blue = $args[3];
        
        
        $r = array();
        foreach($red as $k => $v){
            $r[] = self::rate_method($arr_red, $k, $v);
        }
        
        $rr = array();
        foreach($r as $v)
            foreach($v as $vv)
                $rr[] = $vv;
        sort($rr);
        
        $r = array();
        foreach($blue as $k => $v)
            $r[] = self::rate_method($arr_blue, $k, $v);
        $r2 = array();
        foreach($r as $v)
            foreach($v as $vv)
                $r2[] = $vv;
        sort($r2);
        
        $rr = implode(" ", $rr);
        $r2 = implode(" ", $r2);
        return array($rr, $r2);
        
    }
    
    /* 从某个区间里取几个 */
    public static function rate_method($arr, $rate, $n) {
        $r = array();
        foreach($arr as $k => $v){
            if($v == $rate){
                if($k < 10)
                    $r[] = '0' . $k;
                else
                    $r[] = $k;
            }
        }
        if($n == 1)
            $r_ks = array(array_rand($r));
        else
            $r_ks = array_rand($r, $n);
        
        $rr = array();
        foreach($r_ks as $v)
            $rr[] = $r[$v];
            
        unset($r);
        sort($rr);
        return $rr;
    }
    
    /* 合并 抽取结果 */
    public static function merge_rate_seize($arr_red, $arr_blue, $n_r = 5, $n_b = 2) {
        $a = self::rate_red_seize($arr_red, $n_r);
        $b = self::rate_blue_seize($arr_blue, $n_b);
        return $a . " " . $b;
    }
    
    
    /* 合并 抽取结果 显示 数组 */
    public static function merge_rate_seize_generate_array($arr_red, $arr_blue, $n_r = 5, $n_b = 2) {
        $a = self::rate_red_seize($arr_red, $n_r);
        $b = self::rate_blue_seize($arr_blue, $n_b);
        return array($a, $b);
    }
    
    /* 匹配 n + m 模式 $arr = { [0] => array('1 2 3 4 5 6 7', '1 2'), [1] => array('2 3 4 5 6 7 8','2 3')} $s = '1 2 3 4 5 6 7' */
    public static function match_n_m($arr, $s) {
        $ss = '';
        $r_arr = array();
        $s = trim($s);
        $arr2 = explode(" ", $s);
        
        //print_r($arr);
        $pp = 0;
        
        
        
        
        foreach($arr as $arr_k => $arr_v){
            $n = 0;    //记录红球相同数
            $bn = 0;   //记录蓝球相同数
            $flag = 0;
            $flag2 = 0;
            $ss = $ss . "[$arr_k] ";
            
            
            
            $temp_arr_red  = explode(" ", $arr_v[0]);
            $temp_arr_blue = explode(" ", $arr_v[1]);
            
            foreach($temp_arr_red as $r_k => $r_v){
                for($j=0;$j<5;$j++){
                    if($r_v == $arr2[$j]){
                        $ss = $ss . "<font color='red'>".$r_v."</font>"." ";
                        $n++;
                        $flag++;
                    }

                }
                if($flag == 0){
                    $ss = $ss . $r_v . " ";
                }
                $flag = 0;
            }
            
            foreach($temp_arr_blue as $b_k => $b_v){
                for($j=5;$j<7;$j++){
                    if($b_v == $arr2[$j]){
                        $ss = $ss . "<font color='blue'>".$b_v."</font>"." ";
                        $bn++;
                        $flag2++;
                    }
                }   
                if($flag2 == 0){
                    $ss = $ss . $b_v . " ";
                }
                $flag2 = 0;
            }
            

            $pp++;
            if($pp % 5 == 0)
                $ss = $ss . "<br />";
            else
                $ss = $ss . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $r_arr[$arr_k][0] = $n;
            $r_arr[$arr_k][1] = $bn;
        }
        
        echo $ss;
        $rr_arr = array();
        $b_arr = array();
        $arr_8 = array();
        $arr_7 = array();
        $arr_6 = array();
        $arr_5 = array();
        $arr_4 = array();
        $arr_3 = array();
        $arr_2 = array();
        $arr_1 = array();

        foreach($r_arr as $k => $v){
            if($v[0] >= 3 && $v[1] >= 1){
                $rr_arr[$k][0] = $v[0];
                $rr_arr[$k][1] = $v[1];
            }
            if($v[1] >= 2){
                $b_arr[$k][0] = $v[0];
                $b_arr[$k][1] = $v[1];
            }
            
            if(($v[0] == 3 && $v[1] == 0) || ($v[0] == 2 && $v[1] == 1) || ($v[0] == 1 && $v[1] == 2) || ($v[0] == 0 && $v[1] == 2)){
                $arr_8[$k][0] = $v[0];
                $arr_8[$k][1] = $v[1];
            }
            if(($v[0] == 3 && $v[1] == 1) || ($v[0] == 2 && $v[1] == 2)){
                $arr_7[$k][0] = $v[0];
                $arr_7[$k][1] = $v[1];
            }
            if(($v[0] == 3 && $v[1] == 2) || ($v[0] == 4 && $v[1] == 0)){
                $arr_6[$k][0] = $v[0];
                $arr_6[$k][1] = $v[1];
            }
            if(($v[0] == 4 && $v[1] == 1)){
                $arr_5[$k][0] = $v[0];
                $arr_5[$k][1] = $v[1];
            }
            if(($v[0] == 4 && $v[1] == 2)){
                $arr_4[$k][0] = $v[0];
                $arr_4[$k][1] = $v[1];
            }
            if(($v[0] == 5 && $v[1] == 0)){
                $arr_3[$k][0] = $v[0];
                $arr_3[$k][1] = $v[1];
            }
            if(($v[0] == 5 && $v[1] == 1)){
                $arr_2[$k][0] = $v[0];
                $arr_2[$k][1] = $v[1];
            }
            if(($v[0] == 5 && $v[1] == 2)){
                $arr_1[$k][0] = $v[0];
                $arr_1[$k][1] = $v[1];
            }
        }
        echo "8等奖:" . count($arr_8) . "  7等奖:" . count($arr_7) . "  6等奖:" . count($arr_6) . "  5等奖:" . count($arr_5) . "  4等奖:" . count($arr_4) . "  3等奖:" . count($arr_3) . "  2等奖:" . count($arr_2) . "  1等奖:" . count($arr_1);
        //print_r($arr_8);
        echo "<br />";
        $total = count($arr_8) * 5 + count($arr_7) * 10 + count($arr_6) * 100 + count($arr_5) * 600 + count($arr_4) * 3000 + count($arr_3) * 50000 + count($arr_2) * 100000 + count($arr_1) * 5000000;
        echo "共计:" . $total;
        echo "<br />";
        echo "红球相同>=3:" . count($rr_arr);
        print_r($rr_arr);
        echo "蓝球相同>=2:" . count($b_arr);
        print_r($b_arr);
        echo "<br />";
        echo "3+0 2+1 1+2 0+2 : 5 ; 3+1 2+2: 10; 3+2 4+0: 100; 4+1: 600; 4+2: 3000; 5+0: 5%; 5+1: 20%; 5+2: 5000000";
        

    }
    
    /* 计算方案获利 */
    public static function total_match_n_m($arr, $s) {
        $ss = '';
        $r_arr = array();
        $s = trim($s);
        $arr2 = explode(" ", $s);
        
        //print_r($arr);
        $pp = 0;
        
        
        
        
        foreach($arr as $arr_k => $arr_v){
            $n = 0;    //记录红球相同数
            $bn = 0;   //记录蓝球相同数
            $flag = 0;
            $flag2 = 0;
            $ss = $ss . "[$arr_k] ";
            
            
            
            $temp_arr_red  = explode(" ", $arr_v[0]);
            $temp_arr_blue = explode(" ", $arr_v[1]);
            
            foreach($temp_arr_red as $r_k => $r_v){
                for($j=0;$j<5;$j++){
                    if($r_v == $arr2[$j]){
                        $ss = $ss . "<font color='red'>".$r_v."</font>"." ";
                        $n++;
                        $flag++;
                    }

                }
                if($flag == 0){
                    $ss = $ss . $r_v . " ";
                }
                $flag = 0;
            }
            
            foreach($temp_arr_blue as $b_k => $b_v){
                for($j=5;$j<7;$j++){
                    if($b_v == $arr2[$j]){
                        $ss = $ss . "<font color='blue'>".$b_v."</font>"." ";
                        $bn++;
                        $flag2++;
                    }
                }   
                if($flag2 == 0){
                    $ss = $ss . $b_v . " ";
                }
                $flag2 = 0;
            }
            

            $pp++;
            if($pp % 5 == 0)
                $ss = $ss . "<br />";
            else
                $ss = $ss . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $r_arr[$arr_k][0] = $n;
            $r_arr[$arr_k][1] = $bn;
        }
        
        
        $rr_arr = array();
        $b_arr = array();
        $arr_8 = array();
        $arr_7 = array();
        $arr_6 = array();
        $arr_5 = array();
        $arr_4 = array();
        $arr_3 = array();
        $arr_2 = array();
        $arr_1 = array();

        foreach($r_arr as $k => $v){
            if($v[0] >= 3 && $v[1] >= 1){
                $rr_arr[$k][0] = $v[0];
                $rr_arr[$k][1] = $v[1];
            }
            if($v[1] >= 2){
                $b_arr[$k][0] = $v[0];
                $b_arr[$k][1] = $v[1];
            }
            
            if(($v[0] == 3 && $v[1] == 0) || ($v[0] == 2 && $v[1] == 1) || ($v[0] == 1 && $v[1] == 2) || ($v[0] == 0 && $v[1] == 2)){
                $arr_8[$k][0] = $v[0];
                $arr_8[$k][1] = $v[1];
            }
            if(($v[0] == 3 && $v[1] == 1) || ($v[0] == 2 && $v[1] == 2)){
                $arr_7[$k][0] = $v[0];
                $arr_7[$k][1] = $v[1];
            }
            if(($v[0] == 3 && $v[1] == 2) || ($v[0] == 4 && $v[1] == 0)){
                $arr_6[$k][0] = $v[0];
                $arr_6[$k][1] = $v[1];
            }
            if(($v[0] == 4 && $v[1] == 1)){
                $arr_5[$k][0] = $v[0];
                $arr_5[$k][1] = $v[1];
            }
            if(($v[0] == 4 && $v[1] == 2)){
                $arr_4[$k][0] = $v[0];
                $arr_4[$k][1] = $v[1];
            }
            if(($v[0] == 5 && $v[1] == 0)){
                $arr_3[$k][0] = $v[0];
                $arr_3[$k][1] = $v[1];
            }
            if(($v[0] == 5 && $v[1] == 1)){
                $arr_2[$k][0] = $v[0];
                $arr_2[$k][1] = $v[1];
            }
            if(($v[0] == 5 && $v[1] == 2)){
                $arr_1[$k][0] = $v[0];
                $arr_1[$k][1] = $v[1];
            }
        }
        
        $total = count($arr_8) * 5 + count($arr_7) * 10 + count($arr_6) * 100 + count($arr_5) * 600 + count($arr_4) * 3000 + count($arr_3) * 50000 + count($arr_2) * 100000 + count($arr_1) * 5000000;
        
        return array($ss, $total);
    }
    
    /* 从 1-10 里抽取 $n1 个 11 - 20 $n2  21 - 30 $n3  31 - 35 $n4 */
    public static function zone_seize($n1, $n2, $n3, $n4, $bn = 2) {
        
        $zone1 = array('01','02','03','04','05','06','07','08','09','10');
        $zone2 = array('11','12','13','14','15','16','17','18','19','20');
        $zone3 = array('21','22','23','24','25','26','27','28','29','30');
        $zone4 = array('31','32','33','34','35');
        
        if($n1 > 0)
            if($n1 == 1)
                $rand_keys_1 = array(array_rand($zone1, $n1));
            else
                $rand_keys_1 = array_rand($zone1, $n1);
        
        if($n2 > 0)
            if($n2 == 1)
                $rand_keys_2 = array(array_rand($zone2, $n2));
            else
                $rand_keys_2 = array_rand($zone2, $n2);
            
        if($n3 >0)    
            if($n3 ==1 )
                $rand_keys_3 = array(array_rand($zone3, $n3));
            else
                $rand_keys_3 = array_rand($zone3, $n3);
                
        if($n4 > 0)
            if($n4 == 1)
                $rand_keys_4 = array(array_rand($zone4, $n4));
            else
                $rand_keys_4 = array_rand($zone4, $n4);
        
        $r = array();
        for($i=0;$i<$n1;$i++)
            array_push($r, $zone1[$rand_keys_1[$i]]);
        

        for($i=0;$i<$n2;$i++)
            array_push($r, $zone2[$rand_keys_2[$i]]);
            

        for($i=0;$i<$n3;$i++)
            array_push($r, $zone3[$rand_keys_3[$i]]);
            

        for($i=0;$i<$n4;$i++)
            array_push($r, $zone4[$rand_keys_4[$i]]);
        
        $r = implode(" ", $r);
        $r1 = self::create_blue_ball_2($bn);
        $r1 = implode(" ", $r1);
        
        $r = array($r, $r1);
        
        
        
        return $r;
    }
    
    
    /* 对 1 - 10 11-20 21-30 31-35 里 报告在几个落入该区间 */
    public static function zone_report($s, $set = 0) {
        $r = explode(" ", $s);
        $n1 = 0;
        $n2 = 0;
        $n3 = 0;
        $n4 = 0;
        $n5 = 0;
        $n6 = 0;
        foreach($r as $k => $v){
            $r[$k] = intval($v);
            if($k <= 4){
                
                if($r[$k] < 11)
                    $n1++;
                if($r[$k] > 10 && $r[$k] < 21)
                    $n2++;
                if($r[$k] > 20 && $r[$k] < 31)
                    $n3++;
                if($r[$k] > 30)
                    $n4++;
            }
            if($k > 4){
                if($r[$k] < 11)
                    $n5++;
                if($r[$k] > 10)
                    $n6++;
            }
            
        }
        if($set)
            $r = $n1.$n2.$n3.$n4;
        else
            $r = $n1 . " " . $n2 . " " . $n3 . " " . $n4 . " " . $n5 . " " . $n6 . " ";
        return $r;
    }
    
    /* 01 02 03 04 05 06 07 => 01,02,03,04,05|06,07 */
    public static function format_array($r) {
        for($i=0;$i<count($r);$i++){
            $temp1 = explode(" ", $r[$i][0]);
            $temp2 = implode(",", $temp1);
            $temp3 = explode(" ", $r[$i][1]);
            $temp4 = implode(",", $temp3);
            $temp5 = $temp2 . "|" . $temp4;
            
            $r2[] = $temp5;
        }

        foreach($r2 as $k => $v)
            echo $v . "<br />";
    }
    
    /* array(01 02 03 04 05 06 07) => array(array(), array()) */
    public static function format_to_two_array($r) {
        $rr = array();
        foreach($r as $k => $v){
            $t = explode(" ", $v);
            $t1 = '';
            $t2 = '';
            
            foreach($t as $t_k => $t_v){
                if($t_k <= 4){
                    $t1 .= $t_v . " ";
                }
                if($t_k > 4){
                    $t2 .= $t_v . " ";
                }
            }
            $t1 = trim($t1);
            $t2 = trim($t2);
            $rr[] = array($t1, $t2);
        }
        
        return $rr;
    }
    
    /* 返回$odd_num个奇数 $even_num个偶数的数组 array('08 09 10 11 12', '01 02') */
    public static function odd_even_seize($odd_num, $even_num, $bn = 2) {
        $r = array();
        if($odd_num > 0){
            if($odd_num == 1)
                $r_kz = array(array_rand(self::$odd_array));
            else
                $r_kz = array_rand(self::$odd_array, $odd_num);
            foreach($r_kz as $v){
                $r[] = self::$odd_array[$v];
            }
        }
        
        if($even_num > 0){
            if($even_num == 1)
                $r_kz = array(array_rand(self::$even_array));
            else
                $r_kz = array_rand(self::$even_array, $even_num);
            
            foreach($r_kz as $v){
                $r[] = self::$even_array[$v];
            }
        }
        sort($r);
        $r = implode(" ", $r);
        $r1 = self::create_blue_ball_2($bn);
        $r1 = implode(" ", $r1);
        return array($r, $r1);
        
    }
    
    /* 奇偶分析 */
    public static function odd_even_report($s) {
        $r = explode(" ", $s);
        $arr = array(1,1,1,1,1,1,1);
        foreach($r as $k => $v){
            $r[$k] = intval($v);
            if($r[$k] % 2 == 0)
                $arr[$k] = 2;
        }
        
        return implode(" ", $arr);
    }
    
    
    public static function create_ddt_array($red_num, $blue_num){
      $r = self::create_red_ball_2($red_num);
      $b = self::create_blue_ball_2($blue_num);
      $r_string = '';
      $b_string = '';
      
      for($i = 0;$i<$red_num;$i++){
          $r_string .= $r[$i] . " ";
      }


      for($i = 0;$i<$blue_num;$i++){
          $b_string .= $b[$i] . " ";
      }

      $r_string = trim($r_string);
      $b_string = trim($b_string);
      return array($r_string, $b_string);
    }


    public static function create_ddt($red_num, $blue_num){
      $r = self::create_red_ball_2($red_num);
      $b = self::create_blue_ball_2($blue_num);
      $string = '';
      
      for($i = 0;$i<$red_num;$i++){
          $string .= $r[$i] . " ";
      }

      $string .= "+ ";

      for($i = 0;$i<$blue_num;$i++){
          $string .= $b[$i] . " ";
      }

      $string = trim($string);
      return $string;
    }




    public static function create_red_ball_2($num){
      
      srand((float) microtime() * 10000000);
      $array = array();
      $input = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35');
      $rand_keys = array_rand($input, $num);
      
      for($i=0;$i<$num;$i++)
        array_push($array, $input[$rand_keys[$i]]);
      
      return $array;
    }

    public static function create_blue_ball_2($num){
      srand((float) microtime() * 10000000);
      $array = array();
      $input = array('01','02','03','04','05','06','07','08','09','10','11','12');
      if($num == 1)
        $rand_keys = array(array_rand($input));  //如果是1, 返回的是键名, 非数组
      else 
        $rand_keys = array_rand($input, $num);
      
      for($i=0;$i<$num;$i++)
        array_push($array, $input[$rand_keys[$i]]);
      
      return $array;
    }
    
    
    public static $arr_Count = array();
    
    public static $array = array();
    
    public static $arr_avarage = array();
    
    public static $arr_avarage2 = array();
    
    public static $red_ball = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35');
    
    public static $blue_ball = array('01','02','03','04','05','06','07','08','09','10','11','12');
    
    public static $odd_array = array('01', '03', '05', '07', '09', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31','33','35');
    
    public static $even_array = array('02', '04', '06', '08', '10', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '34');
    
    public static $red_rate = array();
    
    public static $blue_rate = array();
    
    public static $red_rate_sort = array();
    
    public static $blue_rate_sort = array();
}

final class fx_pl3 {
    /* $arr = array('098', '234') */
    public static function match($arr, $s) {
        $bz = self::chai($s);
        $string = '';
        $count = 0;
        $sum = array();
        
        foreach($arr as $k => $v){
            $ar = self::chai($v);
            $n = 0;
            
            $string .= "[" . $k . "]";
            
            foreach($ar as $ar_k => $ar_v){
                
                $count++;
                if($ar[$ar_k] == $bz[$ar_k]){
                    $string .= "<font color='red'>" . $ar[$ar_k] . "</font>";
                    $n++;
                }
                else
                    $string .= $ar[$ar_k];
                    
                
            }    
            if($n == 3)
                $sum[$k] = implode($ar);
            $n=0;
            $string .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($count % 8 == 0)
                $string .= "<br />";
        }
        
        echo $string;
        echo "<br />";
        echo "中奖" . count($sum) . ":";
        echo "<br />";
        echo "奖金:" . count($sum) * 1000;
        echo "<br />";
        print_r($sum);
    }
    
    public static function format_array($arr) {
        $s = "";
        foreach($arr as $k => $v){
            $s .= $v . "<br />";
        }
        
        return $s;
    }
    
    /* 得到一个数 其中奇数已确定其位置 */
    public static function odd_even_s_seize($n1, $n2, $n3) {
        $r = array();
        if($n1 == 1)
            $r[] = self::get_odd();
        else
            $r[] = self::get_even();
        
        if($n2 == 1)
            $r[] = self::get_odd();
        else
            $r[] = self::get_even();
            
        if($n3 == 1)
            $r[] = self::get_odd();
        else
            $r[] = self::get_even();
            
        $r = implode($r);
        return $r;
    }
    
    /* 得到一个三位数中奇数为 $n个 的数 */
    public static function odd_even_seize($odd) {
        
        $r = array();
        
        if($odd == 0){  //0个奇数 3个偶数
            $r[] = self::get_even();
            $r[] = self::get_even();
            $r[] = self::get_even();
            shuffle($r);
            
        }
        elseif($odd == 1){
            $r[] = self::get_odd();
            $r[] = self::get_even();
            $r[] = self::get_even();
            shuffle($r);
        }
        elseif($odd == 2){
            $r[] = self::get_odd();
            $r[] = self::get_odd();
            $r[] = self::get_even();
            shuffle($r);
        }
        elseif($odd == 3){
            $r[] = self::get_odd();
            $r[] = self::get_odd();
            $r[] = self::get_odd();
            shuffle($r);
        }
        
        
        $r = implode($r);
        return $r;
        
    }
    
    /* 奇数报告 */
    public static function odd_even_report($n) {
        $odd = 0;
        $arr = str_split($n);
        foreach($arr as $k => $v){
            if(self::odd_even($arr[$k]))
                $odd++;
        }
        return $odd;
    }
    
    public static function odd_even_s_report($n) {
        $arr = str_split($n);
        $r = array();
        foreach($arr as $k => $v){
            $r[] = self::odd_even($v);
        }
        $r = implode($r);
        return $r;
    }
    
    public static function odd_even($n) {
        if($n % 2 == 0)
            return 0;
        else
            return 1;
    }
    public static function big_small_s_seize($n1, $n2, $n3) {
        $r = array();
        if($n1 == 1)
            $r[] = self::get_big();
        else
            $r[] = self::get_small();
            
        if($n2 == 1)
            $r[] = self::get_big();
        else
            $r[] = self::get_small();
        if($n3 == 1)
            $r[] = self::get_big();
        else
            $r[] = self::get_small();
        
        $r = implode($r);
        return $r;
    }
    
    public static function big_small_seize($big) {
        $r = array();
        if($big == 0){
            $r[] = self::get_small();
            $r[] = self::get_small();
            $r[] = self::get_small();
        }
        elseif($big == 1){
            $r[] = self::get_big();
            $r[] = self::get_small();
            $r[] = self::get_small();
            shuffle($r);
        }
        elseif($big == 2){
            $r[] = self::get_big();
            $r[] = self::get_big();
            $r[] = self::get_small();
            shuffle($r);
        }
        elseif($big == 3){
            $r[] = self::get_big();
            $r[] = self::get_big();
            $r[] = self::get_big();
            shuffle($r);
        }
        
        $r = implode($r);
        return $r;
            
    }
    
    public static function big_small_report($n) {
        $big = 0;
        $arr = str_split($n);
        foreach($arr as $v){
            if(self::big_small($v))
                $big++;
        }
        return $big;
    }
    public static function big_small_s_report($n) {
        $arr = str_split($n);
        $r = array();
        foreach($arr as $k => $v){
            $r[] = self::big_small($v);
        }
        $r = implode($r);
        return $r;
    }
    
    public static function big_small($n) {
        if($n >= 5)
            return 1;
        else
            return 0;
    }
    
    public static function get_big() {
        return rand(5,9);
    }
    
    public static function get_small() {
        return rand(0,4);
    }
    
    public static function range_fx($s) {
        $arr = str_split($s);
        $r = array(0,0,0,0,0,0,0,0,0,0);
        foreach($arr as $k => $v){
            foreach($r as $kk => $vv){
                if($kk == $v)
                    $r[$kk]++;
            }
        }
        return $r;
    }
    
    public static function odd_even_report_fx($s) {
        $arr = str_split($s);
        $r = array(0,0,0,0);
        foreach($arr as $k => $v){
            foreach($r as $kk => $vv){
                if($kk == $v)
                    $r[$kk]++;
            }
        }
        return $r;
    }
    
    public static function sum_report($s) {
        return array_sum($s);
    }
    
    /* 输出和值为 $sum 的所有三位数 */
    public static function sum_seize($sum) {
        $r = array();
        for($i=0;$i<1000;$i++){
            $n = $i;
            if($n < 100 && $n > 9)
                $n = "0" . $n;
            if($n < 10)
                $n = "00" . $n;
            
            $arr = str_split($n);
            if(array_sum($arr) == $sum){
                $r[] = $n;
            }
        }
        
        return $r;
    }
    
    /* 得到一个和值为$sum的随机数 */
    public static function get_sum_seize($sum) {
        $r = self::sum_seize($sum);
        return $r[array_rand($r)];
    }
    
    
    public static function get_range_seize($range) {
        $r = self::range_seize($range);
        return $r[array_rand($r)];
    }
    public static function range_seize($range) {
        $r = array();
        for($i=0;$i<1000;$i++){
            $n = $i;
            if($n < 100 && $n > 9)
                $n = "0" . $n;
            if($n < 10)
                $n = "00" . $n;
            
            $arr = str_split($n);
            if(self::array_range($arr) == $range){
                $r[] = $n;
            }
        }
        
        return $r;
    }
    
    public static function array_range($arr) {
        sort($arr);
        $t = $arr[2] - $arr[0];
        return $t;
    }
    
    /*  得到一个奇数 */
    public static function get_odd() {
        $k = array_rand(self::$odd_array);
        return self::$odd_array[$k];
    }
    
    public static function get_even() {
        $k = array_rand(self::$even_array);
        return self::$even_array[$k];
    }
    
    /* 098 => array(0,9,8) */
    public static function chai($n) {
        $r = str_split($n);
        return $r;
    }
    
    public static function create_pl3() {
        $t = rand(0,999);
        if($t < 100 && $t > 9)
            $t = "0" . $t;
        if($t < 10)
            $t = "00" . $t;
        return $t;
    }
    
    public static $odd_array =  array('1','3','5','7','9');
    public static $even_array = array('0', '2', '4', '6', '8');
}



/**
 * 计时器对象
 */
final class timer {
    public static function get_date() {
        return date('Y-m-d', (int)self::$microtime);
    }
    public static function get_time() {
        return date('H:i:s', (int)self::$microtime);
    }
    public static function get_datetime() {
        return date('Y-m-d H:i:s', (int)self::$microtime);
    }
    public static function get_stamp() {
        return (int)self::$microtime;
    }
    public static function get_micro_stamp() {
        return self::$microtime;
    }
    public static function init() {
        self::$microtime = microtime(true);
    }
    private static $microtime = 0.00;
    
    public static function format_datetime($format,$time){
        $date_time_string = $time;
        // 将字符串分解成3部分－日期、时间和上午/下午   
        $dt_elements = explode(" " , $date_time_string);   
        // 分解日期   
        $date_elements = explode("-" , $dt_elements[0]);   
        // 分解时间   
        $time_elements = explode(":" , $dt_elements[1]);
        // 如果是下午，我们将时间增加12小时以便得到24小时制的时间   
        //if ($dt_elements[2]== "PM") {$time_elements[0]+=12;}   
        // 输出结果   
        $timestamp = mktime ($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);
        //$timestamp = time();
        //$timestamp = mktime(0,0,0,5,27,2000);
        /*
        $date_time_array = getdate(time());   
        $hours = $date_time_array[ "hours"];   
        $minutes = $date_time_array["minutes"];   
        $seconds = $date_time_array[ "seconds"];   
        $month = $date_time_array["mon"];   
        $day = $date_time_array["mday"];   
        $year = $date_time_array["year"];  
        $timestamp = mktime($hours ,$minutes, $seconds,$month ,$day,$year); 
        */
        return date($format, $timestamp);
    }
}
?>
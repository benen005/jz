<?php 

/* 为目录服务 */
if (DIRECTORY_SEPARATOR === '\\') {
    define('root_dir', str_replace('\\', '/', dirname(__DIR__)));
} else {
    define('root_dir', dirname(__DIR__));
}

    function create_red_ball_2($num){
      
      srand((float) microtime() * 10000000);
      $array = array();
      $input = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33');
      $rand_keys = array_rand($input, $num);
      
      for($i=0;$i<$num;$i++)
        array_push($array, $input[$rand_keys[$i]]);
      
      sort($array);
      
      return $array;
    }

    function create_blue_ball_2($num){
      srand((float) microtime() * 10000000);
      $array = array();
      $input = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16');
      if($num == 1)
        $rand_keys = array(array_rand($input));  //如果是1, 返回的是键名, 非数组
      else 
        $rand_keys = array_rand($input, $num);
      
      for($i=0;$i<$num;$i++)
        array_push($array, $input[$rand_keys[$i]]);
      sort($array);
      
      return $array;
    }
    
    
    function create_ssq_array($red_num, $blue_num){
          $r = create_red_ball_2($red_num);
          $b = create_blue_ball_2($blue_num);
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
    
    
    function match_n_m($arr, $s) {
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
            if($pp % 1 == 0)
                $ss = $ss . "<br />";
            else
                $ss = $ss . "&nbsp;&nbsp;&nbsp;&nbsp;";
            $r_arr[$arr_k][0] = $n;
            $r_arr[$arr_k][1] = $bn;
        }
        
        
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
        
        echo "[6等奖:" . count($arr_6) . "]  [5等奖:" . count($arr_5) . "]  [4等奖:" . count($arr_4) . "]  [3等奖:" . count($arr_3) . "]  [2等奖:" . count($arr_2) . "]  [1等奖:" . count($arr_1)."]";
        echo "<br />";
        $total = count($arr_6) * 5 + count($arr_5) * 10 + count($arr_4) * 200 + count($arr_3) * 3000 + count($arr_2) * 300000 + count($arr_1) * 5000000;
        echo "共计奖金:" . $total . "元";
        echo "<br />";
        echo "红球相同数>=5" . "<br />";
        echo "红球相同: " . count($rr_arr). "组 ";
        foreach($rr_arr as $k => $v){
            echo "[$k] (";
            $i = 1;
            foreach($v as $vv){
                if($i % 2 == 0)
                    echo "+";
                echo "$vv";
                $i++;
            }
            echo ") ";
        }
        //print_r($rr_arr);
        echo "<br />";
        echo "蓝球相同: " . $blue_num . "组 ";
        foreach($array_blue as $k => $v)
            echo "[$v] ";
        //print_r($array_blue);
        echo "<br /><br />";
        
        echo $ss;
    }
    
    function format_array($r) {
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
    
    
    function fj($s, $r_type = 0) {
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
    function c($m, $n) {
        
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
    
    
    function jl($file, $c) {
        
        $fp = fopen($file, 'w');
        if($fp !== false){
            flock($fp, LOCK_EX);
            
            //$f = file($read_file);
 
            
            fwrite($fp, $c);

            
            flock($fp, LOCK_UN);
            fclose($fp);
            
            
        }
        
    }
    
    function jl_array($file, $c) {
        
        $fp = fopen($file, 'w');
        if($fp !== false){
            flock($fp, LOCK_EX);
            
            //$f = file($read_file);
 
            foreach($c as $k => $v){
                fwrite($fp, $v);
            }

            flock($fp, LOCK_UN);
            fclose($fp);
            
            
        }
        
    }
    
    function add($file, $c) {
        
        $fp = fopen($file, 'a');
        if($fp !== false){
            flock($fp, LOCK_EX);
            
            //$f = file($read_file);
 
            
            fwrite($fp, $c . ' (' . date('Y-m-d H:i:s').')<br />');

            
            flock($fp, LOCK_UN);
            fclose($fp);
            
            
        }
        
    }
    
    

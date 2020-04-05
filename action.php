<?php 

include_once('include/config.php');
include_once('include/conn.class.php');
include_once('include/base.php');



$action = g('action', null);

if($action == 'jz_edit'){
    jz_edit($id);
}elseif($action == 'jz_add'){
    jz_add();
}elseif($action == 'jz_del'){
    jz_del($id);
}

function jz_edit($id){
    extract($_POST);
    
    $sql = "update jz_danzi set jz_date = '".$date."', jz_name='".$name."', jz_bet='".$bet."', jz_win='".$win."' where id = $id";
    sqli($sql);
    echo "{type:1, time:'" . date('Y m d H:i:s') . "'}";
}

function jz_add(){
    extract($_POST);
    $sql = "INSERT INTO `jz_danzi` (`jz_date`, `jz_name`, `jz_bet`, `jz_win`, `pubtime`) VALUES ('$date', '$name','$bet', '$win', now())";
    sqli($sql);
    header("location: tz.php");
    exit;
}

function jz_del($id){
    extract($_POST);
    $sql = "delete from jz_danzi where id = $id";
    sqli($sql);
    echo "{type:1, time:'" . date('Y m d H:i:s') . "'}";
}

function get_table($num = 20){
    if($num)
        $sql = "select * from jz_danzi order by id desc limit 0,$num";
    else
        $sql = "select * from jz_danzi order by id desc";
    $r = sql($sql);
    if($r){
        echo "<table class='jz_table'>";
        echo "<tr>";
        echo "<th>日期</th>";
        echo "<th>单子</th>";
        echo "<th>下注</th>";
        echo "<th>奖金</th>";
        echo "</tr>";
        foreach($r as $k => $v){
            $tmp = "";
            if($v['jz_win'])
                $tmp = "class='just_red'";
            
            echo "<tr $tmp>";
            echo "<td $tmp>" . $v['jz_date'] . "</td>";
            echo "<td $tmp>" . $v['jz_name'] . "</td>";
            echo "<td $tmp>" . $v['jz_bet'] . "</td>";
            echo "<td $tmp>" . $v['jz_win'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
     }
}


?>
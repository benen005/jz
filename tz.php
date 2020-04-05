<?php include_once('action.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="竞彩足球预测" />
<meta name="description" content="竞彩足球预测" />
<title>竞彩足球预测 - 投注</title>
<link rel="stylesheet" href="style/css.css" type="text/css" media="all" />
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/js.js" type="text/javascript"></script>
</head>
<body>
<form action="action.php?action=jz_add" name="form1" method="post" >
<table class='jz_table'>
    <tr>
    <td><input name="date" class="g" /></td>
    <td><input name="name" class="h" /></td>
    <td><input name="bet" class="g" /></td>
    <td><input name="win" class="g" /></td>
    <td><input name="submit" type="submit" value="提交" /></td>
    </tr>
</table>
</form>
<div id="result"></div>
<?php 
    $sql = "select * from jz_danzi order by id desc";
    $r = sql($sql);
    if($r){
        echo "<table class='jz_table'>";
        echo "<tr>";
        echo "<th>日期</th>";
        echo "<th>单子</th>";
        echo "<th>下注</th>";
        echo "<th>奖金</th>";
        echo "<th>操作</th>";
        echo "</tr>";
        $i = 0;
        foreach($r as $k => $v){
            $i++;
            echo "<tr>";
            echo "<td><input id='date$i' name='date$i' value='" . $v['jz_date'] . "' class='g' /></td>";
            echo "<td><input id='name$i' name='name$i' value='" . $v['jz_name'] . "' class='h' /></td>";
            echo "<td><input id='bet$i' name='bet$i' value='" . $v['jz_bet'] . "' class='g' /></td>";
            echo "<td><input id='win$i' name='win$i' value='" . $v['jz_win'] . "'class='g' /></td>";
            echo "<td><a href='#' id='modify_$i' class='modify' m='$i'>修改</a> <input type='hidden' id='id$i' value='" . $v['id'] . "' /><a href='#' id='del_$i' class='del' m='$i' >删除</a></td>";
            echo "</tr>";
        }
        echo "</table>";
     }
?>



</body></html>
<script>
$(document).ready(function(){
    $('.modify').click(function(o){
        var i = $(this).attr('m');
        var date = $('#date' + i).val();
        var name = $('#name' + i).val();
        var bet = $('#bet' + i).val();
        var win = $('#win' + i).val();
        var id = $('#id' + i).val();
        
        $.ajax({
            type:'post',
            url:'action.php?action=jz_edit',
            data:'date=' + date +'&t=' + get_time()+'&name=' + name +'&bet=' + bet +'&win=' + win +'&id=' + id,
            dataType:'json',
            success:function(msg){
             if(msg.type==1)
                $('#result').html('<font color=red>'+msg.time+'写入成功</font>');
             else
                $('#result').html('<font color=red>'+'未写入</font>');
            },
            error:function(){
                $('#result').html('<font color=red>'+'失败</font>');
            }
        });
    });
    
    $('.del').click(function(o){
        var r = confirm("确认删除?");
        if(r){
            var i = $(this).attr('m');
            var id = $('#id' + i).val();
            
            $.ajax({
                type:'post',
                url:'action.php?action=jz_del',
                data:'t=' + get_time() +'&id=' + id,
                dataType:'json',
                success:function(msg){
                 if(msg.type==1)
                    $('#result').html('<font color=red>'+msg.time+'删除成功</font>');
                 else
                    $('#result').html('<font color=red>'+'未写入</font>');
                },
                error:function(){
                    $('#result').html('<font color=red>'+'失败</font>');
                }
            });
        }
    });



});

function get_time(){
    var d = new Date();
    return d.getTime();
} 
</script>
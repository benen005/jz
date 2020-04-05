<html>
<head>
<title>竞彩足球 - 录入</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<style type="text/css">
    textarea{width:500px; height: 300px; border: 1px dotted red;}
    #div2{width:500px; height: 300px; border: 1px dotted red;display:inline;}
    
    .match{float:left;display:block;width:860px;border:0px solid #000;text-align:center;}
    .show{float:left;display:block;width:850px;border:0px dotted #000;}
    .num{float:left;display:block;width:50px;border:1px dotted #000;}
    .country{float:left;display:block;width:250px;border:1px dotted #000;}
    .pl{float:left;display:block;width:150px;border:1px dotted #000;text-align:center;}
    
    .select{width:50px;float:left;display:block;background:yellow;cursor:pointer;}
</style>
</head>
<body>
<div id="div1" style="border:1px solid #000;">
    <p>1</p>
</div>
<?php 

$date = $_GET['date'];
if($date)
	$file = 'txt_' . $date . '_recommend_1.txt';
else{
    $date = date('Ymd');
	$file = 'txt_' . $date . '_recommend_1.txt';
}
    
$file = 'txt/'.$file;
$content = file_get_contents($file);
?>
<p style="display: none; border:1px dotted red; width:100px; ">写入比赛</p>
<div id="time">输入日期: <input name="date1" id="date1" value="<?php echo $date; ?>" /></div>

<!-- 写入比赛 -->
<div class="match">
<?php 
    $file2 = 'txt_' . $date . '.txt';
    $file2 = 'txt/' . $file2;
    $context2 = file($file2);
    
    match_render($context2);
?>
<div id="show_match"></div>
</div>
<?php
function match_render($arr){
    $str = "";
    $n = count($arr);
    for($i=0;$i<$n;$i=$i+7){
        $num[] = $arr[$i];
        $match[] = $arr[$i+1];
        $update[] = $arr[$i+2];
        $match1[] = $arr[$i+3];
        $match2[] = $arr[$i+4];
        $pl1[] = $arr[$i+5];
        $pl2[] = $arr[$i+6];  
    }
    $n2 = count($num);
    for($i=0;$i<$n2;$i++){
        $str .="<div class='show'>";
        $str .= "<div class='num'>$num[$i]</div>";
        $str .= "<div class='num'>$match[$i]</div>";
        $str .= "<div class='num'>$update[$i]</div>";
        $str .= "<div class='country'>$match1[$i] $match2[$i]</div>";
        $str .= "<div class='pl' m='1' n='".substr($pl2[$i], 0, 2)."'>" . pl(substr($pl1[$i], 2)) . "</div>";
        if(strlen(trim(substr($pl2[$i], 0, 2))) == "1")
            $tmp = "＋" . trim(substr($pl2[$i], 0, 2));
        else
            $tmp = "—" . trim(substr($pl2[$i], 1, 1));
        $str .= "<div class='pl' m='2' n='".$tmp."'>" . pl(substr($pl2[$i], 2)) . "</div>";
        $str .="</div>";
    }
    echo $str;
}

function pl($str){
    $str = explode(" ", $str);
    return "<div class='select'>$str[0]</div>" . "<div class='select'>$str[1]</div>" . "<div class='select'>$str[2]</div>";
}
?>
<!-- 写入比赛 end-->
<div id="div_text">
    <textarea id="text1"><?php echo $content; ?></textarea>
    <textarea id="text2"><?php echo $content; ?></textarea>
    <input type="button" name="btn1" value="写入" onclick="a();" />
</div>
<div id="result"></div>
<div id="result2"></div>
</body>
</html>

<script language="javascript">
var fb = 0;
var times = 2000;
var border = 0;


$(document).ready(function(){
    var str = "";
    $('.select').click(function(){
        var num = $(this).parents().parents().children().html();
        var match =$(this).parents().parents().children().next().next().next().html();
        var pl = '';
        var prev = $(this).prev().html();
        var next = $(this).next().html();
        var rq = '';

        if($(this).parents().attr('m') == "2") //如果是让球
            rq = ' 让'+$(this).parents().attr('n')+' ';

        if(prev == null)   //如果是第一个
            pl = "<span class='red'>" + $(this).html() + "</span> " + $(this).next().html() + " " + $(this).next().next().html();
        else{
            if(next == null){  //如果是最后一个
                pl = $(this).prev().prev().html() + " " + $(this).prev().html() + " <span class='red'>" + $(this).html() + "</span>";
            }
            else{  //如果是中间一个
                pl = $(this).prev().html() + " <span class='red'>" + $(this).html() + "</span> " + $(this).next().html();
            }
        }
        str += "<p class='p2'>" + num + match + rq + pl + "</p>";
        $('#text1').val(str);
    });
    $('.select').toggle(function(){
        $(this).css('background', 'pink');
        $('#show_match').html($(this).parents().parents().html());
    },
    function(){
        $(this).css('background', 'yellow');
        $('#show_match').html('');
    });
    
    $('#result2').html($(document).height() + ' ' + $(document).width() + ' ' + $(this).height() + ' ' + $(this).scrollTop());
    
    
    

    $("#text1").keydown(function(){
        $("#text2").val(this.value);
    });

    
    $("#div1").css("border", "1px dotted #000");
 
     $("#div1").each(function(i){
        this.innerHTML="border:1px dotted #000";
    });

    $("p").show('fast');
  

    //a();
    
    
});


function get_time(){
    var d = new Date();
    return d.getTime();
}  

function a(){


    //$("img").get().reverse();
        
    var date = $('#date1').val();
    
    $.ajax({
        type:'post',
        url:'j_edit.php',
        data:'content=' + $("#text1").val()+'&t=' +get_time()+'&date='+date,
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
    }) 
}

  
  
</script>
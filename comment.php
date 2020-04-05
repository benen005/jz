<html>
<head>
<title>竞彩足球 - 修改评论</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<style type="text/css">
    textarea{width:500px; height: 300px; border: 1px dotted red;}
    #div2{width:500px; height: 300px; border: 1px dotted red;display:inline;}
</style>
</head>
<body>
<div id="div1" style="border:1px solid #000;">
    <p>1</p>
</div>
<?php 
$date = date('Ymd');
$file = 'write.txt';
$content = file_get_contents($file);
?>
<p style="display: none; border:1px dotted red; width:100px; ">Hello2</p>
<div id="time">输入日期: <input name="date1" id="date1" value="<?php echo $date; ?>" /></div>
<img/><img/>
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
var arr = ["./phpex/Tests/images/paid.png", "./phpex/Tests/images/phpexcel_logo.gif"];

$(document).ready(function(){

    $('#result2').html($(document).height() + ' ' + $(document).width() + ' ' + $(this).height() + ' ' + $(this).scrollTop());
    
    
    
    //$("textarea").css("width", "500px");
    //$("textarea").css("height", "300px");
    $("#text1").keydown(function(){
        
        $("#text2").val(this.value);
    });
    
    //$("<div><p>Hello</p></div>").appendTo("body");
    //$("<input type='checkbox' value='ok'>").appendTo("body");
    
    arr.reverse();
    $("img").each(function(i){
       this.src = arr[i];
     });
    
    //$(document.body).css( "background", "white" );
    


    
    $("#div1").css("border", "1px dotted #000");
 
     $("#div1").each(function(i){
        this.innerHTML="border:1px dotted #000";
    });

    $("p").show('fast');
  

    
    
    
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
        url:'j_comment.php',
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
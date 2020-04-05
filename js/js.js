$(document).ready(function(){
    
   $('#btn_recommend').click(function(){
        var secret = 9898;
       if($('#btn_secret').val() == secret){
            $.ajax({
                type:'post',
                url:'j_recommend.php',
                data:'content=' + $('#div_recommend').html() +'&t=' + get_time()+'&type=' + $('#recommend_type').val(),
                dataType:'json',
                success:function(msg){
                 if(msg.type==1)
                     $('.recommend_btn').html('推荐成功');
                    //$('#result').html('<font color=red>'+msg.time+'写入成功</font>');
                 else
                    $('.recommend_btn').html('推荐失败');
                    //$('#result').html('<font color=red>'+'未写入</font>');
                },
                error:function(){
                    $('.recommend_btn').html('服务器错误');
                    //$('#result').html('<font color=red>'+'失败</font>');
                }
            });
        }
        else
            alert("你输入的推荐码不正确");
       
    });
    
    $('#ql_ad').hover(
        function(){
            $('#text_h').fadeIn(500);
        }
    );
        
        
    $('#show_settings').toggle(
        function(){
            $('#text3').css('display', 'block');
        },
        function(){
            $('#text3').css('display', 'none');
            
        }
    );
    
});

function get_time(){
    var d = new Date();
    return d.getTime();
}  
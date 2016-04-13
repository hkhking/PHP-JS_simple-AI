/* 
 * IM系统测试
 * hkhking hkhking@outlook.com
 * 2014-12-29
 */
var email="USER";
$(document).ready(function(){
     $.post("../control/AnswerApi.php",{"act":1},function(res){
         var a="<li><label>请选择以下产品线：</label><br/>";
         if(res.data.email!=null){
             email=res.data.email;
         }
         $.each(res.data.list,function(idx,obj) {
                   a=a+idx+".<a href='###' class='productChoose'>"+obj+"</a><br/>";
            }); 
           a=a+"</li>";
         $("#flag").before(a);
     },"json");
     
     $("#text").on("click",".productChoose",function(){
         var a=this.text;
         $("#flag").before("<p>"+a+":<span>"+email+"<span></p>");
         $.post("../control/AnswerApi.php",{"act":6,"word":a},function(res){
             var b="<li><label>请问有什么需要帮助的？</label><br/>";
             if(res.data!=false){
                 $.each(res.data,function(idx,obj) {
                   b=b+idx+".<a href='###' class='questionChoose'>"+obj+"</a><br/>";
                    }); 
                   b=b+"</li>";
             }
             $("#flag").before(b);
             $("#text").scrollTop($("#text")[0].scrollHeight);
         },"json");
     });
     
     $("#text").on("click",".questionChoose",function(){
          var a=this.text;
         $("#flag").before("<p>"+a+":<span>"+email+"<span></p>");
         $.post("../control/AnswerApi.php",{"act":5,"word":a},function(res){
             var b="<li class='answear'>";
             b=b+res.data.answear
             b=b+"</li>";
             $("#flag").before(b);
             $("#text").scrollTop($("#text")[0].scrollHeight);
         },"json");
     });
     
     $("#SUB").click(function(){
         var a=$.trim($("#text2").val());
        if(a===""){
            alert("不能为空");
            return false;
        }
         $("#flag").before("<p>"+a+":<span>"+email+"<span></p>");
         $.post("../control/AnswerApi.php",{"act":0,"word":a},function(res){
                 var b="<li class='answear'>";
                 var arr=new Array();
                if(res.code==11){
                     b=b+res.msg;
                }else if(res.code==2){
                    b=b+"我猜是以下问题吗？</br>";
                    $.each(res.data,function(idx,obj) {
                        b=b+idx+".<a href='###' class='questionChoose'>"+obj+"</a><br/>";
                     });
                }else{
                     $.each(res.data,function(idx,obj) {
                     arr[idx]=obj;
                    });
                     if(arr['data']!=false){
                             b=b+arr['data'];
                     }else{
                            b=b+arr['msg'];
                     }
                } 
                
             b=b+"</li>";
             $("#flag").before(b);
             $("#text").scrollTop($("#text")[0].scrollHeight);
         },"json");
     });
     
});


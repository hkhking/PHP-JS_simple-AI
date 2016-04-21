/* 
 * 2015-03-18 yunhao
 * 登陆 js操作
 */

$(document).ready(function () {
         $("#login").click(function(){
             var a=2;
             var b="user&&"+$("#login-name").val()+"&&pwd&&"+$("#login-pass").val();
             postTypeLogin(a,b);
         });
         
});

function postTypeLogin(a,b){
    $.post("control/ChkUser.php",{"act":a,"word":b},function(res){
        if(!res.result){
            alert(res.msg);
        }else{
            location.href=res.data;
        }
    },"json");
}


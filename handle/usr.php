<?php

/* 
 * yunhao 2015.03.12
 * 用户验证类
 * userStatu:0=>未登录；1=>已登陆；2=>账户异常
 */

include_once '../class/whitelist.php';

class user{
    function user(){
        session_set_cookie_params(12 * 60 * 60); //设置cookie的有效期
        session_cache_expire(12 * 60 * 60); //设置session的有效期
        session_start();
        date_default_timezone_set("PRC");
        if(empty($_SESSION['ssid'])||!isset($_SESSION['ssid'])||$_SESSION['ssid']==""){
           $this->userStatu=0;
        }else{
           $this->userStatu= $_SESSION['ssid'];
        }
    }
    
    function chkUserStatu(){
       return $this->userStatu;
    }
    
    function UserLogin($d){
        $data=$this->format($d);
        $db= whitelist::$usr;
        if($data['pwd']===$db[$data['user']]['pwd']&&  !is_null($data['user'])){
            $_SESSION['ssid']=1;
            $_SESSION['state']=$db[$data['user']]['state'];
            $_SESSION['user']=$data['user'];
            return true;
        }
        return false;
    }
    
    function getMenu(){
        switch ($_SESSION['state']) {
            case "a":
            $res="tmpl/admin.php";
            break;
            case "b":
            $res="tmpl/adminLog.php ";
            default:
                break;
        }
        return $res;
    }
    public function format($tmp1, $type = "&&") {
        $tmp = urldecode($tmp1);
        $str = trim($tmp);
        $res = explode($type, $str);
        $a = sizeof($res);
        for ($i = 0; $i < $a; $i = $i + 2) {
            $arr[$res[$i]] = $res[$i + 1];
        }
        return $arr;
    }
}
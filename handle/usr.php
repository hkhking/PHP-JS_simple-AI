<?php

/* 
 * 2016-08-27 hkhking
 * class of check userstatu
 * userStatu:0=>logout；1=>logined；2=>userstatu error
 */

class user{
    
    private static $getInstance=null;
    
    private function __clone() {}
    
    private function __construct() {}
    
    
    static  function getInstance(){
        if(!(self::$getInstance Instanceof self)){
            self::$getInstance=new self;
        }
        return self::$getInstance;
    }
    
    function chkUserStatu($a){
        if(isset($_SESSION['statu'])&&$_SESSION['statu']==$a){
            return true;
        }
       return false;
    }
    

    
    function UserLogin($d){
        $data=self::format($d);
        $db= include 'conf/whitelist.php';
     
        if(array_key_exists($data['user'],$db) &&$data['pwd']===$db[$data['user']]['pwd']){
            $_SESSION['statu']=$db[$data['user']]['statu'];
            $_SESSION['user']=$data['user'];
            return true;
        }
        return false;
    }
    
   function getMenu(){
        switch ($_SESSION['statu']) {
            case "a":
            $res="admin/admin";
            break;
            case "b":
            $res="admin/adminLog";
            default:
                break;
        }
        return $res;
    }
  function format($tmp1, $type = "&&") {
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
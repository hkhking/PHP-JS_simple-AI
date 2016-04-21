<?php

/* 
 * yunhao 2015.03.12
 * 用户验证
 */

include_once '../handle/usr.php';
$act = isset($_POST['act']) ? $_POST['act'] : null;
$word = isset($_POST['word']) ? $_POST['word'] : null;
$H=new user();


switch ($act) {
    case 1:
     $res= $H->chkUserStatu();
     if(!$res){
    	$result=false;
        $msg="重新登陆";
        $data="../admin.php";
     }else{
        $result=true;
        $data=$H->getMenu();
     }	
    break;
    case 2:
        $res=$H->UserLogin($word);
        if($res){
            $data=$H->getMenu();
            $result=true;
        }else{
            $result=false;
            $msg="登陆失败";
        }
    break;
default :
    break;
}

        $res = array(
            'result' => $result,
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        );

echo json_encode($res);

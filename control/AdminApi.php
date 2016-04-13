<?php

/**
 * 管理员控制模块
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-23
 * 
 */
require '../handle/Product.php';

$act = isset($_POST['act']) ? $_POST['act'] : null;
$word = isset($_POST['word']) ? $_POST['word'] : null;

$pro=new Product();

switch ($act) {
    case "Index":
        $res=$pro->ShowProductList();
    break;
    case "AddPro":
        $res=$pro->AddProduct($word);
    break;
    case "ChangeStatu":
        $res=$pro->ProChangeStatu($word);
    break;
    case "UpdatePro":
        $res=$pro->ProUpdateName($word);
    break;
    case "InfoPro";
        $res=$pro->InfoPro($word);
    break;
    case "ChangeStatuWord":
        $res=$pro->WordChangeStatu($word);
        if($res!=false){
            $res=$pro->InfoPro($res);
        }
    break;
    case "AddWord":
        $res=$pro->AddWord($word);
        if($res!=false){
            $res=$pro->InfoPro($res);
        }
    break;
    case "ShowEidtForm":
        $res=$pro->ShowEditForm($word);
    break;
    case "UpdateWord":
        foreach ($word as $v) {
                $tmp[]=addslashes($v); 
        }
        $res=$pro->UpdateWord($tmp);
        if($res!=false){
            $res=$pro->InfoPro($res);
        }
    break;
    case "DelPro":
        $res=$pro->DelPro($word);
    break;
    case "DelWord":
        $res=$pro->DelWord($word);
         if($res!=false){
            $res=$pro->InfoPro($res);
        }
    break;
    default:
         $res=false;
        break;
}
if(!$res){
    echo "ERROR";
}else{
    echo $res;
}

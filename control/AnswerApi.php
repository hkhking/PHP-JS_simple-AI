<?php
/**
 * 问答控制模块
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-18
 * act:0=>提交问题；1=>初始化；2=>多关键字；3=>无匹配关键字；4=>单关键字；5=>直接匹配问题；6=>产品线选择；7=>反馈信息；1x=>参数错误处理；
 */


require '../handle/FormatWord.php';
require '../handle/AnswerQ.php';

$act = isset($_POST['act']) ? replaceSpecialchars(trim($_POST['act'])) : null;
$word = isset($_POST['word']) ? replaceSpecialchars(trim($_POST['word'])) : null;

if($act==0){
    $AA=new FormatWord($word);
    $act=$AA->DealWord();
}
$A0=new AnswerQ();

switch ($act) {
    case 1:
        $res=$A0->DefaultQ();
        $result=true;
        $code=1;
        $data=$res;
        break;
    case 2:
        $res=$A0->MatchWord2Kind();
        if($res){
            $res=$A0->ManyKeyWordAQ();
        }
        $result=true;
        $code=2;
        $data=$res;
        break;
    case 3:
        $res['msg']=$A0->NoMatchWord();
        $res['data']=$A0->DefaultProduct();
        $result=true;
        $code=3;
        $data=$res;
        break;
    case 4:
        $res['msg']=$A0->MatchWord2Kind();
        if($res['msg']){
            $res['answear']=$A0->SingleKeyWordAQ();
        }
        $result=true;
        $code=4;
        $data=$res;
        break;
    case 5:
        $res=$A0->ChooseQuestion($word);
        $result=true;
        $code=5;
        $data=$res;
        break;
    case 6:
        $_SESSION['product']=$word;
        $res=$A0->DefaultProduct($word);
        $result=true;
        $code=6;
        $data=$res;
        break;
    case 7:
        $A0->ChangeStatu($word);
        $code=7;
        break;
    case 11:
        $result=false;
        $code=11;
        $msg="请先选择产品线";
    break;
    default:
       $result=false;
       $code=10;
       $msg="API_ERROR";
    break;
}

if($code==4||$code==5){
    $_SESSION['list'].="user:".$word."<br/>"; 
    $_SESSION['list'].="sina:".$data['answear']."<br/>";
    $data['listId']=$A0->saveLog();
}elseif($code==1){
    $_SESSION['list']="用户记录：<br/>";
}elseif($code==7){
    $_SESSION['list']="用户记录：<br/>";
}else{
    if(!is_null($word)){
         $_SESSION['list'].="user:".$word."<br/>"; 
    }
    if(!is_null($msg)){
         $_SESSION['list'].="sina:".$msg."<br/>";
    }
    if($data['data']===false){
         $_SESSION['list'].="sina:".$data['msg']."<br/>";
    }
    
    if($code==2||$code==6){
        if(is_array($data)){
             foreach ($data as $k=>$v){
                 $k=$k+1;
            $tmp=$k."、".$v;
            $_SESSION['list'].="sina:".$tmp."<br/>";
            }
        }  
    }
}

$A0->out2($result, $code, $msg,$data);


function replaceSpecialchars($str)
{
    $replace_str = array('\'', '"','<','>','(',')');
    $str = str_replace($replace_str, '', $str);
    return $str;
}
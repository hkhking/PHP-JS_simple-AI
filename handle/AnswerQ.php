<?php

/**
 * 回答模块
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-18
 * 
 */
if(!isset($_SESSION)){ session_start();}
require_once '../class/sql.php';


class AnswerQ {
    private $email=null;
     function AnswerQ(){
        $this->db=new sqldb();
        $this->product=  isset($_SESSION['product'])?$_SESSION['product']:null;
        $this->Word=  isset($_SESSION['kind'])?$_SESSION['kind']:null;
    }
    
    function ChooseQuestion($word){
         $res=$this->db->getQuestionA($word);
        if(!$res){
            return false;
        }
        return $res;
    }
    
    function DefaultQ(){
        $_SESSION['product']=null;
        $res=$this->db->getDefalutQ();
        if(!$res){
            return false;
        }
        $tmp['list']=$res;
        return $tmp;
    }
    
    function DefaultProduct($word=null){
        if(is_null($word)){
          $this->product=$_SESSION['product'];
        }
        $this->product=$word;
        $res=$this->db->getDefalutProductQ($this->product);
        if(!$res){
            return false;
        }
        return $res;
    }
    
    function ManyKeyWordAQ(){
            $tmp="(";
            foreach ($this->kind as $v) {
                $tmp.="'$v',";
            }
            $tmp=substr($tmp,0,strlen($tmp)-1); 
            $tmp.=")";
        $res=$this->db->getManyAQ($this->product,$tmp);
        if(!$res){
            return false;
        }
        return $res;
    }
    
    
    function SingleKeyWordAQ(){
        $res=$this->db->getSingleAQ($this->product,$this->kind);
        if(!$res){
            return false;
        }
        return $res;
    }
    
    function MatchWord2Kind(){
            $tmp="(";
            foreach ($this->Word as $v) {
                $tmp.="'$v',";
            }
            $tmp=substr($tmp,0,strlen($tmp)-1); 
            $tmp.=")";
        $res=$this->db->getKind($this->product,$tmp);
        if(!$res){
            return false;
        }
        if(count($res)==1){
           $this->kind=$res[0];
        }else{
           $this->kind=$res;
        }
       return true;
    }
    
    function NoMatchWord(){
        $res=$this->db->getNoWord($this->product);
        if(!$res){
            return false;
        }
        return $res[0];
    }
    
    
     function out2($result, $code, $msg= null, $data = null) {
        $res = array(
            'result' => $result,
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        );
        echo json_encode($res);
        return true;
    }
    
    function saveLog(){
        if(!isset($_SESSION['list'])||$_SESSION['list']==""){
            $_SESSION['list']="数据保存错误";
        }
       if(is_null($this->email)){
           $email="无";
       }else{
           $email=$this->email;
       }
       $ua=$_SERVER['HTTP_USER_AGENT'];
       $ip=$_SERVER["REMOTE_ADDR"];
       $res=$this->db->saveLogdb($email,$ua,$ip);
       return $res;
    }
    
    
    function ChangeStatu($word){
            $a=explode("_",$word);
            $this->db->ChangeStatuDB($a[0],$a[1]); 
    }
}

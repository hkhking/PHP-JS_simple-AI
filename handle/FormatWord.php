<?php
 /**
 * 用户提交信息处理
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-18
 * act:0=>提交问题；1=>初始化；2=>多关键字；3=>无匹配关键字；4=>单关键字；5=>直接匹配问题；6=>产品线选择；7=>反馈信息；1x=>参数错误处理；
 */
if(!isset($_SESSION)){ session_start();}
require_once '../class/sql.php';

class FormatWord {
    private $key=array();
    
   function ForMatWord($word){
        $this->db=sqldb::getInstance("MYSQL");
        $this->word=trim($word);
        $this->word=str_replace('"', '', $this->word);
        $this->word=str_replace("'", '', $this->word);
        $this->product=isset($_SESSION['product'])?$_SESSION['product']:null;
    }
    
    function DealWord(){
       if(is_null($this->product)){
           return 11;
       }
       $res=$this->db->getWordArr($this->product);
       if(!$res){
           return 10;
       }
       $this->MatchWord($res);
       $res=sizeof($this->key);
       $_SESSION['kind']=$this->key;
       if($res==0){
           return 3;
       }elseif($res==1){
           return 4;
       }else{
           return 2;
       }
    }
    
    function Str2Arr($tmp){
        $str=trim($tmp);
        $res=explode(",",$str);
        return $res;
    }
    
    function MatchWord($arr){
        foreach ($arr as $k =>$v){
          $tmp=$this->Str2Arr($v);
         foreach ($tmp as $v2) {
           if($v2!=''||!empty($v2)){//关键字容错
                $res=stristr($this->word,$v2);
                  if($res){
                      $tmp2[$k]=isset($tmp2[$k])?$tmp2[$k]+1:1;
                  }
            }
           }
         }

         if(!isset($tmp2)||is_null($tmp2)){
             return;
         }
         
         arsort($tmp2);
         $maxval="";
         foreach ($tmp2 as $k2 => $v3) {
             if (empty($maxval) || $v3>$maxval){ 
                 $maxval=$v3;
                 $this->key[]=$k2;
             }elseif($maxval-$v3<=2){
                 $this->key[]=$k2;
             }
         }
    }
}

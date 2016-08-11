<?php
 /**
 * 日志处理
 * @author hkhking hkhking@outlook.com
 * @date 2015-01-04
 */
if(!isset($_SESSION)){ session_start();}
require_once '../class/sql.php';

class LogSearch{
    private $sqllist;
    private $where;
    public $act;
    function LogSearch($product,$kind,$help,$startT,$stopT,$act){
        $this->product=$product;
        $this->kind=$kind;
        $this->help=$help;
        $this->startT=$startT;
        $this->stopT=$stopT;
        $this->db=sqldb::getInstance("MYSQL");
        
        if(in_array($act,array(0,2,3,4,5))){
            $this->act=$act;
        }else{
            $this->DealInput($act);
        }
        
    }
    
    function DealInput($act){  
        if(date("Y",strtotime($this->startT))!=date("Y",strtotime($this->stopT))){
            $this->act= 10;
            return;
        }else{             
            $this->sqllist=date("Y",strtotime($this->startT))."log";
        }
        
        if(!is_null($this->product)&&$this->product!="all"){
            //$this->where.="product='$this->product' and ";
			$this->where['product']=$this->product;
        }
        if(!is_null($this->kind) && $this->kind!="all"){
            //$this->where.="kind = '$this->kind' and ";
			$this->where['kind']=$this->kind;
        }
        if(!is_null($this->help) && $this->help!="all"){
            //$this->where.="statu='$this->help' and ";
			$this->where['help']=$this->help;
        }
 
        if(!is_null($this->startT)||!is_null($this->stopT)){
            //$this->where.="stime between '$this->startT 00:00:00' and '$this->stopT 23:59:59'";
			$this->where['startT']=$this->startT;
			$this->where['stopT']=$this->stopT;
        }else{
            $this->act= 11;
        }
         $this->act=$act;
    }
    
    function getPage($page){
        $res['list']=$_SESSION[$page];
        $a=substr($page,4);
        $res['onList']=$a;
        return $res;
    }
    
    function getKind($pro){
        if(is_null($pro)){
            return false;
        }
         $res=$this->db->ShowProductInfo($pro);
         $tmp="<option id='OptKind' value='all'>问题分类</option>";
         foreach ($res as $v) {
             if($v['kind']!="NoWord"){
                 $tmp.="<option value='".$v['kind']."'>".$v['kind']."</option>";
             }
         }
         return  $tmp;
    }
    
    function getLogCom($sqldb,$id){
        if(is_null($id)){
            return false;
        }
         $res=$this->db->getLogComdb($sqldb,$id);
         return $res;
    }
    
    function getLogList($startT=null,$stopT=null){
        if(!is_null($startT)){
            $this->startT=$startT;
            $this->stopT=$stopT;
            $this->DealInput(0);
        }
        $res=$this->db->getLoglistdb($this->where,$this->sqllist);
        if($res[0]==""||is_null($res[0])){
            $tmp="暂无数据";
            $_SESSION['pageNum']=1;
            $_SESSION['total']=0;
            return $tmp;
        }else{
             $this->save2ecl($res);
             $this->PageControl($res);
             $this->PageNumControl();
              return $_SESSION['page1'];
        }
    }
    
    function PageNumControl(){
        if($_SESSION['pageNum']==1){
            return;
        }
        $tmp="";
        for($i=1;$i<=$_SESSION['pageNum'];$i++){
            $tmp.="<a href='###' id='page$i' class='ChangePape'>$i</a>";
        }
        $_SESSION['pageNum']=$tmp;
    }
    
    function PageControl($res){
        $tmp="";
        $i=0;
        $a=1;
            foreach ($res as $v) {
                if($v['statu']==1){
                    $tmp1="是";
                }elseif($v['statu']==0){
                    $tmp1="否";
                }else{
                    $tmp1="未评价";
                }
                $tmp.="<table><tr><td><lable>产品线</lable></td><td><lable>".$v['product']."</lable></td></tr>"
                        . "<tr><td><lable>联系方式</lable></td><td><lable>".$v['email']."</lable></td></tr>"
                        . "<tr><td><lable>问题分类</lable></td><td><lable>".$v['kind']."</lable></td></tr>"
                        . "<tr><td><lable>反馈时间</lable></td><td><lable>".$v['stime']."</lable></td></tr>"
                        . "<tr><td><lable>UA</lable></td><td><lable>".$v['ua']."</lable></td></tr>"
                        . "<tr><td><lable>IP</lable></td><td><lable>".$v['ip']."</lable></td></tr>"
                        . "<tr><td><lable>是否有用</lable></td><td><lable>".$tmp1."</lable></td></tr></table>"
                        . "<a href='###' id='id".$v['id']."_$this->sqllist' class='CHKList'>查看聊天记录</a> <hr/>";
                $i++;
                if($i%10==0){
                    $_SESSION['page'.$a]=$tmp;
                    $a++;
                    $tmp="";
                }
            } 
            if($i%10!=0){
                $_SESSION['page'.$a]=$tmp;
            }else{
                $a=$a-1;
            }
            $_SESSION['pageNum']=$a;
            $_SESSION['total']=$i;
    }
    
    function DefaultPage(){
        $tmp="<select id='SelPro'><option value='all'>产品线</option>";
        $res=$this->db->getDefalutQ();
        foreach ($res as $v) {
           $tmp.="<option value='$v'>$v</option>";
        }
        $tmp.="</select>";
        $tmp.="<select id='SelKind'><option id='OptKind' value='all'>问题分类</option></select>";
        $tmp.="<select id='help'><option  value='all'>是否有用</option>"
                . "<option  value='0'>否</option>"
                . "<option  value='1'>是</option>"
                . "<option  value='2'>未评价</option></select>";
        $tmp.="起始时间：<input type='text' class='datepicker' id='StartT'/>终止时间：<input type='text' class='datepicker' id='StopT'/>"
                . "<input type='button' value='查询' id='SUBBUT' class='thoughtbot'/> <input type='button' value='导出' id='ExportList' class='thoughtbot'/>";
        return $tmp;
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
    
    function save2ecl($res){
                $exp="";
		$exp.= $this->codeutf8("产品线")."\t";
		$exp.= $this->codeutf8("联系方式")."\t";
		$exp.= $this->codeutf8("问题分类")."\t";
		$exp.= $this->codeutf8("反馈时间")."\t";
		$exp.= $this->codeutf8("UA")."\t";
		$exp.= $this->codeutf8("IP")."\t";
		$exp.= $this->codeutf8("是否有用")."\n";	
                
                foreach ($res as $v) {
                        $exp.= $this->codeutf8($v['product'])."\t";
			$exp.= $this->codeutf8($v['email'])."\t";
			$exp.= $this->codeutf8($v['kind'])."\t";
			$exp.= $this->codeutf8($v['stime'])."\t";
			$exp.= $this->codeutf8($v['ua'])."\t";
			$exp.= $this->codeutf8($v['ip'])."\t";
			$exp.= $this->codeutf8($v['statu'])."\n";
                }
              $_SESSION['EXPECL']=$exp;
    }
    
    function eclout(){ 
        $filename="Log".date('Y-m-d').".xls";
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=$filename");
	header("Pragma: no-cache");
	header("Expires: 0");
        return $_SESSION['EXPECL'];
    }
    
    function codeutf8($str){
 	return iconv("utf-8", "gb2312",$str);
    }
}

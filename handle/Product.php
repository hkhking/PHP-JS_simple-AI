<?php
/**
 * 产品线控制类
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-23
 * 
 */
require_once '../class/sql.php';

class Product {
    function Product(){
         //$this->db=new sqldb();
		 $this->db=sqldb::getInstance("MYSQL");
		 $this->mc=sqldb::getInstance("MC");
    }
    
    function ShowEditForm($word){
        if(is_null($word)){ return false;}
        $res=$this->db->getWordInfo($word);
        if(!is_array($res)){
            return false;
        }
        $arr=json_encode($res);
        return $arr;
    }
    
    function UpdateWord($word){
        if(is_null($word)){ return false;}
        $res=$this->db->updateWordInfo($word);
        return $res;
    }
    
    function AddWord($word){
        if(is_null($word)){ return false;}
        $res=$this->db->insertWord($word);
        return $res;
    }
    
     function DelPro($word){
        if(is_null($word)){ return false;}
        $res=$this->db->DeletePro($word);
        return $res;
    }
    
    function DelWord($word){
        if(is_null($word)){ return false;}
        $res=$this->db->DeleteWord($word);
        return $res;
    }
    
    function WordChangeStatu($word){
        if(is_null($word)){ return false;}
        $res=$this->db->updateWordStatu($word);
        return $res;
    }
    
    function InfoPro($word){
        if(is_null($word)){ return false;}
            $res=$this->db->ShowProductInfo($word);
             $tmpl="<input type='hidden' id='NameWord' value='".$word."'/><table border='1'><tr><th>序号</th><th>关键字类型</th><th>操作时间</th><th>状态</th><th>操作</th></tr>";
              if($res){
                $i=1;
                foreach ($res as $v) {
                    $statu=$v['statu']==0?"非预设":"预设项";
                    if($v['kind']==="NoWord"){
                        $tmpl.="<tr><td>$i</td><td>没有关键字</td><td>".$v['stime']."</td><td>$statu</td>"
                            . "<td><a href='###' id='editWord$i' class='EditWord'>编辑</a>"
                            ."<input type='hidden' id='ValueWord$i' value='".$v['id']."'/></tr>";
                    }else{  
                     $tmpl.="<tr><td>$i</td><td id='NameKey$i'>".$v['kind']."</td><td>".$v['stime']."</td><td>$statu</td>"
                            . "<td><a href='###' id='editWord$i' class='EditWord'>编辑</a>"
                            . "<a href='###' id='StatuWord$i' class='StatuWord'>状态</a>"
                            . "<a href='###' id='DelWord$i' class='DelWord'>删除</a><input type='hidden' id='ValueWord$i' value='".$v['id']."'/>"
                            . "</td></tr>";
                    }
                $i++;
                }
                $res=$tmpl."</table>";
            }
        return $res;
    }
    
    function ProUpdateName($word){
        if(is_null($word)){ return false;}
        $res=$this->db->updateProductName($word);
        return $res;
    }
    
    function ProChangeStatu($word){
        if(is_null($word)){ return false;}
        $res=$this->db->updateProductStatu($word);
        return $res;
    }
    
    function AddProduct($word){
        if(is_null($word)){ return false;}
        $res=$this->db->insertProduct($word);
        return $res;
    }
    
    function ShowProductList(){
        $tmpl="<table border='1'><tr><th>序号</th><th>产品线名称</th><th>操作时间</th><th>状态</th><th>操作</th></tr>";
        $res=$this->db->getProductList();
        if($res){
            $i=1;
            foreach ($res as $v) {
                $statu=$v['statu']==0?"隐藏":"使用中";
                $tmpl.="<tr><td>$i</td><td>".$v['product']."</td><td>".$v['stime']."</td><td>$statu</td>"
                        . "<td><a href='###' id='ShowPro$i' class='ShowPro'>查看</a>"
                        . "<a href='###' id='editPro$i' class='EditPro'>编辑</a>"
                        . "<a href='###' id='StatuPro$i' class='StatuPro'>状态</a>"
                        . "<a href='###' id='DelPro$i' class='DelPro'>删除</a><input type='hidden' id='ValuePro$i' value='".$v['id']."'/>"
                        . "<input type='hidden' id='NamePro$i' value='".$v['product']."'/></td></tr>";
            $i++;
            }
            $res=$tmpl."</table>";
        }
        return $res;
    }
    
    function delMC(){
		$this->mc->flush();
    }
}

<?php
/* 
 * 2016-08-26 hkhking
 * template router 
 */

include_once 'base.php';

//check key
$chk=isset($_REQUEST['chk'])?$_REQUEST['chk']:0;
if($chk!=="hkhking"){
    echo "404";
    exit(1);
}

//get module 
$tmp=explode("/", strtolower($_SERVER['REQUEST_URI']));
unset($tmp[0]);
 if(empty($tmp[1])){
     $tmp[1]="index";
 }

 //get router
if(!isset($router)||empty($router)){
    $router=  include 'conf/router.php';
    if($tmp[1]==="control"){
           $router[]=$router['control'];
           $len=2;
    }else{
          $router=$router['tmpl'];
          $len=count($tmp);
    }
  
}

//get url
    $i=1;
    $flag=true;
     while($len>=$i){ 
         if(!isset($router[$tmp[$i]])){
             $flag=false;
             break;
         }
             $router=$router[$tmp[$i]];
             $i++;
     }
     $url=$router;

     
 if (!$flag){  
         $res="404";
 }elseif(isset($url)&&$tmp[1]=="control"&&count($url)===2){
        //API control
        include $url[1];
        $t=new $url[0];
        $t->inputData();
        $res=$t->getRes();
        
 }elseif(isset($url)&&count($url)===1){
     //push tmpl
     $res=file_get_contents($url);
}else{
     $res="404";
}

echo $res;
exit(1);
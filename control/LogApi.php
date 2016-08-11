<?php
/**
 * 日志查询模块
 * @author hkhking hkhking@outlook.com
 * @date 2015-01-01
 * act=0:初始化；act=1：查询日志；act=2：查看聊天记录；act=3：替换问题分类；act=4：翻页；act=5：导出
 */

require '../handle/LogSearch.php';

$act = isset($_POST['act']) ? $_POST['act'] : null;
$product=isset($_POST['product']) ? $_POST['product'] : null;
$kind = isset($_POST['kind']) ? $_POST['kind'] : null;
$help = isset($_POST['help']) ? $_POST['help'] : null;
$startT = isset($_POST['startT']) ? $_POST['startT'] : null;
$stopT = isset($_POST['stopT']) ? $_POST['stopT'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;
$sqldb = isset($_POST['sqldb']) ? $_POST['sqldb'] : null;
$page = isset($_POST['page']) ? $_POST['page'] : null;
$msg=null;

if(isset($_REQUEST['a'])){
    $act=5;
}

$class=new LogSearch($product, $kind, $help, $startT, $stopT,$act);

switch ($class->act){
    case 0:
        $res1=$class->DefaultPage();
        $res2=$class->getLogList(date("Y-m-d",  time()),date("Y-m-d",  strtotime('+1 day')));
        $result=true;
        $data['head']=$res1;
        $data['list']=$res2;
        $data['page']=$_SESSION['pageNum'];
        $data['total']=$_SESSION['total'];
        $data['onList']=1;
    break;
    case 1:
        $res=$class->getLogList();
        $result=true;
        $data['list']=$res;
        $data['page']=$_SESSION['pageNum'];
        $data['total']=$_SESSION['total'];
        $data['onList']=1;
    break;
    case 2:
        $res=$class->getLogCom($sqldb,$id);
        $result=true;
        $data['com']=$res;
    break;
    case 3:
        $res=$class->getKind($product);
        $result=true;
        $data['kind']=$res;
    break;
    case 4:
         $res=$class->getPage($page);
         $result=true;
         $data=$res;
    break;
    case 5:
        $res=$class->eclout();
        echo $res;
        exit();
    break;
    case 10:
        $res="查询日期超过年份";
        $msg=$res;
        $result=false;
    break;
    case 11:
        $res="查询参数错误";
        $msg=$res;
        $result=false;
    break;
default :
    $res=false;
    break;
}
    $code=$class->act;
    $class->out2($result, $code, $msg,$data);




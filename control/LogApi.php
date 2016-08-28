<?php

/**
 * query log module 
 * @author hkhking hkhking@outlook.com
 * @date 2016-08-27
 * act=0:initialization；act=1：query log；act=2：query chat log；act=3：change type of question ；act=4：page turn；act=5;  save log  as execl
 */
require 'handle/LogSearch.php';

class LogApi extends Ccontrol {

    use LogSearch;

    function doaction() {
        switch ($this->act) {
            case 0:
                $this->defaultPara();
                $res1 = $this->DefaultPage();
                $res2 = $this->getLogList(date("Y-m-d", time()), date("Y-m-d", strtotime('+1 day')));
                $result = true;
                $data['head'] = $res1;
                $data['list'] = $res2;
                $data['page'] = $_SESSION['pageNum'];
                $data['total'] = $_SESSION['total'];
                $data['onList'] = 1;
                break;
            case 1:
                $res = $this->getLogList();
                $result = true;
                $data['list'] = $res;
                $data['page'] = $_SESSION['pageNum'];
                $data['total'] = $_SESSION['total'];
                $data['onList'] = 1;
                break;
            case 2:
                $res = $this->getLogCom();
                $result = true;
                $data['com'] = $res;
                break;
            case 3:
                $res = $this->getKind();
                $result = true;
                $data['kind'] = $res;
                break;
            case 4:
                $res = $this->getPage();
                $result = true;
                $data = $res;
                break;
            case 5:
                $res = $this->eclout();
                echo $res;
                exit();
                break;
            case 10:
                $res = "查询日期超过年份";
                $msg = $res;
                $result = false;
                break;
            case 11:
                $res = "查询参数错误";
                $msg = $res;
                $result = false;
                break;
            default :
                $res = false;
                break;
        }
         $this->res = array(
            'result' => $result,
            'code' => $this->act,
            'msg' => isset($msg)?$msg:null,
            'data' => $data,
        );
    }

}

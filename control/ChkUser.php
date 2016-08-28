<?php

/*
 * 2016-08-27 hkhking 
 * user state check
 */

include_once 'handle/usr.php';
include_once 'class/Ccontrol.php';

class ChkUser extends Ccontrol {

    function doaction() {
        $H = user::getInstance();

        switch ($this->act) {
            case 1:
                $res = $H->chkUserStatu($this->word);
                if (!$res) {
                    $result = false;
                    $msg = "重新登陆";
                    $data = "/login";
                } else {
                    $result = true;
                    $data = $H->getMenu();
                    $msg = null;
                }
                break;
            case 2:
                $res = $H->UserLogin($this->word);
                if ($res) {
                    $data = $H->getMenu();
                    $result = true;
                    $msg = "";
                } else {
                    $result = false;
                    $msg = "登陆失败";
                    $data = "";
                }
                break;
            default :
                break;
        }

        $this->res = array(
            'result' => $result,
            'msg' => $msg,
            'data' => $data,
        );
    }

}

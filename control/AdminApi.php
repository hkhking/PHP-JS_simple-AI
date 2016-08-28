<?php

/**
 * 管理员控制模块
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-23
 * 
 */
include 'handle/Product.php';

class AdminApi extends Ccontrol {

    use Product;

    function doaction() {
        switch ($this->act) {
            case "Index":
                $res = $this->ShowProductList();
                break;
            case "AddPro":
                $res = $this->AddProduct();
                if ($res) {
                    $this->delMC();
                }
                break;
            case "ChangeStatu":
                $res = $this->ProChangeStatu();
                if ($res) {
                    $this->delMC();
                }
                break;
            case "UpdatePro":
                $res = $this->ProUpdateName();
                if ($res) {
                    $this->delMC();
                }
                break;
            case "InfoPro";
                $res = $this->InfoPro($this->word);
                break;
            case "ChangeStatuWord":
                $res = $this->WordChangeStatu();
                if ($res != false) {
                    $res = $this->InfoPro($res);
                }
                if ($res) {
                    $this->delMC();
                }
                break;
            case "AddWord":
                $res = $this->AddWord();
                if ($res != false) {
                    $res = $this->InfoPro($res);
                }
                if ($res) {
                    $this->delMC();
                }
                break;
            case "ShowEidtForm":
                $res = $this->ShowEditForm();
                break;
            case "UpdateWord":
                foreach ($this->word as $v) {
                    $tmp[] = addslashes($v);
                }
                $res = $this->UpdateWord($tmp);
                if ($res != false) {
                    $res = $this->InfoPro($res);
                }
                if ($res) {
                    $this->delMC();
                }
                break;
            case "DelPro":
                $res = $this->DelPro();
                if ($res) {
                    $this->delMC();
                }
                break;
            case "DelWord":
                $res = $this->DelWord();
                if ($res != false) {
                    $res = $this->InfoPro($res);
                }
                if ($res) {
                    $this->delMC();
                }
                break;
            default:
                $res = false;
                break;
        }
        $this->res = array(
            'result' => true,
            'data' => $res,
        );
    }

}

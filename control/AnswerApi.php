<?php

/**
 * 问答控制模块
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-18
 * act:0=>提交问题；1=>初始化；2=>多关键字；3=>无匹配关键字；4=>单关键字；5=>直接匹配问题；6=>产品线选择；7=>反馈信息；1x=>参数错误处理；
 */
include_once 'handle/FormatWord.php';
include_once 'handle/AnswerQ.php';

class AnswerApi extends Ccontrol {

    use AnswerQ,
        FormatWord;

    function doaction() {
        if ($this->act == 0) {
            $this->DealInput();
            $this->DealWord();
        }

        if (isset($this->user) && !is_null($this->user)) {
            $this->setUser();
        }

        $this->SwitchAct();
        $this->DealLog();
        $this->res = array(
            'result' => $this->result,
            'code' => $this->code,
            'msg' => $this->msg,
            'data' => $this->data,
        );
    }

    function SwitchAct() {
        switch ($this->act) {
            case 1:
                $res = $this->DefaultQ();
                $this->result = true;
                $this->code = 1;
                $this->data = $res;
                break;
            case 2:
                $res = $this->MatchWord2Kind();
                if ($res) {
                    $res = $this->ManyKeyWordAQ();
                }
                $this->result = true;
                $this->code = 2;
                $this->data = $res;
                break;
            case 3:
                $res['msg'] = $this->NoMatchWord();
                $res['data'] = $this->DefaultProduct();
                $this->result = true;
                $this->code = 3;
                $this->data = $res;
                break;
            case 4:
                $res['msg'] = $this->MatchWord2Kind();
                if ($res['msg']) {
                    $res['answear'] = $this->SingleKeyWordAQ();
                }
                $this->result = true;
                $this->code = 4;
                $this->data = $res;
                break;
            case 5:
                $res = $this->ChooseQuestion();
                $this->result = true;
                $this->code = 5;
                $this->data = $res;
                break;
            case 6:
                $_SESSION['product'] = $this->word;
                $res = $this->DefaultProduct();
                $this->result = true;
                $this->code = 6;
                $this->data = $res;
                break;
            case 7:
                $this->ChangeStatu();
                $this->code = 7;
                $this->result = true;
                break;
            case 11:
                $result = false;
                $this->code = 11;
                $this->msg = "请先选择产品线";
                break;
            default:
                $result = false;
                $this->code = 10;
                $this->msg = "API_ERROR";
                break;
        }
    }

    function DealLog() {
        if ($this->code == 4 || $this->code == 5) {
            $_SESSION['list'].="user:" . $this->word . "<br/>";
            $_SESSION['list'].="sina:" . $this->data['answear'] . "<br/>";
            $this->data['listId'] = $this->saveLog();
        } elseif ($this->code == 1) {
            $_SESSION['list'] = "用户记录：<br/>";
        } elseif ($this->code == 7) {
            $_SESSION['list'] = "用户记录：<br/>";
        } else {
            if (!is_null($this->word)) {
                $_SESSION['list'].="user:" . $this->word . "<br/>";
            }
            if (!is_null($this->msg)) {
                $_SESSION['list'].="sina:" . $this->msg . "<br/>";
            }

            if (isset($this->data['data']) && $this->data['data'] === false) {
                $_SESSION['list'].="sina:" . $this->data['msg'] . "<br/>";
            }

            if ($this->code == 2 || $this->code == 6) {
                if (is_array($this->data)) {
                    foreach ($this->data as $k => $v) {
                        $k = $k + 1;
                        $tmp = $k . "、" . $v;
                        $_SESSION['list'].="sina:" . $tmp . "<br/>";
                    }
                }
            }
        }
    }

}

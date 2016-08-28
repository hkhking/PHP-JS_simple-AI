<?php

/**
 * 回答模块
 * @author hkhking hkhking@outlook.com
 * @date 2016-08-28
 * 
 */
trait AnswerQ {

    private $email = null;

    function setUser() {
        $_SESSION['email'] = $this->user;
    }

    function ChooseQuestion() {
        $res = $this->db->getQuestionA($this->word);
        if (!$res) {
            return false;
        }
        return $res;
    }

    function DefaultQ() {
        $_SESSION['product'] = null;
        $ret = $this->mc->get("DefaultQ");
        if (!$ret) {
            $res = $this->db->getDefalutQ();
            $this->mc->set("DefaultQ", $res);
        } else {
            $res = $ret;
        }

        if (!$res) {
            return false;
        }
        $tmp['list'] = $res;
        $tmp['email'] = $_SESSION['email'];
        return $tmp;
    }

    function DefaultProduct() {
        if (is_null($this->word)) {
            $this->product = $_SESSION['product'];
        }
        $this->product = $this->word;
        $ret = $this->mc->get("Default" . $this->product);
        if (!$ret) {
            $res = $this->db->getDefalutProductQ($this->product);
            $this->mc->set("Default" . $this->product, $res);
        } else {
            $res = $ret;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }

    function ManyKeyWordAQ() {
        $res = $this->db->getManyAQ($this->product, $this->kind);
        if (!$res) {
            return false;
        }
        return $res;
    }

    function SingleKeyWordAQ() {
        $res = $this->db->getSingleAQ($this->product, $this->kind);
        if (!$res) {
            return false;
        }
        return $res;
    }

    function MatchWord2Kind() {
        $res = $this->db->getKind($this->product, $this->key);
        if (!$res) {
            return false;
        }
        if (count($res) == 1) {
            $this->kind = $res[0];
        } else {
            $this->kind = $res;
        }
        return true;
    }

    function NoMatchWord() {
        $ret = $this->mc->get("NoMatchWord" . $this->product);
        if (!$ret) {
            $res = $this->db->getNoWord($this->product);
            $this->mc->set("NoMatchWord" . $this->product, $res);
        } else {
            $res = $ret;
        }

        if (!$res) {
            return false;
        }
        return $res[0];
    }

    function saveLog() {
        if (!isset($_SESSION['list']) || $_SESSION['list'] == "") {
            $_SESSION['list'] = "数据保存错误";
        }
        if (is_null($this->email)) {
            $email = "无";
        } else {
            $email = $this->email;
        }
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER["REMOTE_ADDR"];
        $res = $this->db->saveLogdb($email, $ua, $ip);
        return $res;
    }

    function ChangeStatu() {
        $a = explode("_", $this->word);
        $this->db->ChangeStatuDB($a[0], $a[1]);
    }

}

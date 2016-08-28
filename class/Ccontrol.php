<?php

/*
 *  2016-08-27 hkhking
 * base class of control 
 */

class Ccontrol {

    protected $act = null;
    protected $word = null;
    protected $res = null;
    protected $result=null;
    protected $code=null;
    protected $msg=null;
    protected $data=null;
            
    function __construct() {
        $this->db = sqldb::getInstance("MYSQL");
        $this->mc = sqldb::getInstance("MC");
    }

    function inputData() {
        foreach($_POST as $k => $v){
            $this->$k=replaceSpecialchars(trim($v));
        }
        $this->act = isset($this->act) ?$this->act  : null;
        $this->word = isset($this->word) ? $this->word: null;
        $this->doaction();
    }

    function getRes() {
        return json_encode($this->res);
    }
}

function replaceSpecialchars($str) {
    $replace_str = array('\'', '"', '<', '>', '(', ')');
    $str = str_replace($replace_str, '', $str);
    return $str;
}

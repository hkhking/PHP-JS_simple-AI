<?php

/*
  2016-08-10 hkhking
  sqldb extend,the function of client's use
 */

trait MainSqlFun {

    function getQuestionA($word) {
        $sql = "select answear,kind,product from questionbox where question=?";

        if ($rs = sqldb::$sqlcon['MYSQL']->query($sql, array($word))) {
            $_SESSION['kind'] = $rs[0]['kind'];
            $_SESSION['product'] = $rs[0]['product'];
            return $rs[0];
        }
        return false;
    }

    function getWordArr($product) {

        $sql = "select word,kind from keywordlist where product=?";
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, array($product))) {
            return false;
        }
        $arr = array();
        foreach ($rs as $v) {
            $arr[$v['kind']] = $v['word'];
        }
        return $arr;
    }

    function getDefalutQ() {
        $sql = "select product,count(*) as num from keywordlist where statu=1 group by product";
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql)) {
            return false;
        }
        $arr = array();
        foreach ($rs as $v) {
            $arr[] = $v['product'];
        }
        return $arr;
    }

    function getDefalutProductQ($product) {
        $sql = "select question from questionbox where statu=1 and product=? and kind <> 'NoWord'";
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, array($product))) {
            return false;
        }
        $arr = array();
        foreach ($rs as $v) {
            $arr[] = $v['question'];
        }
        return $arr;
    }

    function getSingleAQ($product, $kind) {
        $sql = "select answear from questionbox where product=? and kind=?";
        $data = array($product, $kind);
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, $data)) {
            return false;
        }
        foreach ($rs as $k => $v) {
            $str = $v['answear'];
        }
        $_SESSION['kind'] = $kind;
        return $str;
    }

    function getManyAQ($product, $kind) {
        $plist = ':id_' . implode(',:id_', array_keys($kind));
        $sql = "select question from questionbox where product=:product and kind in ($plist)";
        $data = array_combine(explode(",", $plist), $kind);
        $data["product"] = $product;
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, $data)) {
            return false;
        }
        $arr = array();
        foreach ($rs as $v) {
            $arr[] = $v['question'];
        }
        return $arr;
    }

    function getKind($product, $word) {
        $plist = ':id_' . implode(',:id_', array_keys($word));
        $sql = "select kind from keywordlist where  product=:product and kind in ($plist)";
        $data = array_combine(explode(",", $plist), $word);
        $data["product"] = $product;
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, $data)) {
            return false;
        }
        foreach ($rs as $v) {
            $arr[] = $v['kind'];
        }
        return $arr;
    }

    function getNoWord($product) {
        $sql = "select answear from questionbox where  product=? and kind ='NoWord'  and statu=1";
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, array($product))) {
            return false;
        }
        foreach ($rs as $v) {
            $arr[] = $v['answear'];
        }
        return $arr;
    }

    function ChangeStatuDB($id, $statu) {
        $sql = "update " . sqldb::$sqllist . " set statu=? where id= ?";
        $data = array($statu, $id);
        if (!$rs = sqldb::$sqlcon['MYSQL']->queryNum($sql, $data, 1, 1)) {
            return false;
        }
    }

}

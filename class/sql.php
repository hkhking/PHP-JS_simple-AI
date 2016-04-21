<?php

/**
 * 数据库控制类
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-18
 */
date_default_timezone_set("Asia/Shanghai");

class sqldb {

    private $sqllist = null;

    function sqldb() {
        $dbInfo = array(
            "dsn" => "",
            "user" => "",
            "pass" => "",
        );
        try {
            $this->db = new PDO($dbInfo['dsn'], $dbInfo['user'], $dbInfo['pass']);
            $this->db->exec("SET NAMES UTF8");
        } catch (PDOException $e) {
            return false;
        }

        $this->sqllist = date("Y", time()) . "log";
    }

    function getQuestionA($word) {
        $sql = "select answear,kind,product from questionbox where question='{$word}'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($rs) == 0) {
            return false;
        }
        $_SESSION['kind'] = $rs[0]['kind'];
        $_SESSION['product'] = $rs[0]['product'];
        return $rs[0];
    }

    function getWordArr($product) {
        $sql = "select word,kind from keywordlist where product='{$product}'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($rs as $v) {
            $arr[$v['kind']] = $v['word'];
        }
        if (sizeof($arr) == 0) {
            return false;
        }
        return $arr;
    }

    function getDefalutQ() {
        $sql = "select product,count(*) as num from keywordlist where statu=1 group by product";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($rs as $v) {
            $arr[] = $v['product'];
        }
        if (sizeof($arr) == 0) {
            return false;
        }
        return $arr;
    }

    function getDefalutProductQ($product) {
        $sql = "select question from questionbox where statu=1 and product='{$product}' and kind <> 'NoWord'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($rs as $v) {
            $arr[] = $v['question'];
        }
        if (sizeof($arr) == 0) {
            return false;
        }
        return $arr;
    }

    function getSingleAQ($product, $kind) {
        $sql = "select answear from questionbox where product='{$product}' and kind='{$kind}'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $k => $v) {
            $str = $v['answear'];
        }
        if (empty($str) || is_null($str)) {
            return false;
        }
        $_SESSION['kind'] = $kind;
        return $str;
    }

    function getManyAQ($product, $kind) {
        $sql = "select question from questionbox where product='{$product}' and kind in $kind";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($rs as $v) {
            $arr[] = $v['question'];
        }
        if (sizeof($arr) == 0) {
            return false;
        }
        return $arr;
    }

    function getKind($product, $Word) {
        $sql = "select kind from keywordlist where  product='{$product}' and kind in $Word";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $v) {
            $arr[] = $v['kind'];
        }
        if (sizeof($arr) == 0) {
            return false;
        }
        return $arr;
    }

    function getNoWord($product) {
        $sql = "select answear from questionbox where  product='{$product}' and kind ='NoWord'  and statu=1";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $v) {
            $arr[] = $v['answear'];
        }
        if (sizeof($arr) == 0) {
            return false;
        }
        return $arr;
    }

    function ChangeStatuDB($id, $statu) {
        $sql1 = "update $this->sqllist set statu='$statu' where id= '$id'";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
    }

    //admin

    function getProductList() {
        $sql = "select id,product,stime,statu from keywordlist where kind ='NoWord'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($rs) == 0) {
            return false;
        }
        return $rs;
    }

    function insertProduct($word) {
        $sql = "select count(*) from keywordlist where product ='{$word}'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($rs[0]['count(*)'] != 0) {
            return false;
        }

        $sql1 = "insert into keywordlist (word,product,kind,stime,statu) values"
                . "('没有关键字','{$word}','NoWord','" . date("Y-m-d H:i:s") . "',0)";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() != 1) {
            return false;
        }


        $sql2 = "insert into questionbox (answear,product,question,kind,stime,statu) values"
                . "('没有关键字','{$word}','没有关键字','NoWord','" . date("Y-m-d H:i:s") . "',1)";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() != 1) {
            return false;
        }
        return true;
    }

    function updateProductStatu($word) {
        $sql = "select statu from keywordlist where id ='$word'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($rs[0]['statu'] == 1) {
            $tmp = 0;
        } elseif ($rs[0]['statu'] == 0) {
            $tmp = 1;
        } else {
            $tmp = $rs[0]['statu'];
        }
        $sql1 = "update keywordlist set statu='$tmp' where id= '$word'";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() != 1) {
            return false;
        }
        return true;
    }

    function updateProductName($word) {
        $sql = "select product from keywordlist where id ='$word[0]'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        $tmp = $rs[0]['product'];

        $sql1 = "update keywordlist set product='$word[1]',stime='" . date("Y-m-d H:i:s", time()) . "' where product= '$tmp'";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() == 0) {
            return false;
        }
        $sql2 = "update questionbox set product='$word[1]' ,stime='" . date("Y-m-d H:i:s", time()) . "' where product= '$tmp'";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() == 0) {
            return false;
        }
        return true;
    }

    function ShowProductInfo($word) {
        $sql = "select id,kind,stime,statu from questionbox where product ='$word' order by kind";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($rs) == 0) {
            return false;
        }
        return $rs;
    }

    function updateWordStatu($word) {
        $sql = "select statu,product,kind from questionbox where id ='$word'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($rs[0]['statu'] == 1) {
            $tmp = 0;
        } elseif ($rs[0]['statu'] == 0) {
            $tmp = 1;
        } else {
            $tmp = $rs[0]['statu'];
        }
        $sql1 = "update questionbox set statu='$tmp' where id= '$word'";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() != 1) {
            return false;
        }
        $sql2 = "update keywordlist set statu='$tmp' where kind= '" . $rs[0]["kind"] . "' and product ='" . $rs[0]["product"] . "'";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() != 1) {
            return false;
        }
        return $rs[0]["product"];
    }

    function insertWord($word) {
        $sql = "select count(*) from questionbox where product ='{$word[0]}' and kind='{$word[1]}'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($rs[0]['count(*)'] != 0) {
            return false;
        }

        $sql1 = "insert into keywordlist (word,product,kind,stime,statu) values"
                . "('未设置','{$word[0]}','{$word[1]}','" . date("Y-m-d H:i:s") . "',0)";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() != 1) {
            return false;
        }

        $sql2 = "insert into questionbox (answear,product,question,kind,stime,statu) values"
                . "('未设置','{$word[0]}','未设置','{$word[1]}','" . date("Y-m-d H:i:s") . "',0)";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() != 1) {
            return false;
        }
        return $word[0];
    }

    function DeletePro($word) {
        $sql = "select product from keywordlist where id ='$word'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        $word = $rs[0]['product'];

        $sql1 = "delete from keywordlist where product='$word'";

        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() != 1) {
            return false;
        }


        $sql2 = "delete from questionbox where product='$word'";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() == 0) {
            return false;
        }
        return true;
    }

    function DeleteWord($word) {
        $sql2 = "delete from questionbox where id='$word[1]'";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() != 1) {
            return false;
        }
        return $word[0];
    }

    //0:product;1:id;2:answear;3:qustion;4:kind;5:word;6orkind;
    function updateWordInfo($word) {
        $sql1 = "update keywordlist set word='$word[5]',stime='" . date("Y-m-d H:i:s", time()) . "',kind='$word[4]' where product= '$word[0]' and kind='$word[6]'";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        if ($sth1->rowCount() == 0) {
            return false;
        }

        $sql2 = "update questionbox set "
                . "stime='" . date("Y-m-d H:i:s", time()) . "',answear='{$word[2]}',question='{$word[3]}',kind='$word[4]'"
                . "where id= '$word[1]'";
        $sth2 = $this->db->prepare($sql2);
        $sth2->execute();
        if ($sth2->rowCount() == 0) {
            return false;
        }
        return $word[0];
    }

    //0:product;1:id;2:answear;3:qustion;4:kind;5:word;6：rekind;
    function getWordInfo($word) {
        $sql = "select answear,question,kind,product from questionbox where id ='$word'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);

        $sql1 = "select word from keywordlist where product ='" . $rs[0]['product'] . "' and kind ='" . $rs[0]['kind'] . "'";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();
        $rs1 = $sth1->fetchAll(PDO::FETCH_ASSOC);

        $res = array("product" => $rs[0]['product'], "id" => $word, "answear" => $rs[0]['answear'], "question" => $rs[0]['question'], "kind" => $rs[0]['kind'], "word" => $rs1[0]['word']);

        return $res;
    }

    //log

    function getLoglistdb($where, $sqllist) {
        $sql = "select * from $sqllist where $where order by stime desc";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    }

    function saveLogdb($email, $ua, $ip) {
        $sql1 = "insert into $this->sqllist (product,email,kind,stime,ua,ip,list) values"
                . "('" . $_SESSION['product'] . "','{$email}','" . $_SESSION['kind'] . "','" . date("Y-m-d H:i:s") . "','{$ua}','{$ip}','" . $_SESSION['list'] . "')";
        $sth1 = $this->db->prepare($sql1);
        $sth1->execute();

        $_SESSION['list'] = "用户记录：<br/>";
        if ($sth1->rowCount() == 1) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    function getLogComdb($sqllist, $id) {
        $sql = "select list from $sqllist where id='{$id}'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $rs = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $rs[0]['list'];
    }

}

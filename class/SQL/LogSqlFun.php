<?php

/*
  2016-08-10 hkhking
  sqldb extend,the function of logs use
 */

trait LogSqlFun {

    function getLoglistdb($where, $sqllist) {
        $time = "";
        $list = "";
        $data=array();
        if (isset($where)) {
            if (array_key_exists("startT", $where)) {
                $data[':startT'] = $where['startT'] . " 00:00:00";
                $data[':stopT'] = $where['stopT'] . " 23:59:59";
                unset($where['startT']);
                unset($where['stopT']);
                $time = "stime between :startT and :stopT ";
            }
            foreach ($where as $k => $v) {
                $list.="$k=:$k and ";
                $data[":" . $k] = $v;
            }
            if (empty($time)) {
                $list = substr($list, 0, -4);
            }
            $sql = "select * from $sqllist where $list $time order by stime desc";
        } else {
            $sql="select * from $sqllist order by stime desc limit 100";
        }

        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, $data)) {
            return false;
        }
        return $rs;
    }

    function saveLogdb($email, $ua, $ip) {
        $sql = "insert into " . self::$sqllist . " (product,email,kind,stime,ua,ip,list) values (?,?,?,?,?,?,?)";

        $data = array(
            $_SESSION['product'],
            $email,
            is_array($_SESSION['kind']) ? implode(",", $_SESSION['kind']) : $_SESSION['kind'],
            date("Y-m-d H:i:s"),
            $ua,
            $ip,
            $_SESSION['list']
        );

        if (!$rs = sqldb::$sqlcon['MYSQL']->queryNum($sql, $data, 1, 1, 2)) {
            return false;
        }

        return $rs;
    }

    function getLogComdb($sqllist, $id) {
        $sql = "select list from ? where id=?";
        $data = array($sqllist, $id);
        if (!$rs = sqldb::$sqlcon['MYSQL']->query($sql, $data)) {
            return false;
        }
        return $rs[0]['list'];
    }

}

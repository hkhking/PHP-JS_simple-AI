<?php

/*
  2016-08-10 hkhking
  Data control
  Database instance


 */

class DControl {

    private static $configpath = "conf/resource.conf.php";
    static $config = null;

    static function getFun($a) {
        if (isset(self::$config) || empty(self::$config)) {
            self::$config = include(self::$configpath);
        }
        //return self::$config[$a];
        switch ($a) {
            case "MC":
                return new memcahecreate();
            case "MYSQL":
                return new mysqlcreate();
            default:
                echo "dcontrol error";
                exit;
        }
    }

}

interface IControl {

    function getRes();
}

class memcahecreate implements IControl {

    private static $mcdb = null;

    function getRes() {
        return DControl::$config['MC'];
    }

    function __construct() {
        if (!isset(self::$mcdb) || empty(self::$mcdb)) {
            $dbInfo = $this->getRes();
            try {
                self::$mcdb = new Memcache;
                self::$mcdb->connect($dbInfo['host'], $dbInfo['port']);
            } catch (exception $e) {
                return false;
            }
        }
        return true;
    }

    function flush() {
        self::$mcdb->flush();
    }

    function get($key) {
        return self::$mcdb->get($key);
    }

    function set($k, $v, $e, $f) {
        return self::$mcdb->set($k, $v, $f, $e);
    }

}

class mysqlcreate implements IControl {

    private static $db = null;

    function getRes() {
        return DControl::$config['MYSQL'];
    }

    function __construct() {
        if (!isset(self::$db) || empty(self::$db)) {
            $dbInfo = $this->getRes();
            try {
                self::$db = new PDO($dbInfo['dsn'], $dbInfo['user'], $dbInfo['pass']);
                self::$db->exec("SET NAMES UTF8");
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                return false;
            }
        }
        return true;
    }

    function query($sql, $data = array(), $debug = 0) {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($data);
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($rs) === 0) {
//            var_dump($data);
//            var_dump($sql);
//             var_dump($rs);
            return false;
        }
        return $rs;
    }

    /* type: 1:equal 2:over 3:less than 4:unequal
      callfun: 1:return reseult 2:return last Insert id
     */

    function queryNum($sql, $data = [], $n, $type = 1, $callfun = 1, $debug = 1) {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($data);
        $rs = $stmt->rowCount();
        switch ($type) {
            case 1:
                if (!($rs== $n)) {
                    return false;
                }
                break;
            case 2:
                if (!($rs > $n)) {
                     return false;
                }
                break;
            case 3:
                if (!($rs < $n)) {
                    return false;
                }
                break;
            case 4:
                if (!($rs != $n)) {
                    return false;
                }
                break;
        }

        switch ($callfun) {
            case 1:
                return $rs;
            case 2:
                return self::$db->lastInsertId();
        }
    }

}

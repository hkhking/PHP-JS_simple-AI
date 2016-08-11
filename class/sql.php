<?php

/**
 * 数据库控制类
   
 * @author hkhking hkhking@outlook.com
 * @date 2016-10-10
 */
date_default_timezone_set("Asia/Shanghai");
include 'DControl.php';
include 'SQL\MainSqlFun.php';
include 'SQL\AdminSqlFun.php';
include 'SQL\LogSqlFun.php';
include 'MC\MCFun.php';

class sqldb extends DControl{

	use MainSqlFun,AdminSqlFun,LogSqlFun,MCFun;

    private static $sqllist = null;
	
	private static $sqldb=null;
	
	private static $sqlcon=array();
	
	private function __construct(){}
	
	private function  __clone(){}
	
	
	static function  getInstance($a){
	
		if(!(self::$sqldb Instanceof self)){
			self::$sqldb=new self;
		}

		if(!self::$sqlcon[$a]=parent::getFun($a)){
				return false;
		}
		self::$sqllist = date("Y", time()) . "log";
		
		return self::$sqldb;
	}
}

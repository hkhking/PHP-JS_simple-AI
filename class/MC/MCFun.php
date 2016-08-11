<?php
/*	2016-08-11 hkhking
    sqldb extends,the function of memcache
*/

trait MCFun{
	function flush(){
		sqldb::$sqlcon['MC']->flush();
	}
	
	function get($key){
		sqldb::$sqlcon['MC']->get($key);
	}
	
	function set($k,$v,$e=0,$f=0){
		sqldb::$sqlcon['MC']->set($k,$v,$e,$f);
	}
}  
	
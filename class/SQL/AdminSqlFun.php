<?php
/*
	2016-08-10 hkhking
	sqldb extend,the function of admin's use 
	support mysql
*/

trait AdminSqlFun{
	 function getProductList() {
        $sql = "select id,product,stime,statu from keywordlist where kind ='NoWord'";
        if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql)){
			return false;
		}
        return $rs;
     }

     function insertProduct($word) {
        $sql = "select count(*) from keywordlist where product =?";
        if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word))){
			return false;
		}
        if ($rs[0]['count(*)'] != 0) {
            return false;
        }

        $sql1 = "insert into keywordlist (word,product,kind,stime,statu) values"
                . "('没有关键字',?,'NoWord',?,0)";
	
    	$data1=array(
				$word,
				date("Y-m-d H:i:s")
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,1,4)){
			return false;
		}
		

        $sql2 = "insert into questionbox (answear,product,question,kind,stime,statu) values"
                . "('没有关键字',?,'没有关键字','NoWord',?,1)";
     
		$data2=array(
				$word,
				date("Y-m-d H:i:s")
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,1,4)){
			return false;
		}
		
        return true;
    }

    function updateProductStatu($word) {
        $sql = "select statu,product from keywordlist where id =?";
        if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word))){
			return false;
		}
        if ($rs[0]['statu'] == 1) {
            $tmp = 0;
        } elseif ($rs[0]['statu'] == 0) {
            $tmp = 1;
        } else {
            $tmp = $rs[0]['statu'];
        }
		
        $sql1 = "update keywordlist set statu=? where product=?";
		
		$data1=array(
				$tmp,
				$rs[0]['product']
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,0,1)){
			return false;
		}

        return true;
    }

    function updateProductName($word) {
        $sql = "select product from keywordlist where id =?";
        if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word[0]))){
			return false;
		}
        $tmp = $rs[0]['product'];

        $sql1 = "update keywordlist set product=?,stime=? where product= ?";

		$data1=array(
				$word[1],
				date("Y-m-d H:i:s", time()),
				$tmp
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,0,1)){
			return false;
		}
		
		
        $sql2 = "update questionbox set product=? ,stime=? where product= ?";	
		$data2=array(
				$word[1],
				date("Y-m-d H:i:s", time()),
				$tmp
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,0,1)){
			return false;
		}
		
        return true;
    }

    function ShowProductInfo($word) {
        $sql = "select id,kind,stime,statu from questionbox where product =? order by kind";
      	if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word))){
			return false;
		}
        return $rs;
    }

    function updateWordStatu($word) {
        $sql = "select statu,product,kind from questionbox where id = ?";
       	if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word))){
			return false;
		}
        if ($rs[0]['statu'] == 1) {
            $tmp = 0;
        } elseif ($rs[0]['statu'] == 0) {
            $tmp = 1;
        } else {
            $tmp = $rs[0]['statu'];
        }
		
        $sql1 = "update questionbox set statu=? where id= ?";		
		$data1=array(
				$tmp,
				$word
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,1,4)){
			return false;
		}
		
	
        $sql2 = "update keywordlist set statu=? where kind= ? and product =?";
		$data2=array(
				$tmp,
				$rs[0]["kind"],
				$rs[0]["product"]
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,1,4)){
			return false;
		}
		
		
        return $rs[0]["product"];
    }

    function insertWord($word) {
        $sql = "select count(*) from questionbox where product =? and kind=?";
       	if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,$word)){
			return false;
		}

        $sql1 = "insert into keywordlist (word,product,kind,stime,statu) values ('未设置',?,?,?,0)";
		$data1=array(
				$word[0],
				$word[1],
				date("Y-m-d H:i:s")
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,1,4)){
			return false;
		}


        $sql2 = "insert into questionbox (answear,product,question,kind,stime,statu) values ('未设置',?,'未设置',?,?,0)";
		$data2=array(
				$word[0],
				$word[1],
				date("Y-m-d H:i:s")
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,1,4)){
			return false;
		}
		
		
		
        return $word[0];
    }

    function DeletePro($word) {
        $sql = "select product from keywordlist where id =?";
        if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word))){
			return false;
		}
        $word = $rs[0]['product'];

        $sql1 = "delete from keywordlist where product=?";
		$data1=array(
				$word
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,1,4)){
			return false;
		}

        $sql2 = "delete from questionbox where product=?";	
		$data2=array(
				$word
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,0,1)){
			return false;
		}
		
        return true;
    }

    function DeleteWord($word) {
        $sql2 = "delete from questionbox where id=?";
		$data2=array(
				$word[1],
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,1,4)){
			return false;
		}
		
        return $word[0];
    }

    //0:product;1:id;2:answear;3:qustion;4:kind;5:word;6orkind;
    function updateWordInfo($word) {
        $sql1 = "update keywordlist set word=?,stime=?,kind=? where product= ? and kind=?";
		$data1=array(
				$word[5],
				date("Y-m-d H:i:s"),
				$word[4],
				$word[0],
				$word[6]
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql1,$data1,0,1)){
			return false;
		}
		

        $sql2 = "update questionbox set  stime=?,answear=?,question=?,kind=? where id= ?";
		$data2=array(
				date("Y-m-d H:i:s"),
				$word[2],
				$word[3],
				$word[4],
				$word[1]
		);
		
		if(sqldb::$sqlcon['MYSQL']->queryNum($sql2,$data2,0,1)){
			return false;
		}
		
        return $word[0];
    }

    //0:product;1:id;2:answear;3:qustion;4:kind;5:word;6：rekind;
    function getWordInfo($word) {
        $sql = "select answear,question,kind,product from questionbox where id =?";
        if(!$rs=sqldb::$sqlcon['MYSQL']->query($sql,array($word))){
			return false;
		}

        $sql1 = "select word from keywordlist where product =? and kind =?";
		$data=array($rs[0]['product'],$rs['0']['kind']);
        if(!$rs1=sqldb::$sqlcon['MYSQL']->query($sql1,$data)){
			return false;
		}

        $res = array(
				"product" => $rs[0]['product'],
				"id" => $word, 
				"answear" => $rs[0]['answear'], 
				"question" => $rs[0]['question'],
				"kind" => $rs[0]['kind'], 
				"word" => $rs1[0]['word']
			   );

        return $res;
    }
}

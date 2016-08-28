<?php

/*
 * 2016-08-27 hkhking
 * base config
 */
session_set_cookie_params(12 * 60 * 60); //设置cookie的有效期
session_cache_expire(12 * 60 * 60); //设置session的有效期
session_start();
date_default_timezone_set("PRC");

include_once "class/sql.php";
include_once 'class/Ccontrol.php';


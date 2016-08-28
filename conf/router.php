<?php

/*
 * 2016-08-26 hkhking
 * router resource
 */

return array(
    "tmpl" => array(
        "index" => "tmpl/index.php",
        "login" => "tmpl/login.php",
        "admin" => array(
            "admin" => "tmpl/admin.php",
            "adminlog" => "tmpl/adminLog.php"
        )
    ),
    "control"=>array(
        "adminapi"=>array("AdminApi","control/AdminApi.php"),
        "answerapi"=>array("AnswerApi","control/AnswerApi.php"),
        "chkuser"=>array("ChkUser","control/ChkUser.php"),
        "logapi"=>array("LogApi","control/LogApi.php")
    )
);

<!--
/**
 * im 客服系统
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-18
 */
-->
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>IM系统测试</title>
<!--<style type="text/css">
.divline{border:1px solid #009999} 
ol p{width: 100%;text-align: right;}
ol p span{color:red;font-weight: bolder;}
li.answear p{text-align: left}
</style>-->
    <link rel="stylesheet" href="/style/jqui.css">
 <link href="style/CustomService20150304.css" rel="stylesheet" type="text/css"/>
<script src="/js/jq.js" type="text/javascript"></script>
<script src="/js/jqm.js" type="text/javascript"></script>
<script src="/js/jqui.js"></script>

<script src="/js/index.js" type="text/javascript"></script>
 
</head>
<body>
<!-- header -->
<div class="header">
  <div class="headercontent">
    <div class="slogan"><a href="#" title="">现在由机器人小浪为您提供服务！</a></div>
    <div class="logoright"><a href="#" title="">新浪在线帮助</a></div>
  </div>
</div>
<!-- header end -->
<!-- middle  -->
<div class="middle">
  <!-- left 聊天框 -->
  <div class="left">
    <!--留言列表-->
    <div class="wordMsg">
      <div id="imContents">
        <!--客服留言-->
        <div class="wordMsgServe">
          <!--头像-->
          <div class="wordMsgFace">
            <img src="images/sinaicon.jpg" alt=""/>
            <span class="wordMsgMaster">遮罩</span>
          </div>
          <!--头像 end-->
          <!--内容-->
          <div class="wordContent">
            <!--wordMain-->
            <div class="wordMain">
              <span class="wordArrwoLeft">箭头</span>
              <!--wordInfor-->
              <div class="wordInfor">
                您好，我是机器人小浪，很高兴为您服务，您可以向我提问，我会竭尽全力回复您。
              </div>
              <!--wordInfor end-->
            </div>
            <!--wordMain end-->
          </div>
          <!--内容 end-->
        </div>
        <!--客服留言 end-->
      </div>
    </div>
    <!--留言列表 end-->
    <!-- 选择产品 -->
    <div class="product">
      <a href="javascript:;" title="" class="more" id="imProductCurrent">产品：<span></span></a>
      <!-- 选择产品浮层 -->
      <div class="productlist" id="imProductList"></div>
      <!-- 选择产品浮层 end -->
    </div>
    <!-- 选择产品 end -->
    <!-- 输入框 -->
    <div class="inputarea">
      <textarea name="sendMsg" cols="" rows="" class="inputMsg" id="inputMsg" disabled></textarea>
    </div>
    <!-- 输入框 end -->
    <div class="sendblank">
      <div class="down" id="closeWin"><a href="javascript:;">结束通话</a></div>
      <div class="send" id="sendQuestion"><a href="#">发送</a></div>
      <div class="sendmethod" id="sendTypeSelect"><a href="#">发送方式</a></div>
      <!-- 发送方式浮层  -->
      <div class="productlist sendmethodlist" id="sendTypeList">
        <ul>
          <li class="current" data-ctrl="false"><a href="javascript:;" title="">使用enter键发送</a></li>
          <li data-ctrl="true"><a href="javascript:;" title="">使用ctrl+enter键发送</a></li>
        </ul>
      </div>
      <!-- 发送方式浮层 end -->
    </div>
  </div>
  <!-- left end -->
  <!-- right -->
  <div class="right">
    <div class="questions">
      <h2>常见问题</h2>
      <ul>
        <li><a href="" title="">更多常见问题请查看帮助中心</a></li>
        <li><a href="" title="">免费邮箱如何更改邮箱密码？</a></li>
        <li><a href="" title="">免费邮箱的密码忘记如何查询？</a></li>
        <li><a href="" title="">如何设置或修改安全邮箱？</a></li>
        <li><a href="" title="">如何设置或修改免费邮箱的安全手机？</a></li>
        <li><a href="" title="">如何修改免费邮箱的密码查询</a></li>
      </ul>
    </div>
    <!-- 广告 -->
    <div class="ads">
      <iframe src="adExtend.html" width="306" height="333" scrolling="no" frameborder="0"></iframe>
    </div>
    <!-- 广告 end -->
  </div>
  <!-- right end -->
  <!-- 联系方式 -->
  <div class="servecontact">
    <div class="serveetel"><p>客服电话：<span>4006 900 000</span></p></div>
    <div class="serveemail"><p>客服邮箱：<span>kefu@vip.sina.com</span></p></div>
  </div>
  <!-- 联系方式 end -->
</div>
<!-- middle end -->
<script type="text/javascript" charset="utf-8" src="js/kf.js"></script>
</body>
<!--<body>
         <header>
            <h1>IM系统测试</h1>
        </header>
        <div id='text' class="divline" style="width: 100%;height: 45%;overflow:auto;">
            <ol>
                <li>欢迎使用新浪IM系统</li>
                <span id="flag"></span>
            </ol>
        </div>
    <hr/>
    <textarea id="text2" class="divline" style="width: 100%;height: 30%;" ></textarea>
    <input type="button" value="提交" id="SUB" />
</body>-->
</html>
 



 

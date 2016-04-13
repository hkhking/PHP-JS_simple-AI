<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>IM控制后台</title>
<link href="/style/admin.css" rel="stylesheet" type="text/css"></link>


<script src="//code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="/js/admin.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="/plug/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plug/ueditor.all.min.js"> </script>
 
</head>
<body>
    <div id='main'>
        <div id='header'>
            <span>IM系统管理后台</span>
        </div>
        <div id='addKey'>
            
        </div>
        <div id="ProductTable">
            
        </div>
    </div>
    <div id="showTip">
        <table><tr><td colspan="2"><h3>产品线编辑</h3><td></tr>
            <tr><td><label>产品名称：</label></td><td><label id="ProName">新浪邮箱</span><td></tr> 
            <tr><td><label>新名称：</label></td><td><input type="text" id="newProName" /></td></tr>
            <tr><td><input type="button" value="确定" id="okShowTip" class="thoughtbot"/></td>
                <td><input type="button" value="取消"  class="cancelShowTip thoughtbot"/>
                    <input type="hidden" id="ProId" /></td></tr>
        </table>
    </div>
    <div id="showTip2" style="height:500px;">
        <h3>关键字内容编辑</h3>
        <table>
            <tr><td class="title"><label>产品线：</label></td><td><label id="ProductName">新浪邮箱</label></td></tr>
            <tr><td class="title"><label>关键字类型：</label></td><td class="txt"><input id="KindType" type="text" value="无法发信"/></td></tr>
            <tr><td class="title"><label>关键字：</label></td><td class="txt"><input id="KindWord" type="text" value="无法,无法发行,"/></td></tr>
            <tr><td class="title"><label>提示问题：</label></td><td class="txt"><input id="Question" type="text" value="您是因为无法发信吗？"/></td></tr>
            <tr><td class="title"><label>提示解答：</label></td><td class="txt"><textarea id="Answear">您是因为无法发信吗？</textarea></td></tr>
            <tr><td colspan="2" class="BUT"><input id="okShowTip2" type="button" value="确定"   class="thoughtbot"/>
                <input type="button" value="取消"   class="cancelShowTip thoughtbot"/>
                <input type="hidden" id="ProductId" /><input type="hidden" id="WordKind" /></td></tr>
        </table><p style="color:yellow">注：关键字项以英文“,”间隔，最后不用加标点。</p>
    </div>
</body>
</html>

/* 
 * IM系统 后台控制
 * yunhao@staff.sina.com.cn
 * 2014-12-23
 bug:2016-08-11  edge cant use uediter
 
 */

$(document).ready(function () {
    chklogin();
    updatePro();
    var answear = UE.getEditor('Answear');
    $("#ProductTable").on("click", "a.EditWord", function () {
        var a = this.id;
        a = a.substr(8);
        var b = $("#ValueWord" + a).val();
        $.post("../control/AdminApi", {"act": "ShowEidtForm", "word": b}, function (res) {
            if (res.data !== false) {
                $("#ProductName").html(res.data.product);
                $("#KindType").val(res.data.kind);
                $("#KindWord").val(res.data.word);
                $("#WordKind").val(res.data.kind);
                $("#Question").val(res.data.question);
                $("#ProductId").val(res.data.id);

                answear.addListener("ready", function () {
                    answear.setContent(res.data.answear);
                });

                $("#showTip2").show("slow");

            } else {
                alert(res.data);
            }
        }, "json");
    });

    $("#ProductTable").on("click", "a.ShowPro", function () {
        var a = this.id;
        a = a.substr(7);
        var b = $("#NamePro" + a).val();
        $.post("../control/AdminApi", {"act": "InfoPro", "word": b}, function (res) {
            if (res.data !== false) {
                updateWord(res.data);
            } else {
                alert(res.data);
            }
        },"json");
    });


    $("#ProductTable").on("click", "a.StatuWord", function () {
        var a = this.id;
        a = a.substr(9);
        var b = $("#ValueWord" + a).val();
        $.post("../control/AdminApi", {"act": "ChangeStatuWord", "word": b}, function (res) {
            if (res.data !== false) {
                updateWord(res.data);
            } else {
                alert(res.data);
            }
        },"json");
    });



    $("#ProductTable").on("click", "a.EditPro", function () {
        var a = this.id;
        a = a.substr(7);
        var b = $("#NamePro" + a).val();
        var c = $("#ValuePro" + a).val();
        $("#ProName").html(b);
        $("#ProId").val(c);
        $("#showTip").show("slow");
    });

    $("#okShowTip").click(function () {
        var a = $.trim($("#newProName").val());
        if (a === "") {
            alert("不能为空");
            return false;
        }
        var b = $("#ProId").val();
        var c = new Array();
        c[0] = b;
        c[1] = a;
        $.post("../control/AdminApi", {"act": "UpdatePro", "word": c}, function (res) {
            if (res.data == 1) {
                alert("添加成功");
                updatePro();
                $("#showTip").hide("slow");
            } else {
                alert(res.data);
                alert("添加失败");
            }
        }),"json";
    });

    $("#okShowTip2").click(function () {
        var a = new Array();
        a[0] = $.trim($("#ProductName").html());
        a[4] = $.trim($("#KindType").val());
        a[6] = $.trim($("#WordKind").val());
        a[3] = $.trim($("#Question").val());
        a[1] = $.trim($("#ProductId").val());
        a[2] = answear.getContent();
        a[5] = $.trim($("#KindWord").val());
        for (x in a) {
            if (a[x] == "") {
                alert("内容不可为空");
                return false;
            }
        }

        if (a[5] === "NoWord") {
            if (a[4] !== a[5]) {
                alert("预设值“NoWord”不能修改");
                return false;
            }
        }

        $.post("../control/AdminApi", {"act": "UpdateWord", "word": a}, function (res) {
            if (res !== "ERROR") {
                alert("修改成功");
                updateWord(res.data);
                $("#showTip2").hide("slow");
            } else {
                alert(res.data);
                alert("添加失败");
            }
        },"json");
    });

    $("#ProductTable").on("click", "a.StatuPro", function () {
        var a = this.id;
        a = a.substr(8);
        var b = $("#ValuePro" + a).val();
        $.post("../control/AdminApi", {"act": "ChangeStatu", "word": b}, function (res) {
            if (res.data) {
                updatePro();
            } else {
                alert(res.data);
            }
        },"json");
    });

    $("#ProductTable").on("click", "a.DelPro", function () {
        var a = this.id;
        a = a.substr(6);
        var c = $("#NamePro" + a).val();
        var txt = "确定删除产品线：" + c;
        var statu = confirm(txt);
        if (!statu) {
            return false;
        } else {
            var b = $("#ValuePro" + a).val();
            $.post("../control/AdminApi", {"act": "DelPro", "word": b}, function (res) {
                if (res.data == 1) {
                    updatePro();
                } else {
                    alert(res.data);
                }
            },"json");
        }
    });

    $("#ProductTable").on("click", "a.DelWord", function () {
        var a = this.id;
        a = a.substr(7);
        var c = $("#NameKey" + a).html();
        var txt = "确定删除关键字？：" + c;
        var statu = confirm(txt);
        if (!statu) {
            return false;
        } else {
            var b = new Array();
            b[0] = $("#NameWord").val();
            b[1] = $("#ValueWord" + a).val();
            $.post("../control/AdminApi", {"act": "DelWord", "word": b}, function (res) {
                if (res.data !== "ERROR") {
                    updateWord(res.data);
                } else {
                    alert(res.data);
                    alert("删除失败");
                }
            },"json");
        }
    });

    $("#addKey").on("click", "#SUBBUT", function () {
        var a = $.trim($("#SUBAddKey").val());
        if (a === "") {
            alert("不能为空");
            return false;
        }
        var txt = "确定添加产品线：" + a + "?";
        var statu = confirm(txt);
        if (!statu) {
            return false;
        } else {
            $.post("../control/AdminApi", {"act": "AddPro", "word": a}, function (res) {
                if (res.data == 1) {
                    alert("添加成功");
                    updatePro();
                } else {
                    alert(res.data);
                    alert("添加失败");
                }
            },"json");
        }
    });

    $("#addKey").on("click", "#SUBBUTWord", function () {
        var a = new Array();
        a[0] = $("#NameWord").val();
        a[1] = $.trim($("#SUBAddKey").val());
        if (a[1] === "") {
            alert("不能为空");
            return false;
        }
        var txt = "确定添加关键字类型：" + a + "?";

        var statu = confirm(txt);
        if (!statu) {
            return false;
        } else {
            $.post("../control/AdminApi", {"act": "AddWord", "word": a}, function (res) {
                if (res !== "ERROR") {
                    updateWord(res.data);
                } else {
                    alert(res.data);
                    alert("添加失败");
                }
            },"json");
        }
    });





    $(".cancelShowTip").click(function () {
        $("#showTip").hide("slow");
        $("#showTip2").hide("slow");
    });
    $("#addKey").on("click", "#CBP", function () {
        updatePro();
    });
});

function updateWord(res) {
    var tmp = "<label for='SUBAddKey'>关键字类型名称：</label><input type='text' name='SUBText' id='SUBAddKey'/>" +
            "<input type='button' value='添加' id='SUBBUTWord' class='thoughtbot'/><input type='button' value='返回' id='CBP' class='thoughtbot'/>";
    $("#addKey").html(tmp);
    $("#ProductTable").html(res);
}

function updatePro() {
    var tmp = "<label for='SUBAddKey'>产品线名称：</label><input type='text' name='SUBText' id='SUBAddKey'/>" +
            "<input type='button' value='添加' id='SUBBUT' class='thoughtbot'/>";
    $("#addKey").html(tmp);

    $.post("../control/AdminApi", {"act": "Index"}, function (res) {
        if (!res.data) {
            res.data = "<h3>无产品线，请添加</h3>";
        }
        $("#ProductTable").html(res.data);
    },"json");
}

function chklogin() {
    $.post("../control/ChkUser", {"act": 1,"word":"a"}, function (res) {
        if (!res.result) {
            alert(res.msg);
            location.href = res.data;
        }
    }, "json");
}
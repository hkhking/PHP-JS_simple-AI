/* 
 * IM系统 后台查询
 * yunhao@staff.sina.com.cn
 * 2014-12-26
 */

$(document).ready(function () {
    chklogin();
    getHeaderContorl();

    $("#LogList").on("click", "a.CHKList", function () {
        var a = this.id;
        var b = a.substr(2)
        var c = b.split("_");
        $.post("../control/LogApi", {"act": 2, "id": c[0], "sqldb": c[1]}, function (res) {
            $("#showTip3").html(res.data.com);
            $("#tip").show("slow");
        }, "json");
    });

    $("#showTip3Head").click(function () {
        $("#tip").hide("slow");
    });

    $("#addKey").on("change", "#SelPro", function () {
        var a = $("#SelPro").val();
        if (a == "all") {
            $("#SelKind").html("<option id='OptKind' value='all'>问题分类</option>");
        } else {
            $.post("../control/LogApi", {"act": 3, "product": a}, function (res) {
                $("#SelKind").html(res.data.kind);
            }, "json");
        }

    });

    $("#addKey").on("click", "#ExportList", function () {
        //var url='../control/LogApi.php?a=5';
        location.href = url;
    });

    $("#addKey").on("click", "#SUBBUT", function () {
        var a = $("#SelPro").val();
        var b = $("#SelKind").val();
        var c = $("#help").val();
        var d = $("#StartT").val();
        var e = $("#StopT").val();
        if (d == "" || e == "") {
            alert("请选择查询时间");
            return false;
        }
        $.post("../control/LogApi", {"act": 1, "product": a, "kind": b, "help": c, "startT": d, "stopT": e}, function (res) {
            if (res.code == 10) {
                alert(res.msg);
                return false;
            }
            $("#LogList").html(res.data.list);
            if (res.data.total != 0) {
                $("#Total").html("共 " + res.data.total + " 条");
                $("#page").html("第 " + res.data.onList + " 页");
            }
            $("#footer").html(res.data.page);
        }, "json");
    });

    $("#footer").on("click", "a.ChangePape", function () {
        var a = this.id;
        $.post("../control/LogApi", {"act": 4, "page": a}, function (res) {
            $("#LogList").html(res.data.list);
            $("#page").html("第 " + res.data.onList + " 页");
        }, "json");
    });

});

function getHeaderContorl() {
    $.post("../control/LogApi", {"act": 0}, function (res) {
        $("#addKey").html(res.data.head);
        $("#LogList").html(res.data.list);
        if (res.data.total != 0) {
            $("#Total").html("共 " + res.data.total + " 条");
            $("#page").html("第 " + res.data.onList + " 页");
        }
        if (res.data.page != 1) {
            $("#footer").html(res.data.page);
        }
        $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
    }, "json");
}

function chklogin() {
    $.post("../control/ChkUser", {"act": 1, "word": "b"}, function (res) {
        if (!res.result) {
            alert(res.msg);
            location.href = res.data;
        }
    }, "json");
}
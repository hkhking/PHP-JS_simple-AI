<?php

/**
 * 产品线控制类
 * @author hkhking hkhking@outlook.com
 * @date 2014-12-23
 * 
 */

trait Product {

    function ShowEditForm() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->getWordInfo($this->word);
        if (!is_array($res)) {
            return false;
        }
        return $res;
    }

    function UpdateWord() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->updateWordInfo($this->word);
        return $res;
    }

    function AddWord() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->insertWord();
        return $res;
    }

    function DelPro() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->DeletePro($this->word);
        return $res;
    }

    function DelWord() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->DeleteWord($this->word);
        return $res;
    }

    function WordChangeStatu() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->updateWordStatu($this->word);
        return $res;
    }

    function InfoPro($res) {
        if (is_null($res)) {
            return false;
        }
        $tmp = $this->db->ShowProductInfo($res);
        $tmpl = "<input type='hidden' id='NameWord' value='" . $res . "'/><table border='1'><tr><th>序号</th><th>关键字类型</th><th>操作时间</th><th>状态</th><th>操作</th></tr>";
        if ($tmp) {
            $i = 1;
            foreach ($tmp as $v) {
                $statu = $v['statu'] == 0 ? "非预设" : "预设项";
                if ($v['kind'] === "NoWord") {
                    $tmpl.="<tr><td>$i</td><td>没有关键字</td><td>" . $v['stime'] . "</td><td>$statu</td>"
                            . "<td><a href='###' id='editWord$i' class='EditWord'>编辑</a>"
                            . "<input type='hidden' id='ValueWord$i' value='" . $v['id'] . "'/></tr>";
                } else {
                    $tmpl.="<tr><td>$i</td><td id='NameKey$i'>" . $v['kind'] . "</td><td>" . $v['stime'] . "</td><td>$statu</td>"
                            . "<td><a href='###' id='editWord$i' class='EditWord'>编辑</a>"
                            . "<a href='###' id='StatuWord$i' class='StatuWord'>状态</a>"
                            . "<a href='###' id='DelWord$i' class='DelWord'>删除</a><input type='hidden' id='ValueWord$i' value='" . $v['id'] . "'/>"
                            . "</td></tr>";
                }
                $i++;
            }
            $tmp= $tmpl . "</table>";
        }
        return $tmp;
    }

    function ProUpdateName() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->updateProductName($this->word);
        return $res;
    }

    function ProChangeStatu() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->updateProductStatu($this->word);
        return $res;
    }

    function AddProduct() {
        if (is_null($this->word)) {
            return false;
        }
        $res = $this->db->insertProduct($this->word);
        return $res;
    }

    function ShowProductList() {
        $tmpl = "<table border='1'><tr><th>序号</th><th>产品线名称</th><th>操作时间</th><th>状态</th><th>操作</th></tr>";
        $res = $this->db->getProductList();
        if ($res) {
            $i = 1;
            foreach ($res as $v) {
                $statu = $v['statu'] == 0 ? "隐藏" : "使用中";
                $tmpl.="<tr><td>$i</td><td>" . $v['product'] . "</td><td>" . $v['stime'] . "</td><td>$statu</td>"
                        . "<td><a href='###' id='ShowPro$i' class='ShowPro'>查看</a>"
                        . "<a href='###' id='editPro$i' class='EditPro'>编辑</a>"
                        . "<a href='###' id='StatuPro$i' class='StatuPro'>状态</a>"
                        . "<a href='###' id='DelPro$i' class='DelPro'>删除</a><input type='hidden' id='ValuePro$i' value='" . $v['id'] . "'/>"
                        . "<input type='hidden' id='NamePro$i' value='" . $v['product'] . "'/></td></tr>";
                $i++;
            }
            $res = $tmpl . "</table>";
        }
        return $res;
    }

    function delMC() {
        $this->mc->flush();
    }

}

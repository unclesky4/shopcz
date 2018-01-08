<?php 
/**
 * 辅助函数类
 * User: Levi
 * Date: 2017/2/8
 * Time: 15:05
 */
//批量实体转义
function deepspecialchars($data)
{
    if (empty($data)) {
        return $data;
    }
//    if(is_array($data)){
//        //数组
//        foreach($data as $k=>$v){
//            $data[$k]=deepspecialchars($v);
//        }
//        return $data;
//    }else{
//        //单个变量
//        return htmlspecialchars($data);
//    }
    //中高级程序员的写法
    return is_array($data) ? array_map("deepspecialchars", $data) : htmlspecialchars($data);
}

//批量 addslashes() 函数返回在预定义字符之前添加反斜杠的字符串。
function deepslashes($data)
{
    if (empty($data)) {
        return $data;
    }
//    if(is_array($data)){
//        //数组
//        foreach($data as $k=>$v){
//            $data[$k]=deepspecialchars($v);
//        }
//        return $data;
//    }else{
//        //单个变量
//        return htmlspecialchars($data);
//    }
    //中高级程序员的写法
    return is_array($data) ? array_map("deepslashes", $data) : addslashes($data);
}

//批量 实体和单体转义处理
function deephandlechars($data){
    $data=deepspecialchars($data);
    $data=deepslashes($data);
    return $data;
}

//test
function test() {
    echo "辅助函数的加载";
}
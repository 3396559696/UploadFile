<?php

function mylink($sever,$user,$password,$database,$port){
    $conn = @mysqli_connect($sever,$user,$password,$database,$port) or die('连接服务器失败！');
//    mysqli_select_db($conn,$database) or die ('数据库连接失败');
    return $conn;
}


$conn = mysqli_connect('127.0.0.1','root','123456','file','3306') or die("数据库连接失败！");
mysqli_set_charset($conn,'utf8');
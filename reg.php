<?php
session_start();
$username =trim($_POST['nickname']);
$password =trim($_POST['ps']);
$confirmpw =trim($_POST['cps']);
$email =trim($_POST['email']);
$sex =@$_POST['sex'];
$fav =@$_POST['hobby'];


if (is_array($fav) && !empty($fav)) {
    $favStr = implode(';', $fav);
}
//echo join(';',$fav);
var_dump($_POST);
include('function.php');
//require('function.php');
$conn=mylink('localhost', 'root', '123456', 'file','3306');

if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
echo "连接成功";

if ($password != $confirmpw){
    echo "<script>window.parent.remind('两次密码不一致');</script>";
    exit;
}
else if ($username == '' || $password == '' || $confirmpw == '' || $email == ''){
    echo "<script>window.parent.remind('请填写完整信息');</script>";
    exit;
}

//3步走
//$conn=mysqli_connect('localhost','root','') or die('链接服务器失败');
//mysqli_select_db($conn,'user') or die('数据库不存在');
//mysqli_set_charset($conn,'utf8');

//判断用户名是否存在
$sql_sele="select * from user where name = '$username'";
$res=mysqli_query($conn,$sql_sele);
if(mysqli_num_rows($res)){
    echo "<script>window.parent.remind('用户名已存在，请重新输入!')</script>";
    exit;
}else{

    $password=md5(md5($password));
    $sql_add="insert into user(name,password,email,sex,hobby) values('$username','$password','$email','$sex','$favStr')";
    if( mysqli_query($conn,$sql_add)){
        echo "<script>window.parent.remind('注册成功!请手动登录！');</script>";
    }else{
        echo "<script>window.parent.remind('注册失败，请稍后再试!');location.href='login.php';</script>";
    }
}
mysqli_close($conn);
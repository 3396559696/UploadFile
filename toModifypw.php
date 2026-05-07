<?php
session_start();
$logged=$_SESSION['logged'];
if($logged){
    echo "欢迎 $logged ";
}else{
    echo "<script>alert('请登录后修改密码');location.href='login.html';</script>";
    exit;
}
$oldpw=md5(md5(trim($_POST['oldpw'])));
$newpw=md5(md5(trim($_POST['newpw'])));

//连接数据库
include_once('function.php');
$conn=mylink('localhost', 'root', '123456', 'file','3306');

//查询前端输入密码是否正确
$sql_selepw="select * from user where password ='$oldpw' and name = '$logged'";
$result=mysqli_query($conn,$sql_selepw);
if(mysqli_num_rows($result)){
    $sql_updatepw="update user set password='$newpw' where name = '$logged' ";
    if(mysqli_query($conn,$sql_updatepw)){
        echo "<script>alert('密码修改成功');location.href='login.php';</script>";
    }else{
        echo "<script>alert('密码修改失败');location.href='index.html';</script>";
    }
}else{
    echo "<script>alert('原密码错误');history.back();</script>";
}
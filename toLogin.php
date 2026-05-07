<?php
//开启会话
session_start();
//连接数据库
include_once('function.php');
$conn=mylink('localhost', 'root', '123456', 'file','3306');

$username=trim($_POST['username']);

$password=md5(md5(trim($_POST['pw'])));
$yzcode= trim($_POST['code']);

if (!$username||!$password){
    echo "<script>window.parent.remind('用户名和密码不能为空');</script>";
}
//var_dump($_SESSION);
if($yzcode!= $_SESSION['captcha']){
    echo "<script>window.parent.remind('验证码错误！');</script>";
    exit;
}else{
//判断用户名和密码是否正确
    $sql_sele="select * from user where name='$username' and password='$password' ";
    $result=mysqli_query($conn,$sql_sele);
    if(mysqli_num_rows($result)){
            $_SESSION['logged']=$username;
        $sql = "SELECT stats FROM user WHERE name = '$username'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['stats'] === '管理员') {
                $_SESSION['guanliyuan'] = $username; // 设置管理员会话
            } else {
                $_SESSION['guanliyuan'] = null;
            }
        }
        echo "<script>window.parent.remind('登录成功！');setTimeout(function(){window.parent.location.href='upload.php';},2000);</script>";
    }else{
        echo "<script>window.parent.remind('用户名或密码错误！');</script>";
    }
    unset($_SESSION['captcha']);
}



?>
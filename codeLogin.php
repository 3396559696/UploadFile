<?php
//开启会话
session_start();
//连接数据库
include_once('function.php');
$conn=mylink('localhost', 'root', '123456', 'file','3306');



$username=trim($_POST['username']);
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
echo "<script>window.parent.remind('登录成功！');setTimeout(function(){window.parent.location.href='upload.php';},2000);</script>";
}else{
    echo "<script>window.parent.remind('用户名或密码错误！');</script>";
}

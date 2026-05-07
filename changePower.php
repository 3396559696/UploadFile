<?php
include_once('function.php');
$conn = mylink('localhost', 'root', '123456', 'file','3306');
$username = $_POST['username'];
$num = $_POST['number'];
if ($num == 1){
    $sql_sele = "update user set stats='管理员' where name='$username'";
    $result = mysqli_query($conn, $sql_sele);
    if ($result) {
        echo "成功";
    } else {
        echo "失败";
    }
}
else if ($num == 2){
    $sql_sele = "update user set stats=null where name='$username'";
    $result = mysqli_query($conn, $sql_sele);
    if ($result) {
        echo "成功";
    } else {
        echo "失败";
    }
}
else if ($num == 3){
    $password=md5(md5('123456'));
    $sql_sele = "update user set password= '$password' where name='$username'";
    $result = mysqli_query($conn, $sql_sele);
    if ($result) {
        echo "成功";
    } else {
        echo "失败";
    }
}

mysqli_close($conn);
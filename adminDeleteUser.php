<?php
include_once('function.php');
$conn=mylink('localhost', 'root', '123456', 'file','3306');
$username = $_POST['username'];
$sql_sele= "delete from user where name='$username'";
$result=mysqli_query($conn,$sql_sele);
if($result){
    echo "成功";
}else{
    echo "失败";
}
mysqli_close($conn);



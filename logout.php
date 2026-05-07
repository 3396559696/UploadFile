<?php

//退出登录
session_start();
if(isset($_SESSION['logged'])){
    session_destroy();

}
header("location:index.html");
?>
<?php
// 数据库连接
$conn = mysqli_connect('127.0.0.1', 'root', '123456', 'file', '3306') or die('无法连接');
mysqli_select_db($conn, 'file');
mysqli_query($conn, 'SET NAMES utf8');
// 开启会话
session_start();
// 判断是否登录
if (!isset($_SESSION['logged'])) {
    echo "<script>alert('请先登录！'); location.href='login.php';</script>";
    exit;
}
$username = $_SESSION['logged']; // 获取当前用户名
$uploadDir = "userFile/" . $username . "/"; // 用户专属目录
for ($i = 0; $i < 2; $i++) {
    if (isset($_FILES['myfile'])) {
        $error = $_FILES['myfile']['error'][$i];
        // 创建用户专属文件夹（如果不存在）
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $tmp_name = $_FILES['myfile']['tmp_name'][$i];
        $name = $_FILES['myfile']['name'][$i];

        if (is_uploaded_file($tmp_name)) {
            $targetPath = $uploadDir . basename($name); // 完全保留原始文件名
            if (move_uploaded_file($tmp_name, $targetPath)) {
                echo "<script>window.parent.remind('文件上传成功!');</script>";
            } else {
                echo "<script>window.parent.remind('文件上传失败!');</script>";
            }
        }
    } else {
        echo "<script>window.parent.remind('未检测到上传文件!');</script>";
        exit;
    }
}
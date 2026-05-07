<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit("未登录");
}
$username = $_SESSION['logged'];
$file = basename($_GET['file']);
$filePath = "userfile/" . $username . "/" . $file;
if (!file_exists($filePath)) {
    exit("文件不存在");
}
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=$file"');
readfile($filePath);
exit;

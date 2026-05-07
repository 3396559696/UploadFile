<?php
session_start();
if (!isset($_SESSION['logged'])) {
    echo json_encode([]);
    exit;
}
$username = $_SESSION['logged'];
$dir = "userfile\\" . $username . "\\";
if (!is_dir($dir)) {
    echo json_encode([]);
    exit;
}
// 获取所有文件（排除 . 和 ..）
$files = array_values(array_diff(scandir($dir), ['.', '..']));
echo json_encode($files);

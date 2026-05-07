<?php
include_once('function.php');
$conn=mylink('localhost', 'root', '123456', 'file','3306');
$username = $_POST['username'];

$sql = "SELECT stats FROM user WHERE name = '$username';";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// 返回JSON格式数据
header('Content-Type: application/json');
echo json_encode($data);
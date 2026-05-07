<?php

session_start();
$conn = new mysqli('localhost', 'root', '123456', 'file','3306');

$name = $_POST['name'];


// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM user where name like '%$name%' ORDER BY name ASC;";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// 返回JSON格式数据
header('Content-Type: application/json');
echo json_encode($data);
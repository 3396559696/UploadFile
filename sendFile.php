<?php
session_start();
if (!isset($_SESSION['logged'])) {
    echo json_encode(['success' => false, 'message' => '未登录']);
    exit;
}
$username = $_SESSION['logged'];
$file = basename($_GET['file']);

// 数据库连接
$host = '127.0.0.1';
$user = 'root';
$password = '123456';
$database = 'file';
$port = 3306;
$conn = mysqli_connect($host, $user, $password, $database,$port);

if (!$conn) {
    echo json_encode([
        'success' => false,
        'message' => '数据库连接失败: ' . mysqli_connect_error()
    ]);
    exit;
}

// 查询用户邮箱
$stmt = $conn->prepare("SELECT email FROM users WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => '未找到您的邮箱地址']);
    exit;
}

$email = $result->fetch_assoc()['email'];
$stmt->close();
$conn->close();

// 构造文件路径
$filePath = "userfile/" . $username . "/" . $file;

if (!file_exists($filePath)) {
    echo json_encode(['success' => false, 'message' => '文件不存在']);
    exit;
}

// 加载 PHPMailer
require 'PHPMailer-6.10.0/src/Exception.php';
require 'PHPMailer-6.10.0/src/PHPMailer.php';
require 'PHPMailer-6.10.0/src/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->CharSet = "UTF-8";
$mail->isSMTP();
$mail->Host = 'smtp.qq.com';
$mail->SMTPAuth = true;
$mail->Username = '3396559696@qq.com';
$mail->Password = 'opdktjktlzkschig'; // 替换为你的授权码
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom('3396559696@qq.com', '文件上传官网');
$mail->addAddress($email);
$mail->isHTML(true);
$mail->Subject = '文件上传小助手';

$mail->Body = '这是您上传的文件，请查收。';
$mail->addAttachment($filePath, $file);

if (!$mail->send()) {
    echo json_encode(['success' => false, 'message' => '邮件发送失败: ' . $mail->ErrorInfo]);
} else {
    echo json_encode(['success' => true]);
}

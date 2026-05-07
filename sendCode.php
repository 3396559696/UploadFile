<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'PHPMailer-6.10.0/src/Exception.php';
require 'PHPMailer-6.10.0/src/PHPMailer.php';
require 'PHPMailer-6.10.0/src/SMTP.php';

$mail = new PHPMailer(true);
// 数据库连接
$conn = new mysqli('localhost', 'root', '123456', 'file','3306');

// 获取邮件名
$email = $_POST['email'] ?? '';

// 生成6位随机验证码
$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

// 存入 session 或数据库供后续验证使用
$_SESSION['email_code'] = $code;
$_SESSION['email_code_expires'] = time() + 300; // 验证码有效期为5分钟

try {
    // 服务器配置
    $mail->CharSet = "UTF-8";                     // 设定邮件编码
    $mail->SMTPDebug = 0;                        // 调试模式输出
    $mail->isSMTP();                             // 使用SMTP
    $mail->Host = 'smtp.qq.com';                // SMTP服务器
    $mail->SMTPAuth = true;                      // 允许 SMTP 认证
    $mail->Username = '3396559696';              // SMTP 用户名
    $mail->Password = 'opdktjktlzkschig';        // SMTP 密码
    $mail->SMTPSecure = 'ssl';                   // 允许 TLS 或者ssl协议
    $mail->Port = 465;                           // 服务器端口

    $mail->setFrom('3396559696@qq.com', '文件上传官网');  // 发件人
    $mail->addAddress($email);            // 收件人

    // 邮件内容
    $mail->isHTML(true);                         // 是否以HTML文档格式发送
    $mail->Subject = '文件上传平台注册验证码';
    $mail->Body = '<h1>您的验证码是：</h1><br><h2 style="text-align: center">' . $code . '</h2><br><h5>有效时间为5分钟，请尽快使用。</h5><h5>如果不是您本人操作，请忽略此邮件。</h5>';
    $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => '验证码已发送', 'code' => $code, 'expires' => $_SESSION['email_code_expires']]);//expires时间戳
}
catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => '发送失败，请稍后再试']);
}

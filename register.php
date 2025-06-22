<?php
// 启动 Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 显示所有错误
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 数据库连接信息
$host = "110.42.70.241";
$user = "tdfkw";
$password = "a53092520110";
$dbname = "users";

// 创建数据库连接
$conn = new mysqli($host, $user, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 获取表单数据
$username = $_POST['username'];
$password = $_POST['password'];
$qq = $_POST['qq'];

// 检查用户名是否已存在
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "用户名已存在";
} else {
    // 密码加密
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 插入新用户
    $insertSql = "INSERT INTO users (username, password, qq) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("sss", $username, $hashedPassword, $qq);

    if ($insertStmt->execute()) {
        echo "<a href='login.html'>注册成功，点击登录</a>";
    } else {
        echo "注册失败: " . $conn->error;
    }
    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>
<?php
// 启动 Session（避免重复）
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 开启错误显示（开发用）
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 连接数据库
$host = "localhost";
$user = "root";
$password = "a53092520110";
$dbname = "user_system";

$conn = new mysqli($host, $user, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取表单数据
$username = $_POST['username'];
$password = $_POST['password'];

// 检查用户名是否已存在
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "用户名已存在";
} else {
    // 哈希密码
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 插入用户
    $insertSql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ss", $username, $hashedPassword);

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

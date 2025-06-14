<?php
session_start();

// 连接数据库
$conn = new mysqli("localhost", "root", "a53092520110", "user_system");

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 数据
$username = $_POST['username'];
$password = $_POST['password'];

// 查用户
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // 密码
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "密码错误";
    }
} else {
    echo "用户不存在";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh_cn">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>糖豆方块屋官网V4</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    
  </body>
</html>
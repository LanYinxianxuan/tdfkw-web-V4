<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>你好, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <p>欢迎回来！</p>
    <a href="logout.php">登出</a>
</body>
</html>
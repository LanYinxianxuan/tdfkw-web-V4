<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
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
    <h2>你好, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <p>欢迎回来！</p>
    <a href="logout.php">登出</a>
</body>
</html>
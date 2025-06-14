<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit;
}

// 数据库连接
$conn = new mysqli("localhost", "root", "a53092520110", "user_system");
if ($conn->connect_error) {
  die("数据库连接失败: " . $conn->connect_error);
}

// 获取用户信息
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
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
    <style>
      body {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: row;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        height: 100vh;
        margin: 0;
      }
      .sider {
        
        backdrop-filter: blur(40px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
      }
      .card-qq {
        margin: 10px;
        backdrop-filter: blur(40px);
        display: flex;
        align-items: center;
        width: auto;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .qqphoto {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin-right: 15px;
      }
      .card-qq .info {
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
      .card-qq p {
        margin: 5px 0;
        color: #333;
      }
      .card-qq .username {
        font-size: 1.2em;
        font-weight: bold;
      }
      .card-qq .qq {
        font-size: 1em;
        color: #555;
      }
    </style>
  </head>
  <body>
    <div class="sider">
      <h2>糖豆方块屋官网V4仪表盘</h2>
      <div class="side-in">
        <ul>
          <li><a href="dashboard.php">仪表盘</a></li>

        </ul>
      </div>
    </div>
    <div class="card-qq">
      <img class="qqphoto" src="https://q1.qlogo.cn/g?b=qq&nk=<?php echo $user['qq']; ?>&s=100" alt="QQ头像">
      <div class="info">
        <p class="username"><?php echo htmlspecialchars($user['username']); ?></p>
        <p class="qq">QQ号: <?php echo htmlspecialchars($user['qq']); ?></p>
        <p>权限:</p>
        <p>账号状态</p>
        <p>白名单状态</p>
      </div>
    </div>
  </body>
</html>

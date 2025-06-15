<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit;
}

$conn = new mysqli("localhost", "root", "a53092520110", "user_system");
if ($conn->connect_error) { die("数据库连接失败: " . $conn->connect_error); }
$username = $_SESSION['username']; $sql = "SELECT * FROM users WHERE username =
?"; $stmt = $conn->prepare($sql); $stmt->bind_param("s", $username);
$stmt->execute(); $result = $stmt->get_result(); $user = $result->fetch_assoc();
$stmt->close(); $conn->close(); ?>
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
        margin: 0;
        font-family: Arial, sans-serif;
        height: 100vh;
      }
      .sider {
        width: 220px;
        padding: 20px;
        backdrop-filter: blur(40px);
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .sider h2 {
        text-align: center;
      }
      .sider ul {
        list-style-type: none;
        padding: 0;
      }
      .sider li {
        padding: 10px;
        margin: 10px 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
      }
      .sider a {
        color: #333;
        font-weight: bold;
        text-decoration: none;
      }
      .sider a:hover {
        text-decoration: underline;
      }
      .main-content {
        flex: 1;
        padding: 20px;
      }
      .content-section {
        display: none;
      }
      .content-section.active {
        display: block;
      }
      .qqphoto {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin-right: 15px;
      }
      .card-qq {
        background: rgba(255, 255, 255, 0.274);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
      }
      .noties {
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.274);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
      .noties h2 {
        text-align: center;
      }
      hr {
        border: 1px solid #000000;
      }
    </style>
  </head>
  <body>
    <div class="sider">
      <h2>TDFKW</h2>
      <hr />
      <ul>
        <p>导航菜单</p>
        <li><a href="#" onclick="showContent('dashboard')">仪表盘</a></li>
        <li><a href="#" onclick="showContent('status')">服务器状态</a></li>
        <li><a href="#" onclick="showContent('members')">服务器成员</a></li>
        <li><a href="#" onclick="showContent('replay')">录像文件下载</a></li>
        <li><a href="#" onclick="showContent('settings')">设置</a></li>
        <li><a href="logout.php">登出</a></li>
      </ul>
    </div>

    <div class="main-content">
      <div id="dashboard" class="content-section active">
        <div class="card-qq">
          <img
            class="qqphoto"
            src="https://q1.qlogo.cn/g?b=qq&nk=<?php echo $user['qq']; ?>&s=100"
            alt="QQ头像"
          />
          <div class="info">
            <p class="username">
              用户名:
              <?php echo htmlspecialchars($user['username']); ?>
            </p>
            <p class="qq">
              QQ号:
              <?php echo htmlspecialchars($user['qq']); ?>
            </p>
            <p>
              <?php
$op_level = htmlspecialchars($user['op']);
switch ($op_level) {
    case '1':
        $role = '普通成员';
        break;
    case '2':
        $role = '高级成员';
        break;
    case '3':
        $role = '管理员';
        break;
    case '4':
        $role = '副站长';
        break;
    case '5':
        $role = '站长';
        break;
    default:
        $role = '未知权限';
}
?>
            </p>

            <p>
              权限:
              <?php echo $role; ?>
            </p>
            <p>
              <?php
          $condition = htmlspecialchars($user['condition']);
          switch ($condition) {
              case '0':
                  $status = '正常';
                  break;
              case '1':
                  $status = '封禁';
                  break;
              default:
                  $status = '未知状态';
          }
          echo "账号状态: $status";
          ?>
            </p>
            <p>
              <?php
          $whitelist = htmlspecialchars($user['whitelist']);
          switch ($whitelist) {
              case '0':
                  $wl_status = '未添加';
                  break;
              case '1':
                  $wl_status = '已添加';
                  break;
              default:
                  $wl_status = '未知状态';
          }
          echo "白名单状态: $wl_status";
          ?>
            </p>
          </div>
        </div>
        <div class="noties">
          <h2><strong>公告</strong></h2>
          <hr>
        </div>
      </div>

      <div id="status" class="content-section">
        <h3>服务器状态</h3>
        <p>这里显示服务器在线情况等。</p>
      </div>

      <div id="members" class="content-section">
        <h3>服务器成员</h3>
        <p>这里显示所有成员信息。</p>
      </div>
      <div id="replay" class="content-section">
        <h3>录像文件下载</h3>
        <p>这里显示录像文件下载链接。</p>
      </div>

      <div id="settings" class="content-section">
        <h3>设置</h3>
        <p>用户个人信息设置或网站偏好设置。</p>
      </div>
    </div>

    <script>
      function showContent(id) {
        document.querySelectorAll(".content-section").forEach((el) => {
          el.classList.remove("active");
        });
        document.getElementById(id).classList.add("active");
      }
    </script>
  </body>
</html>

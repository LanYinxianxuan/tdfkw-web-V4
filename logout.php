<?php
session_start();
session_unset();  // 清空所有 session 变量
session_destroy();  // 销毁 session
header("Location: login.html");  // 重定向到登录页
exit();
?>

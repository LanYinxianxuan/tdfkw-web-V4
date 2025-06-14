#!/bin/bash

echo "🚀 启动网站服务中..."

# 启动 Apache 和 MariaDB
sudo service apache2 start
sudo service mariadb start

# 设置项目路径
PROJECT_DIR="$HOME/Desktop/tdfkw-web-V4"

# 设置 Apache 访问权
sudo chmod -R 755 "$PROJECT_DIR"
sudo chown -R www-data:www-data "$PROJECT_DIR"

# 初始化数据库
echo "初始化数据库..."
mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS user_system;
USE user_system;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
EOF

# 打开注册页面
echo "访问 http://localhost:8080/tdfkw-web-V4/index.html"
xdg-open "http://localhost:8080/tdfkw-web-V4/index.html" >/dev/null 2>&1 &

echo "启动完成"
# 数据库创建说明

## 步骤1：登录MySQL

使用MySQL客户端（如phpMyAdmin、MySQL Workbench或命令行）登录MySQL服务器。

## 步骤2：执行SQL语句

执行 `create_database.sql` 文件中的SQL语句，创建数据库和表结构。

### 方法1：使用命令行

```bash
mysql -u root -p < create_database.sql
```

### 方法2：使用phpMyAdmin

1. 登录phpMyAdmin
2. 点击「SQL」选项卡
3. 复制 `create_database.sql` 文件中的所有内容到文本框
4. 点击「执行」按钮

## 步骤3：验证数据库

执行以下SQL语句验证数据库和表是否创建成功：

```sql
SHOW DATABASES;
USE file;
SHOW TABLES;
SELECT * FROM user;
```

## 数据库结构说明

### 数据库名称
- `file`

### 表结构

#### `user` 表
| 字段名 | 数据类型 | 约束 | 描述 |
|-------|---------|------|------|
| `id` | `INT(11)` | `NOT NULL AUTO_INCREMENT` | 用户ID |
| `name` | `VARCHAR(50)` | `NOT NULL UNIQUE` | 用户名 |
| `password` | `VARCHAR(100)` | `NOT NULL` | 密码（加密存储） |
| `email` | `VARCHAR(100)` | `NOT NULL UNIQUE` | 邮箱 |
| `sex` | `VARCHAR(10)` | `DEFAULT NULL` | 性别 |
| `hobby` | `VARCHAR(255)` | `DEFAULT NULL` | 爱好 |
| `stats` | `VARCHAR(20)` | `DEFAULT NULL` | 状态（管理员或null） |

## 默认账号

- **用户名**：admin
- **密码**：123456
- **权限**：管理员

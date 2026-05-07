-- 创建数据库
CREATE DATABASE IF NOT EXISTS `file` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 使用数据库
USE `file`;

-- 创建用户表
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL COMMENT '用户名',
  `password` VARCHAR(100) NOT NULL COMMENT '密码（加密存储）',
  `email` VARCHAR(100) NOT NULL COMMENT '邮箱',
  `sex` VARCHAR(10) DEFAULT NULL COMMENT '性别',
  `hobby` VARCHAR(255) DEFAULT NULL COMMENT '爱好',
  `stats` VARCHAR(20) DEFAULT NULL COMMENT '状态（管理员或null）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

-- 插入默认管理员账号
INSERT INTO `user` (`name`, `password`, `email`, `sex`, `hobby`, `stats`) 
VALUES ('admin', MD5(MD5('123456')), 'admin@example.com', 'male', '管理系统', '管理员') 
ON DUPLICATE KEY UPDATE `password` = MD5(MD5('123456')), `stats` = '管理员';

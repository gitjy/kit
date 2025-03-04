create DATABASE if NOT exists rbac;

use rbac;

/** admin start ----------------- **/
DROP TABLE IF EXISTS `admin`;

create table admin(
    `id` int(11) NOT NULL UNSIGNED AUTO_INCREMENT COMMENT '管理员id',
    `username` varchar(50) NOT NULL COMMENT '管理员名',
    `password` char(32) NOT NULL COMMENT '管理员密码',
    `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) COMMENT '后台管理员表';

/** admin end ----------------->>>> **/

/** node start ----------------- **/
DROP TABLE IF EXISTS `node`;

create table node(
    `id` int(11) NOT NULL UNSIGNED AUTO_INCREMENT COMMENT '主键ID',
    `name` varchar(20) NOT NULL COMMENT '节点名称',
    `mname` VARCHAR(50) NOT NULL COMMENT '模块和控制器名称',
    `aname` VARCHAR(50) NOT NULL COMMENT '方法名称',
    `status` TINYINT UNSIGNED NOT NULL COMMENT '状态',
    `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    PRIMARY KEY (`id`),
) COMMENT '后台节点表';

/** node end ----------------->>>> **/


/** role start ----------------- **/
DROP TABLE IF EXISTS `role`;

create table role(
    `id` int(11) NOT NULL UNSIGNED AUTO_INCREMENT COMMENT '主键ID',
    `name` varchar(20) NOT NULL, COMMENT '角色名称',
    `remark` varchar(255) NOT NULL, COMMENT '角色描述信息',
    `status` TINYINT UNSIGNED NOT NULL COMMENT '状态',
    `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    PRIMARY KEY (`id`),
) COMMENT '后台角色表';

/** role end ----------------->>>> **/


/**  start ----------------- **/
DROP TABLE IF EXISTS `admin_role`;

create table admin_role(
    `id` int(11) NOT NULL UNSIGNED AUTO_INCREMENT COMMENT '主键ID',
    `admin_id`  int(11) NOT NULL UNSIGNED COMMENT '管理员ID',
    `role_id` int(11) NOT NULL UNSIGNED COMMENT '角色ID',
    `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY ()
) COMMENT '后台角色表';

/**  end ----------------->>>> **/
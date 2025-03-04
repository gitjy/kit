/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.0.51b-community-nt-log : Database - lamp74
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
USE `lamp`;
/*Table structure for table `lamp_node` */

DROP TABLE IF EXISTS `lamp_node`;

CREATE TABLE `lamp_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `aname` varchar(50) NOT NULL,
  `status` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `lamp_node` */

insert  into `lamp_node`(`id`,`name`,`mname`,`aname`,`status`) values (1,'浏览用户','user','index',1),(2,'添加用户','user','add',1),(3,'删除用户','user','delete',1),(4,'修改用户','user','edit',1),(5,'浏览角色','role','index',1),(6,'添加角色','role','add',1),(7,'删除角色','role','delete',1),(8,'编辑角色','role','edit',1),(9,'浏览节点','node','index',1),(10,'添加节点','node','add',1),(11,'删除节点','node','delete',1),(12,'修改节点','node','edit',1),(13,'浏览用户分配角色','user','rolelist',0),(14,'更改用户分配角色','user','saverole',0),(15,'浏览角色的操作权限','role','nodelist',1),(16,'修改角色中操作权限','role','savenode',1);

/*Table structure for table `lamp_role` */

DROP TABLE IF EXISTS `lamp_role`;

CREATE TABLE `lamp_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned default NULL,
  `remark` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `lamp_role` */

insert  into `lamp_role`(`id`,`name`,`status`,`remark`) values (2,'项目经理',1,'负责所有项目'),(3,'部门主任',1,'负责当期部门管理'),(4,'普通员工',0,'无'),(7,'临时工',1,'公司员工'),(8,'xiaoli',1,'普通员工');

/*Table structure for table `lamp_role_node` */

DROP TABLE IF EXISTS `lamp_role_node`;

CREATE TABLE `lamp_role_node` (
  `rid` smallint(6) unsigned NOT NULL,
  `nid` smallint(6) unsigned NOT NULL,
  KEY `groupId` (`rid`),
  KEY `nodeId` (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `lamp_role_node` */

insert  into `lamp_role_node`(`rid`,`nid`) values (2,16),(4,5),(3,7),(2,15),(2,14),(2,13),(2,12),(2,11),(4,4),(4,2),(4,1),(2,10),(2,9),(2,8),(2,7),(2,6),(2,5),(2,4),(2,3),(3,2),(2,2),(2,1),(3,13),(3,15),(4,9),(7,1),(7,5);

/*Table structure for table `lamp_stu` */

DROP TABLE IF EXISTS `lamp_stu`;

CREATE TABLE `lamp_stu` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '学生id号',
  `name` varchar(8) NOT NULL COMMENT '学生姓名',
  `age` tinyint(3) unsigned default NULL COMMENT '年龄',
  `sex` enum('m','w') NOT NULL default 'm' COMMENT '性别',
  `classid` char(6) default NULL COMMENT '班级id号',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `lamp_stu` */

insert  into `lamp_stu`(`id`,`name`,`age`,`sex`,`classid`) values (1,'zhangsan',30,'m','lamp65'),(2,'lisi3',18,'m','lamp63'),(3,'wangwu',20,'w','lamp66'),(4,'aa',24,'m','lamp65'),(5,'bb',23,'w','lamp66'),(9,'tt',23,'m','lamp67'),(10,'zhaoliu',27,'w','lamp65'),(15,'dd678',25,'m','lamp65'),(16,'tianqi',20,'m','lamp65'),(17,'tianqi2',22,'w','lamp65'),(18,'tianqi3',21,'m','lamp65'),(19,'tianqi4',22,'w','lamp65'),(21,'aa002',21,'w','lamp65'),(22,'aa005',21,'w','lamp65'),(23,'aa006',22,'m','lamp65'),(24,'aa010',22,'m','lamp66'),(25,'aa011',21,'w','lamp66'),(26,'aa012',23,'m','lamp66'),(28,'aa013',21,'w','lamp66'),(29,'aa014',23,'m','lamp66'),(31,'aa030',22,'m','lamp66'),(32,'aa031',21,'w','lamp66'),(34,'aa033',21,'w','lamp66'),(35,'test1234',23,'m','lamp65'),(36,'test1112',27,'w','lamp65'),(37,'test122',25,'w','lamp65'),(38,'abcd1234',20,'w','lamp65'),(39,'admin998',23,'m','lamp61');

/*Table structure for table `lamp_user` */

DROP TABLE IF EXISTS `lamp_user`;

CREATE TABLE `lamp_user` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `username` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `userpass` char(32) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `lamp_user` */

insert  into `lamp_user`(`id`,`username`,`name`,`userpass`) values (1,'admin','管理员','21232f297a57a5a743894a0e4a801fc3'),(4,'lisi','李四','e10adc3949ba59abbe56e057f20f883e'),(3,'zhangsan','张三','e10adc3949ba59abbe56e057f20f883e'),(5,'qq','qq','202cb962ac59075b964b07152d234b70'),(6,'pp','pp','c483f6ce851c9ecd9fb835ff7551737c'),(22,'sadfasd','阿斯顿飞','123'),(21,'wangwu','王五','123'),(2,'dd','小弟','202cb962ac59075b964b07152d234b70'),(19,'kk2456','kk2','202cb962ac59075b964b07152d234b70'),(20,'qq1234','qq123456123','202cb962ac59075b964b07152d234b70'),(24,'cc','pp','202cb962ac59075b964b07152d234b70');

/*Table structure for table `lamp_user_role` */

DROP TABLE IF EXISTS `lamp_user_role`;

CREATE TABLE `lamp_user_role` (
  `rid` mediumint(9) unsigned default NULL,
  `uid` int(6) unsigned NOT NULL,
  KEY `group_id` (`rid`),
  KEY `user_id` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `lamp_user_role` */

insert  into `lamp_user_role`(`rid`,`uid`) values (3,5),(2,1),(2,3),(4,4),(7,24),(2,21),(3,1),(7,5);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

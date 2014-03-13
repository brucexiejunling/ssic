-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 09 月 17 日 03:06
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `innovation_contest`
--
CREATE DATABASE IF NOT EXISTS `innovation_contest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `innovation_contest`;

-- --------------------------------------------------------

--
-- 表的结构 `ic_administrator`
--

CREATE TABLE IF NOT EXISTS `ic_administrator` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ic_administrator`
--

INSERT INTO `ic_administrator` (`id`, `username`, `password`) VALUES
(1, 'ic_admin', 'sysuic2013');

-- --------------------------------------------------------

--
-- 表的结构 `ic_advisor`
--

CREATE TABLE IF NOT EXISTS `ic_advisor` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `teamId` int(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL COMMENT '职称',
  `department` varchar(100) NOT NULL COMMENT '所在单位',
  `contact` varchar(100) NOT NULL,
  `contribute` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `ic_advisor`
--

INSERT INTO `ic_advisor` (`id`, `teamId`, `name`, `position`, `department`, `contact`, `contribute`) VALUES
(1, 1, '王老师', '老师', '软件学院', '1358050', '好厉害的贡献'),
(2, 1, '李老师', NULL, '软件学院', '1358050109', NULL),
(3, 39, '王老师', '博士', '软件学院', '13580501088', NULL),
(4, 40, '333', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', NULL),
(5, 41, '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', NULL),
(6, 0, '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', NULL),
(7, 42, '', '', '', '', NULL),
(8, 0, '', '', '', '', NULL),
(9, 0, '', '', '', '', NULL),
(10, 43, '12345678910', '12345678910', '12345678910', '12345678910', '12345678910'),
(11, 44, '123', '123', '123', '123', '123');

-- --------------------------------------------------------

--
-- 表的结构 `ic_comment`
--

CREATE TABLE IF NOT EXISTS `ic_comment` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `teamId` int(8) NOT NULL,
  `teacherId` int(4) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_comment_teacher`
--

CREATE TABLE IF NOT EXISTS `ic_comment_teacher` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_contest_info`
--

CREATE TABLE IF NOT EXISTS `ic_contest_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `info` text NOT NULL COMMENT '大赛介绍，用于主页',
  `announction` text NOT NULL COMMENT '大赛公告，用于登录进去的页面',
  `route` text NOT NULL,
  `rule` text NOT NULL,
  `contact` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ic_contest_info`
--

INSERT INTO `ic_contest_info` (`id`, `name`, `info`, `announction`, `route`, `rule`, `contact`) VALUES
(1, '创新大赛', '这是一个创新大赛（富文本编辑器编辑）\n\n邝伟科是一个傻逼~！！！我觉得也是！！', '现在是报名阶段，请大家留意上传开题报告开始时间（富文本编辑器编辑）\n\n谢军令也是一个傻逼~！！！\n\n你也是一个傻逼！~！@\n\n0000000', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ic_material`
--

CREATE TABLE IF NOT EXISTS `ic_material` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `teamId` int(8) NOT NULL,
  `stageId` int(4) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_member`
--

CREATE TABLE IF NOT EXISTS `ic_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `teamId` int(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `studentId` varchar(10) NOT NULL,
  `school` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `shortphone` varchar(30) DEFAULT NULL,
  `mail` varchar(100) NOT NULL,
  `qq` varchar(50) NOT NULL,
  `dorm` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'member',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `ic_member`
--

INSERT INTO `ic_member` (`id`, `teamId`, `name`, `studentId`, `school`, `class`, `phone`, `shortphone`, `mail`, `qq`, `dorm`, `type`) VALUES
(1, 1, '邝队长', '11331155', '软件学院', '软件工程1班', '13580501008', '631008', '624977930@qq.com', '624977930', '慎思园6号', 'leader'),
(2, 1, '邝伟科', '11331155', '软件学院', '软件工程1班', '13580501008', NULL, '624977930@qq.com', '624977930', '慎思园6号', 'member'),
(9, 39, '', '', '', '', '', '', '', '', '', 'member'),
(10, 40, '13580501008@keke.com', '1358050100', '13580501008@keke.com', '13580501008@keke.com', '13580501008', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', 'member'),
(8, 39, '邝伟科', '1133', '软件学院', '1版', '12345678910', '123', '624@qq.com', '6255', '神六', 'member'),
(11, 40, '', '', '', '', '', '', '', '', '', 'member'),
(12, 41, 'test3', '1358050100', '13580501008@keke.com', '13580501008@keke.com', '13580501008', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', 'member'),
(13, 41, '', '', '', '', '', '', '', '', '', 'member'),
(14, 0, 'test3', '1358050100', '13580501008@keke.com', '13580501008@keke.com', '13580501008', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', '13580501008@keke.com', 'member'),
(15, 0, '', '', '', '', '', '', '', '', '', 'member'),
(16, 42, '', '', '', '', '', '', '', '', '', 'member'),
(17, 42, '', '', '', '', '', '', '', '', '', 'member'),
(18, 0, '', '', '', '', '', '', '', '', '', 'member'),
(19, 0, '', '', '', '', '', '', '', '', '', 'member'),
(20, 0, '123', '', '', '', '', '', '', '', '', 'member'),
(21, 0, '', '', '', '', '', '', '', '', '', 'member'),
(22, 43, '队长', '1234567891', '12345678910', '12345678910', '12345678910', '12345678910', '12345678910@qq.com', '12345678910', '12345678910', 'leader'),
(23, 43, '12345678910', '1234567891', '12345678910', '12345678910', '12345678910', '12345678910', '12345678910@qq.com', '12345678910', '12345678910', 'member'),
(24, 43, '12345678910', '1234567891', '12345678910', '12345678910', '12345678910', '12345678910', '12345678910@qq.com', '12345678910', '12345678910', 'member'),
(25, 44, 'test3', '123', '123', '123', '12312312312', '123', '123@qq.com', '123', '123', 'leader'),
(26, 44, '123', '123', '123', '123', '12312312312', '123', '123@qq.com', '123', '123', 'member'),
(27, 44, '123', '123123', '123', '123', '12312312312', '123', '123@qq.com', '123', '123', 'member');

-- --------------------------------------------------------

--
-- 表的结构 `ic_period`
--

CREATE TABLE IF NOT EXISTS `ic_period` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `descript` varchar(100) NOT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `ic_period`
--

INSERT INTO `ic_period` (`id`, `name`, `descript`, `startTime`, `endTime`) VALUES
(1, 'apply', '报名阶段', '2013-09-15 00:00:00', '2013-09-28 23:00:00'),
(2, 'pre_upload', '初审资料上传', '2013-09-29 00:00:00', '2013-10-08 12:00:00'),
(3, 'tea_conment', '老师初审点评', '2013-10-08 00:00:00', '2013-10-12 12:00:00'),
(4, 'check_pre_result', '查看点评结果', '2013-10-12 12:00:00', '2013-10-14 23:00:00'),
(5, 'first_upload', '初赛材料上传', '2013-10-13 00:00:00', '2013-11-08 23:00:00'),
(6, 'first_draw', '初赛抽签', '2013-11-08 20:00:00', '2013-11-09 22:00:00'),
(7, 'second_upload', '复赛材料上传', '2013-11-10 00:00:00', '2013-11-11 23:00:00'),
(8, 'second_draw', '复赛抽签', '2013-11-12 18:00:00', '2013-11-13 21:00:00'),
(9, 'revive_upload', '复活赛材料上传', '2013-11-14 00:00:00', '2013-11-15 23:00:00'),
(10, 'revive_vote', '复活赛投票', '2013-11-16 00:00:00', '2013-11-17 23:00:00'),
(11, 'final_upload', '决赛材料上传', '2013-11-18 00:00:00', '2013-11-19 23:00:00'),
(12, 'final_upload_poster', '决赛海报上传', '2013-11-20 16:00:00', '2013-11-21 21:00:00'),
(13, 'final_draw', '决赛抽签', '2013-11-22 17:00:00', '2013-11-23 20:00:00'),
(14, 'contest', '大赛开始', '2013-09-15 00:00:00', '2013-12-25 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `ic_team`
--

CREATE TABLE IF NOT EXISTS `ic_team` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `number` int(8) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `leaderId` int(8) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'in' COMMENT '淘汰状态：out/in/revive',
  `outStage` varchar(10) DEFAULT '--',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`username`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- 转存表中的数据 `ic_team`
--

INSERT INTO `ic_team` (`id`, `username`, `password`, `number`, `name`, `leaderId`, `status`, `outStage`) VALUES
(1, '624977930@qq.com', 'b7d73b1a4b0c45d7af4c700e79d6e9cd', 1, '神奇队', 1, 'in', '--'),
(2, '1', '098f6bcd4621d373cade4e832627b4f6', 10, '傻逼队2', 0, 'in', '--'),
(4, '2', '098f6bcd4621d373cade4e832627b4f6', 10, '傻逼队2', 0, 'out', 'second'),
(6, '4', '098f6bcd4621d373cade4e832627b4f6', NULL, '淘汰队1', 0, 'out', 'second'),
(40, '13580501008@keke.com', '12345678910', NULL, '13580501008@keke.com', NULL, 'in', '--'),
(8, '6', '098f6bcd4621d373cade4e832627b4f6', NULL, '傻逼队3', 0, 'in', '--'),
(9, 'kke', 'wewe', NULL, NULL, 0, 'in', '--'),
(10, 'fsdklajfa', '123456', 10, '傻逼队2', 0, 'in', '--'),
(11, 'fsdklajfa33', '123456', 10, '傻逼队2', 0, 'in', '--'),
(12, 'fsdklaj', '123456', 10, '傻逼队2', 0, 'in', '--'),
(13, 'fsdk123', '123456', 10, '傻逼队2', 0, 'in', '--'),
(14, 'fsdk1231', '123456', 10, '傻逼队2', 0, 'in', '--'),
(15, 'fsdk1232', '123456', 10, '傻逼队3', 0, 'in', '--'),
(16, 'fsdk1233', '123456', 10, '傻逼队3', 0, 'in', '--'),
(17, 'fsdk1234', '123456', 10, '傻逼队4', 0, 'in', '--'),
(18, 'fsdk1235', '123456', 10, '傻逼队4', 0, 'in', '--'),
(19, 'fsdk1236', '123456', 10, '傻逼队4', 0, 'in', '--'),
(20, 'fsdk1237', '123456', 10, '傻逼队4', 0, 'in', '--'),
(21, 'fsdk1238', '123456', 10, '傻逼队4', 0, 'in', '--'),
(22, 'fsdk1239', '123456', 10, '傻逼队4', 0, 'in', '--'),
(23, 'fsdk1240', '123456', 10, '傻逼队5', 0, 'in', '--'),
(24, 'fsdk1241', '123456', 10, '傻逼队5', 0, 'in', '--'),
(25, 'fsdk1242', '123456', 10, '傻逼队5', 0, 'in', '--'),
(26, 'fsdk1243', '123456', 10, '傻逼队5', 0, 'in', '--'),
(27, 'fsdk1244', '123456', 10, '傻逼队5', 0, 'in', '--'),
(28, 'fsdk1245', '123457', 10, '傻逼队6', 0, 'in', '--'),
(29, 'fsdk126', '123457', 10, '傻逼队6', 0, 'in', '--'),
(30, 'fsdk127', '123457', 10, '傻逼队6', 0, 'in', '--'),
(31, 'fsdk18', '123457', 10, '傻逼队6', 0, 'in', '--'),
(32, 'fsdk128', '123457', 10, '傻逼队6', 0, 'in', '--'),
(33, 'fsdk129', '123457', 10, '傻逼队6', 0, 'in', '--'),
(34, 'fsdk1230', '123457', 10, '傻逼队6', 0, 'in', '--'),
(35, 'fsdk177', '123457', 10, '傻逼队7', 0, 'in', '--'),
(36, 'fsdk120', '123457', 10, '傻逼队6', 0, 'in', '--'),
(37, '234324', '12343124', 10, '傻逼队6', 0, 'in', '--'),
(38, 'fsdk12333', '123457', 10, '傻逼队7', 0, 'in', '--'),
(39, '12345678910', '432f45b44c432414d2f97df0e5743818', NULL, 'V5队', NULL, 'in', '--'),
(41, '13580501008@keke.co', '13580501008@keke.com', NULL, '13580501008@keke.', NULL, 'in', '--'),
(42, '', '', NULL, '', NULL, 'in', '--'),
(43, '1234567890', '432f45b44c432414d2f97df0e5743818', NULL, '12345678910', 22, 'in', '--'),
(44, '123', '432f45b44c432414d2f97df0e5743818', NULL, '123', 25, 'in', '--');

-- --------------------------------------------------------

--
-- 表的结构 `ic_vote_result`
--

CREATE TABLE IF NOT EXISTS `ic_vote_result` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `stageId` int(4) NOT NULL,
  `teamId` int(8) NOT NULL,
  `timeAndPlaceId` int(4) NOT NULL,
  `number` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ic_vote_setting`
--

CREATE TABLE IF NOT EXISTS `ic_vote_setting` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `stageId` int(4) NOT NULL COMMENT '对应抽签阶段，比如初赛抽签阶段',
  `timeAndPlace` varchar(100) NOT NULL,
  `number` int(4) NOT NULL COMMENT '该场次分配的队伍多少',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ic_vote_setting`
--

INSERT INTO `ic_vote_setting` (`id`, `stageId`, `timeAndPlace`, `number`) VALUES
(1, 6, '下午A206\r\n', 3),
(2, 6, '晚上A206', 4),
(3, 6, '下午A207', 3),
(4, 6, '晚上A207', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

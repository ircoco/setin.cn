-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-02-13 09:38:40
-- 服务器版本： 5.5.37-log
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rs`
--

-- --------------------------------------------------------

--
-- 表的结构 `weixin_user`
--

CREATE TABLE IF NOT EXISTS `weixin_user` (
  `wx_id` varchar(50) NOT NULL,
  `wx_name` varchar(10) DEFAULT NULL,
  `wx_state` varchar(2) NOT NULL,
  `wx_info` varchar(10) DEFAULT NULL,
  `wx_lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `weixin_user`
--

INSERT INTO `weixin_user` (`wx_id`, `wx_name`, `wx_state`, `wx_info`, `wx_lasttime`) VALUES
('oQI2suNnEziQZHQRK6XbcsbOkw34', '', '0', '', '2015-02-13 00:33:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weixin_user`
--
ALTER TABLE `weixin_user`
 ADD PRIMARY KEY (`wx_id`), ADD KEY `wx_id` (`wx_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

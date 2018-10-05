-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-10-04 03:16:13
-- 服务器版本： 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_admin`
--

DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE IF NOT EXISTS `tp_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_admin`
--

INSERT INTO `tp_admin` (`id`, `username`, `pwd`, `role_id`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_category`
--

DROP TABLE IF EXISTS `tp_category`;
CREATE TABLE IF NOT EXISTS `tp_category` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类的ID',
  `isrec` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='分类表';

--
-- 转存表中的数据 `tp_category`
--

INSERT INTO `tp_category` (`id`, `cname`, `parent_id`, `isrec`) VALUES
(1, '家用电器', 0, 1),
(3, '电脑', 0, 1),
(4, '家居', 0, 0),
(5, '服装', 0, 1),
(6, '男鞋', 0, 0),
(7, '女鞋', 0, 0),
(8, '食品', 0, 0),
(9, '电视', 1, 0),
(10, '空调', 1, 0),
(11, '曲屏电视', 9, 0),
(16, 'test', 0, 0),
(17, 'testee', 16, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tp_goods`
--

DROP TABLE IF EXISTS `tp_goods`;
CREATE TABLE IF NOT EXISTS `tp_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品的id',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类ID 对应category表id字段',
  `goods_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '商品的唯一货号标识',
  `market_price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '市场售价',
  `shop_price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '本店价格',
  `goods_img` varchar(255) NOT NULL DEFAULT '' COMMENT '商品原图',
  `goods_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `goods_body` text COMMENT '商品详细描述',
  `is_sale` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否销售  1、销售 0不销售',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否热卖  0否  1是',
  `is_rec` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '上架时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商品主表';

--
-- 转存表中的数据 `tp_goods`
--

INSERT INTO `tp_goods` (`id`, `goods_name`, `cate_id`, `goods_sn`, `market_price`, `shop_price`, `goods_img`, `goods_thumb`, `goods_body`, `is_sale`, `is_hot`, `is_rec`, `is_new`, `addtime`) VALUES
(1, 'thinkpad', 3, '123', '10000.00', '8999.00', '', '', '123', 0, 0, 0, 1, 1538134056),
(2, '神舟', 3, 'SHOP5BAE1BC0CD411', '10000.00', '3999.00', '', '', '132', 1, 0, 0, 1, 1538137024),
(3, '123', 1, '1231', '9999.00', '1233.00', '', '', '123', 0, 1, 0, 0, 1538142503),
(4, '神舟1', 3, 'SHOP5BAE3DD8C948A', '2.00', '1.00', 'uploads/20180928/d24da82ef4f36c83fe56b2750a8e74dd.jpg', 'uploads/20180928/thumb_d24da82ef4f36c83fe56b2750a8e74dd.jpg', '123', 1, 0, 0, 1, 1538145752),
(5, '神舟12', 3, 'SHOP5BAF0992A8C55', '44.00', '33.00', 'uploads/20180929/ed4afda2d88e3d3c8782d9d15227315f.jpg', 'uploads/20180929/thumb_ed4afda2d88e3d3c8782d9d15227315f.jpg', '&lt;p&gt;&lt;img src=&quot;http://www.tpshop.com/upload/20180929/1538197905653733.png&quot; title=&quot;1538197905653733.png&quot; alt=&quot;bc2e7e90a52dcdf5c762ce769576f85c.png&quot;/&gt;&lt;/p&gt;', 1, 1, 0, 0, 1538197906);

-- --------------------------------------------------------

--
-- 表的结构 `tp_role`
--

DROP TABLE IF EXISTS `tp_role`;
CREATE TABLE IF NOT EXISTS `tp_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE IF NOT EXISTS `tp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `age` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-10-10 09:11:07
-- 服务器版本： 5.7.21
-- PHP Version: 5.6.35

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
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员对应角色 关联role表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_admin`
--

INSERT INTO `tp_admin` (`id`, `username`, `pwd`, `role_id`) VALUES
(1, 'admin', '63a9f0ea7bb98050796b649e85481845', 1),
(3, 'hao', '21232f297a57a5a743894a0e4a801fc3', 3);

-- --------------------------------------------------------

--
-- 表的结构 `tp_attribute`
--

DROP TABLE IF EXISTS `tp_attribute`;
CREATE TABLE IF NOT EXISTS `tp_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名称',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型的ID 与type表关联',
  `attr_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性本身的类型 1唯一属性 2单选属性',
  `attr_input_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性的录入方式 1input文本输入 2select下拉选择',
  `attr_values` varchar(255) NOT NULL DEFAULT '' COMMENT '属性默认值当为select选择时生效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='属性表只有属性名称';

--
-- 转存表中的数据 `tp_attribute`
--

INSERT INTO `tp_attribute` (`id`, `attr_name`, `type_id`, `attr_type`, `attr_input_type`, `attr_values`) VALUES
(1, '网络', 1, 2, 2, '移动,联通,电信,3G'),
(3, '颜色', 1, 2, 2, '黑色,白色,黄色'),
(4, '内存', 1, 2, 2, '3G,4G');

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
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0正常，1已删除',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品所属类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商品主表';

--
-- 转存表中的数据 `tp_goods`
--

INSERT INTO `tp_goods` (`id`, `goods_name`, `cate_id`, `goods_sn`, `market_price`, `shop_price`, `goods_img`, `goods_thumb`, `goods_body`, `is_sale`, `is_hot`, `is_rec`, `is_new`, `addtime`, `is_del`, `type_id`) VALUES
(1, 'thinkpad', 3, '123', '10000.00', '8999.00', '', '', '123', 0, 0, 0, 1, 1538134056, 1, 0),
(2, '神舟11', 3, 'SHOP5BAE1BC0CD41', '10000.00', '3999.00', 'uploads/20181008/224b0b06156b7c830305617462cd6704.png', 'uploads/20181008/thumb_224b0b06156b7c830305617462cd6704.png', '&lt;p&gt;132&lt;/p&gt;', 1, 0, 0, 1, 1538137024, 0, 0),
(4, '神舟1', 3, 'SHOP5BAE3DD8C948A', '2.00', '1.00', 'uploads/20180928/d24da82ef4f36c83fe56b2750a8e74dd.jpg', 'uploads/20180928/thumb_d24da82ef4f36c83fe56b2750a8e74dd.jpg', '123', 1, 0, 0, 1, 1538145752, 0, 0),
(5, '神舟12', 3, 'SHOP5BAF0992A8C55', '44.00', '33.00', 'uploads/20180929/ed4afda2d88e3d3c8782d9d15227315f.jpg', 'uploads/20180929/thumb_ed4afda2d88e3d3c8782d9d15227315f.jpg', '&lt;p&gt;&lt;img src=&quot;http://www.tpshop.com/upload/20180929/1538197905653733.png&quot; title=&quot;1538197905653733.png&quot; alt=&quot;bc2e7e90a52dcdf5c762ce769576f85c.png&quot;/&gt;&lt;/p&gt;', 1, 1, 0, 0, 1538197906, 0, 0),
(6, '联想', 3, 'SHOP5BBCA0AF6098C', '10000.00', '8999.00', 'uploads/20181009/33ff47864dbe5fca56d3ea5a3c7f1a36.jpg', 'uploads/20181009/thumb_33ff47864dbe5fca56d3ea5a3c7f1a36.jpg', '&lt;p&gt;好棒棒！！！！&lt;/p&gt;', 1, 1, 1, 1, 1539088559, 0, 3),
(9, '联想', 3, 'SHOP5BBCBA7D486C6', '10000.00', '8999.00', 'uploads/20181009/7386f16893b313a23fa8e3a5db55945c.jpg', 'uploads/20181009/thumb_7386f16893b313a23fa8e3a5db55945c.jpg', '&lt;p&gt;123&lt;/p&gt;', 1, 1, 0, 0, 1539095165, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_goods_attr`
--

DROP TABLE IF EXISTS `tp_goods_attr`;
CREATE TABLE IF NOT EXISTS `tp_goods_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `attr_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性id 关联attribute表',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_goods_attr`
--

INSERT INTO `tp_goods_attr` (`id`, `goods_id`, `attr_id`, `attr_value`) VALUES
(1, 9, 1, '移动'),
(2, 9, 3, '黑色'),
(3, 9, 4, '3G');

-- --------------------------------------------------------

--
-- 表的结构 `tp_role`
--

DROP TABLE IF EXISTS `tp_role`;
CREATE TABLE IF NOT EXISTS `tp_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL DEFAULT '' COMMENT '角色名称',
  `rule_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '权限的id组合 rule表id组合',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_role`
--

INSERT INTO `tp_role` (`id`, `role_name`, `rule_ids`) VALUES
(1, '超级管理员', ''),
(3, '普通管理员', '4');

-- --------------------------------------------------------

--
-- 表的结构 `tp_rule`
--

DROP TABLE IF EXISTS `tp_rule`;
CREATE TABLE IF NOT EXISTS `tp_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限名称',
  `controller_name` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级权限的id',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否导航显示 1显示 0不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_rule`
--

INSERT INTO `tp_rule` (`id`, `rule_name`, `controller_name`, `action_name`, `parent_id`, `is_show`) VALUES
(1, '商品管理', 'goods1', '#', 0, 0),
(3, '商品管理1', 'goods111', '#', 0, 0),
(4, '商品添加', 'add', '#', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_type`
--

DROP TABLE IF EXISTS `tp_type`;
CREATE TABLE IF NOT EXISTS `tp_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='类型表';

--
-- 转存表中的数据 `tp_type`
--

INSERT INTO `tp_type` (`id`, `type_name`) VALUES
(1, '手机'),
(3, '电脑');

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

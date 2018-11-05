 tp_admin | CREATE TABLE `tp_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) hell word!!
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8

 tp_category | CREATE TABLE `tp_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类的ID',
  `isrec` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='分类表'

 tp_goods | CREATE TABLE `tp_goods` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品主表'

 tp_role | CREATE TABLE `tp_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

 tp_user | CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `age` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

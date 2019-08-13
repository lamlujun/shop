# Host: localhost  (Version: 5.5.53)
# Date: 2019-08-03 08:48:10
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "eshop_address"
#

DROP TABLE IF EXISTS `eshop_address`;
CREATE TABLE `eshop_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `people` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `town` varchar(255) NOT NULL DEFAULT '' COMMENT '镇区',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `addtime` varchar(255) NOT NULL DEFAULT '' COMMENT '添加时间',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `default_address` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否设置为默认地址,1是0否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_address"
#

/*!40000 ALTER TABLE `eshop_address` DISABLE KEYS */;
INSERT INTO `eshop_address` VALUES (20,1,'许小秋','江苏','无锡市','崇安区','北京大道110号','1564305544','13728272324',1),(24,1,'叶小猴','广西','钦州市','钦北区','广西壮族自治区','1564305967','13131313113',0),(25,1,'叶小猴','广西','柳州市','鱼峰区','广西壮族自治区','1564306121','13131313113',0);
/*!40000 ALTER TABLE `eshop_address` ENABLE KEYS */;

#
# Structure for table "eshop_admin"
#

DROP TABLE IF EXISTS `eshop_admin`;
CREATE TABLE `eshop_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `role_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_admin"
#

/*!40000 ALTER TABLE `eshop_admin` DISABLE KEYS */;
INSERT INTO `eshop_admin` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',1),(2,'lam','21232f297a57a5a743894a0e4a801fc3',2);
/*!40000 ALTER TABLE `eshop_admin` ENABLE KEYS */;

#
# Structure for table "eshop_attribute"
#

DROP TABLE IF EXISTS `eshop_attribute`;
CREATE TABLE `eshop_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名称',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性所属类型,对应type表id字段',
  `attr_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性本身的类型,1 唯一属性,2 单选属性',
  `attr_input_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性录入方式 1input输入,2select选择',
  `attr_values` varchar(255) NOT NULL DEFAULT '' COMMENT '属性默认值,select选择时有效',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_attribute"
#

/*!40000 ALTER TABLE `eshop_attribute` DISABLE KEYS */;
INSERT INTO `eshop_attribute` VALUES (1,'颜色',2,2,2,'黑色,白色,蓝色'),(2,'版本',2,2,2,'i3 4G内存版,i5 4G内存版,SSD超极本'),(3,'商品名称',2,1,1,''),(4,'品牌',2,1,1,''),(5,'显卡',2,1,1,''),(6,'尺寸',2,1,1,''),(7,'产地',2,1,1,'');
/*!40000 ALTER TABLE `eshop_attribute` ENABLE KEYS */;

#
# Structure for table "eshop_cart"
#

DROP TABLE IF EXISTS `eshop_cart`;
CREATE TABLE `eshop_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_count` int(11) NOT NULL DEFAULT '0' COMMENT '购买数量',
  `goods_attr_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '属性id组合',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_cart"
#

/*!40000 ALTER TABLE `eshop_cart` DISABLE KEYS */;
INSERT INTO `eshop_cart` VALUES (33,1,7,1,'54,61');
/*!40000 ALTER TABLE `eshop_cart` ENABLE KEYS */;

#
# Structure for table "eshop_category"
#

DROP TABLE IF EXISTS `eshop_category`;
CREATE TABLE `eshop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) NOT NULL,
  `p_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_category"
#

INSERT INTO `eshop_category` VALUES (1,'家用电器',0),(2,'大家电',1),(3,'冰箱',2),(4,'空调',2),(6,'电脑、办公',0),(7,'电脑整机',6),(8,'笔记本',7),(9,'游戏本',7),(10,'平板电脑',7);

#
# Structure for table "eshop_goods"
#

DROP TABLE IF EXISTS `eshop_goods`;
CREATE TABLE `eshop_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类 对应category表的id字段',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型ID',
  `goods_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '商品货号',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场售价',
  `goods_img` varchar(255) NOT NULL DEFAULT '',
  `goods_thumb` varchar(255) NOT NULL DEFAULT '',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店售价',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '上架时间',
  `goods_number` int(11) NOT NULL DEFAULT '0' COMMENT '总库存',
  `goods_body` text NOT NULL COMMENT '商品详情描述',
  `is_del` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除 0否1已删除',
  `is_res` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐 1是0否',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否热卖 1是0否',
  `is_new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否新品 1是0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_goods"
#

INSERT INTO `eshop_goods` VALUES (1,'ThinkPad X230笔记本',8,2,'D7AA929',6399.00,'upload/20190723/d6041dbddff2f11a64359e40542e9ef8.jpg','upload/20190723/thumb_d6041dbddff2f11a64359e40542e9ef8.jpg',6299.00,1563847127,2000,'&lt;p&gt;&lt;img src=&quot;/upload/20190723/1563847082.jpg&quot; title=&quot;1563847082.jpg&quot; alt=&quot;desc1.jpg&quot;/&gt;&lt;img src=&quot;/upload/20190723/1563847087.jpg&quot; title=&quot;1563847087.jpg&quot; alt=&quot;desc2.jpg&quot;/&gt;&lt;/p&gt;',0,1,1,0),(7,'ThinkPad X230笔记本',8,2,'BE5F367',6399.00,'upload/20190723/d0b6cc5fabda808a6fc393519dd5e698.jpg','upload/20190723/thumb_d0b6cc5fabda808a6fc393519dd5e698.jpg',6299.00,1563850174,1922,'&lt;p&gt;&lt;img src=&quot;/upload/20190723/1563850119.jpg&quot; title=&quot;1563850119.jpg&quot; alt=&quot;desc1.jpg&quot;/&gt;&lt;/p&gt;',0,1,0,1),(9,'电脑',8,2,'D66E4A2',6399.00,'upload/20190801/20e59f6876b785e96e2b0558b8999784.jpg','upload/20190801/thumb_20e59f6876b785e96e2b0558b8999784.jpg',6299.00,1564653526,12,'',0,0,1,1),(10,'名称',8,0,'010FFBE',6399.00,'upload/20190801/fdbceb2aff51e6798dc4e0c891412d52.jpg','upload/20190801/thumb_fdbceb2aff51e6798dc4e0c891412d52.jpg',6299.00,1564653569,10,'',0,0,1,1),(11,'名称',8,0,'02E34F5',6399.00,'upload/20190801/6a690610f6bb9cb26fdbdcd0e39d33f3.jpg','upload/20190801/thumb_6a690610f6bb9cb26fdbdcd0e39d33f3.jpg',6299.00,1564653570,10,'',0,0,1,1),(12,'名称',8,0,'03E3179',6399.00,'upload/20190801/6ee8fe7806ba5a8cb0556d120820a042.jpg','upload/20190801/thumb_6ee8fe7806ba5a8cb0556d120820a042.jpg',6299.00,1564653571,10,'',0,0,1,1),(13,'名称',8,0,'0439C43',6399.00,'upload/20190801/c77b7818827abe059b507821ffc16452.jpg','upload/20190801/thumb_c77b7818827abe059b507821ffc16452.jpg',6299.00,1564653572,10,'',0,0,1,1),(14,'名称',8,0,'0482770',6399.00,'upload/20190801/e7873a9205b87178ffda3947ff17894f.jpg','upload/20190801/thumb_e7873a9205b87178ffda3947ff17894f.jpg',6299.00,1564653572,10,'',0,0,1,1),(15,'名称',8,0,'04A2DCF',6399.00,'upload/20190801/4ac6723e8c7f008d69cfcebb6f303ba9.jpg','upload/20190801/thumb_4ac6723e8c7f008d69cfcebb6f303ba9.jpg',6299.00,1564653572,10,'',0,0,1,1),(16,'名称',8,0,'04CF511',6399.00,'upload/20190801/0297a08774a33b7ae498086e895c61ed.jpg','upload/20190801/thumb_0297a08774a33b7ae498086e895c61ed.jpg',6299.00,1564653572,10,'',0,0,1,1),(17,'名称',8,0,'0506C55',6399.00,'upload/20190801/1112e01c1b2327d4143424a25fffa77d.jpg','upload/20190801/thumb_1112e01c1b2327d4143424a25fffa77d.jpg',6299.00,1564653573,10,'',0,0,1,1),(18,'名称',8,0,'0527799',6399.00,'upload/20190801/63162af89142a34975f4b0e57a5a3d32.jpg','upload/20190801/thumb_63162af89142a34975f4b0e57a5a3d32.jpg',6299.00,1564653573,10,'',0,0,1,1),(19,'名称',8,0,'0548197',6399.00,'upload/20190801/557ef11cb7a788ea899f672517c564f4.jpg','upload/20190801/thumb_557ef11cb7a788ea899f672517c564f4.jpg',6299.00,1564653573,10,'',0,0,1,1),(20,'名称',8,0,'056A21C',6399.00,'upload/20190801/a8c22f092bdd3def643e8fb96ed9ee1a.jpg','upload/20190801/thumb_a8c22f092bdd3def643e8fb96ed9ee1a.jpg',6299.00,1564653573,10,'',0,0,1,1),(21,'名称',8,0,'0595CB8',6399.00,'upload/20190801/8fe7a098a74b11f02d82f92403a4d410.jpg','upload/20190801/thumb_8fe7a098a74b11f02d82f92403a4d410.jpg',6299.00,1564653573,10,'',0,0,1,1),(22,'名称',8,0,'05ADAEA',6399.00,'upload/20190801/373c84b3ac58ce2e5a4882985de668b2.jpg','upload/20190801/thumb_373c84b3ac58ce2e5a4882985de668b2.jpg',6299.00,1564653573,10,'',0,0,1,1),(23,'名称',8,0,'05D9DD9',6399.00,'upload/20190801/af2ff3e0a868fc788af48cec1b55a40a.jpg','upload/20190801/thumb_af2ff3e0a868fc788af48cec1b55a40a.jpg',6299.00,1564653573,10,'',0,0,1,1),(24,'名称',8,0,'0606652',6399.00,'upload/20190801/80a06cf289bf2a73fec5cc4170592421.jpg','upload/20190801/thumb_80a06cf289bf2a73fec5cc4170592421.jpg',6299.00,1564653574,10,'',0,0,1,1),(25,'名称',8,0,'062196F',6399.00,'upload/20190801/d4bab58adfe52f1baa035e30a54eda51.jpg','upload/20190801/thumb_d4bab58adfe52f1baa035e30a54eda51.jpg',6299.00,1564653574,10,'',0,0,1,1),(26,'名称',8,0,'064DB46',6399.00,'upload/20190801/2351b71b9b6109b1a4b9a4688d78e669.jpg','upload/20190801/thumb_2351b71b9b6109b1a4b9a4688d78e669.jpg',6299.00,1564653574,10,'',0,0,1,1),(27,'名称',8,0,'067539F',6399.00,'upload/20190801/271ae60d43628ccdd8c95e057898f464.jpg','upload/20190801/thumb_271ae60d43628ccdd8c95e057898f464.jpg',6299.00,1564653574,10,'',0,0,1,1),(28,'名称',8,0,'068A8C9',6399.00,'upload/20190801/8af20052529516b65af147559fedba3b.jpg','upload/20190801/thumb_8af20052529516b65af147559fedba3b.jpg',6299.00,1564653574,10,'',0,0,1,1),(29,'名称',8,0,'06B1084',6399.00,'upload/20190801/19b6c4b94153bbb1b6d5fdefa3216012.jpg','upload/20190801/thumb_19b6c4b94153bbb1b6d5fdefa3216012.jpg',6299.00,1564653574,10,'',0,0,1,1),(30,'名称',8,0,'06D38FF',6399.00,'upload/20190801/e8b93648d59e81bd6441c0ec409d369a.jpg','upload/20190801/thumb_e8b93648d59e81bd6441c0ec409d369a.jpg',6299.00,1564653574,10,'',0,0,1,1),(31,'名称',8,0,'07005F5',6399.00,'upload/20190801/620e5de111a792ec84ab0bae431fea50.jpg','upload/20190801/thumb_620e5de111a792ec84ab0bae431fea50.jpg',6299.00,1564653575,10,'',0,0,1,1),(32,'电脑',9,0,'6EDD6BF',6399.00,'upload/20190802/d91b75dd9160430a1d91efa94544ec82.jpg','upload/20190802/thumb_d91b75dd9160430a1d91efa94544ec82.jpg',6299.00,1564736366,12,'',0,0,1,1),(33,'电脑',9,0,'707A9AD',6399.00,'upload/20190802/f4df9b6933e8b58d27fc3046c990d191.jpg','upload/20190802/thumb_f4df9b6933e8b58d27fc3046c990d191.jpg',6299.00,1564736368,12,'',0,0,1,1),(34,'电脑',9,0,'710F390',6399.00,'upload/20190802/d3cf32aaa6f68a2a045a19c85062c5db.jpg','upload/20190802/thumb_d3cf32aaa6f68a2a045a19c85062c5db.jpg',6299.00,1564736369,12,'',0,0,1,1),(35,'电脑',9,0,'7175798',6399.00,'upload/20190802/9297292ca6fa503fe2d3af51e5b508a4.jpg','upload/20190802/thumb_9297292ca6fa503fe2d3af51e5b508a4.jpg',6299.00,1564736369,12,'',0,0,1,1),(36,'电脑',9,0,'71C3C6E',6399.00,'upload/20190802/24553077420a7c2d8fa8db8b87a7d02e.jpg','upload/20190802/thumb_24553077420a7c2d8fa8db8b87a7d02e.jpg',6299.00,1564736369,12,'',0,0,1,1),(37,'电脑',9,0,'7212B0C',6399.00,'upload/20190802/9045c358b99c0e7bb91e13c200164a3d.jpg','upload/20190802/thumb_9045c358b99c0e7bb91e13c200164a3d.jpg',6299.00,1564736370,12,'',0,0,1,1),(38,'电脑',9,0,'72588A3',6399.00,'upload/20190802/55b1783ddb2352ea203985a46b77cf88.jpg','upload/20190802/thumb_55b1783ddb2352ea203985a46b77cf88.jpg',6299.00,1564736370,12,'',0,0,1,1),(39,'电脑',9,0,'729CC95',6399.00,'upload/20190802/646b38f969ddd492ff7d89771e6a4646.jpg','upload/20190802/thumb_646b38f969ddd492ff7d89771e6a4646.jpg',6299.00,1564736370,12,'',0,0,1,1),(40,'电脑',9,0,'72D9927',6399.00,'upload/20190802/9f72e9b920bd25b5413556bff00d2c45.jpg','upload/20190802/thumb_9f72e9b920bd25b5413556bff00d2c45.jpg',6299.00,1564736370,12,'',0,0,1,1),(41,'电脑',9,0,'732027E',6399.00,'upload/20190802/2719ce23efe47541d4c2cba94cd5f6a3.jpg','upload/20190802/thumb_2719ce23efe47541d4c2cba94cd5f6a3.jpg',6299.00,1564736371,12,'',0,0,1,1);

#
# Structure for table "eshop_goods_attr"
#

DROP TABLE IF EXISTS `eshop_goods_attr`;
CREATE TABLE `eshop_goods_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品表id字段',
  `attr_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性ID attribute表中的id',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COMMENT='商品属性值表';

#
# Data for table "eshop_goods_attr"
#

/*!40000 ALTER TABLE `eshop_goods_attr` DISABLE KEYS */;
INSERT INTO `eshop_goods_attr` VALUES (1,1,1,'黑色'),(2,1,1,'白色'),(3,1,1,'蓝色'),(4,1,2,'i3 4G内存版'),(5,1,2,'i3 4G内存版'),(6,1,2,'SSD超极本'),(7,1,3,'ThinkPadX230'),(8,1,4,'联想'),(9,1,5,'集成显卡'),(10,1,6,'15寸'),(11,1,7,'China'),(12,2,1,'白色'),(13,2,2,'i5 4G内存版'),(14,2,3,'红色'),(15,2,4,'红色'),(16,2,5,'红色'),(17,2,6,'红色'),(18,2,7,'红色'),(19,3,1,'白色'),(20,3,2,'i5 4G内存版'),(21,3,3,'红色'),(22,3,4,'ThinkPadX230'),(23,3,5,'ThinkPadX230'),(24,3,6,'红色'),(25,3,7,'红色'),(26,4,1,'白色'),(27,4,1,'蓝色'),(28,4,2,'i3 4G内存版'),(29,4,2,'i3 4G内存版'),(30,4,2,'SSD超极本'),(31,4,3,'ThinkPadX230'),(32,4,4,'联想'),(33,4,5,'集成显卡'),(34,4,6,'15'),(35,4,7,'China'),(36,5,1,'白色'),(37,5,1,'黑色'),(38,5,1,'蓝色'),(39,5,2,'i5 4G内存版'),(40,5,2,'i3 4G内存版'),(41,5,3,'ThinkPadX230'),(42,5,4,'联想'),(43,5,5,'集成显卡'),(44,5,6,'15'),(45,5,7,'China'),(46,6,1,'黑色'),(47,6,2,'i3 4G内存版'),(48,6,3,'ThinkPadX230'),(49,6,4,'联想'),(50,6,5,'集成'),(51,6,6,'15'),(52,6,7,'China'),(54,7,2,'i3 4G内存版'),(55,7,3,'ThinkPadX230'),(56,7,4,'联想'),(57,7,5,'集成'),(58,7,6,'15'),(59,7,7,'China'),(60,7,1,'白色'),(61,7,1,'红色'),(62,7,2,'i5 4G内存版'),(63,7,1,'黑色'),(64,8,1,'白色'),(65,8,1,'蓝色'),(66,8,1,'黑色'),(67,8,2,'i3 4G内存版'),(68,8,2,'i5 4G内存版'),(69,8,2,'SSD超极本'),(70,8,3,'红色游戏本'),(71,8,4,'联想'),(72,8,5,'ThinkPadX230'),(73,8,6,'12'),(74,8,7,'China'),(75,9,1,'黑色'),(76,9,2,'i3 4G内存版'),(77,9,3,'红色'),(78,9,4,'红色'),(79,9,5,'3G'),(80,9,6,'3G'),(81,9,7,'3G');
/*!40000 ALTER TABLE `eshop_goods_attr` ENABLE KEYS */;

#
# Structure for table "eshop_goods_imgs"
#

DROP TABLE IF EXISTS `eshop_goods_imgs`;
CREATE TABLE `eshop_goods_imgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id值',
  `goods_img` varchar(255) NOT NULL DEFAULT '' COMMENT '商品原图',
  `goods_mid` varchar(255) NOT NULL DEFAULT '' COMMENT '商品中图',
  `goods_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '小图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_goods_imgs"
#

/*!40000 ALTER TABLE `eshop_goods_imgs` DISABLE KEYS */;
INSERT INTO `eshop_goods_imgs` VALUES (1,7,'upload/20190723/6dbb202cb1254bbb2ce3f7a94e9c087f.jpg','upload/20190723/mid_6dbb202cb1254bbb2ce3f7a94e9c087f.jpg','upload/20190723/thumb_6dbb202cb1254bbb2ce3f7a94e9c087f.jpg'),(2,7,'upload/20190723/3afb0c63fb0cd8024a659b20bdabe8d6.jpg','upload/20190723/mid_3afb0c63fb0cd8024a659b20bdabe8d6.jpg','upload/20190723/thumb_3afb0c63fb0cd8024a659b20bdabe8d6.jpg'),(3,7,'upload/20190723/99b8cad45937218efb9c64a94f770e88.jpg','upload/20190723/mid_99b8cad45937218efb9c64a94f770e88.jpg','upload/20190723/thumb_99b8cad45937218efb9c64a94f770e88.jpg'),(4,7,'upload/20190723/b10616dcbaf9f7f84a3de4c7ce51f2da.jpg','upload/20190723/mid_b10616dcbaf9f7f84a3de4c7ce51f2da.jpg','upload/20190723/thumb_b10616dcbaf9f7f84a3de4c7ce51f2da.jpg'),(5,7,'upload/20190723/29695cfc43621a57b9b8d821761a1372.jpg','upload/20190723/mid_29695cfc43621a57b9b8d821761a1372.jpg','upload/20190723/thumb_29695cfc43621a57b9b8d821761a1372.jpg'),(6,8,'upload/20190730/7a5f2ec1d070cfb56b7537f176fc08d5.jpg','upload/20190730/mid_7a5f2ec1d070cfb56b7537f176fc08d5.jpg','upload/20190730/thumb_7a5f2ec1d070cfb56b7537f176fc08d5.jpg'),(7,8,'upload/20190730/96d3a78d260f0dbbc1f53bb81b5ace9a.jpg','upload/20190730/mid_96d3a78d260f0dbbc1f53bb81b5ace9a.jpg','upload/20190730/thumb_96d3a78d260f0dbbc1f53bb81b5ace9a.jpg'),(8,8,'upload/20190730/9f89265f75e825ba3c44f09cf5928d11.jpg','upload/20190730/mid_9f89265f75e825ba3c44f09cf5928d11.jpg','upload/20190730/thumb_9f89265f75e825ba3c44f09cf5928d11.jpg');
/*!40000 ALTER TABLE `eshop_goods_imgs` ENABLE KEYS */;

#
# Structure for table "eshop_order"
#

DROP TABLE IF EXISTS `eshop_order`;
CREATE TABLE `eshop_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `address_id` int(255) NOT NULL DEFAULT '0' COMMENT '收货地址',
  `order_sn` bigint(11) NOT NULL DEFAULT '0' COMMENT '订单号',
  `goods_count` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `pay` char(4) NOT NULL DEFAULT '1' COMMENT '支付方式 1货到付款, 2支付宝',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付总金额',
  `com` varchar(255) NOT NULL DEFAULT '' COMMENT '快递公司代号',
  `no` varchar(255) NOT NULL DEFAULT '' COMMENT '快递单号',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0未支付 1已支付',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0下单 1审核 2发货',
  `is_use_score` char(255) NOT NULL DEFAULT '0' COMMENT '1是0否',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '使用的积分数量',
  `last_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际付款',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '下单时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_order"
#

/*!40000 ALTER TABLE `eshop_order` DISABLE KEYS */;
INSERT INTO `eshop_order` VALUES (1,2,20,2019072851274,1,'1',6299.00,'','',0,0,'0',0,0.00,1564308042),(2,1,20,2019072836247,1,'1',6299.00,'','',0,0,'0',0,0.00,1564308084),(3,1,24,2019072860240,1,'2',6299.00,'','',0,0,'0',0,0.00,1564308104),(4,1,25,2019072816079,1,'2',12598.00,'','',0,0,'0',0,0.00,1564308151),(5,1,25,2019072876801,1,'2',0.00,'','',0,0,'0',0,0.00,1564308266),(6,1,20,2019072831933,1,'1',6299.00,'','',0,0,'0',0,0.00,1564308283),(7,1,20,2019072866790,1,'2',6299.00,'','',0,0,'0',0,0.00,1564309969),(8,1,24,2019073075775,1,'1',6299.00,'','',0,0,'0',0,0.00,1564482324),(9,1,20,2019073095947,1,'2',6299.00,'yd','3723443905002',1,2,'0',0,0.00,1564482748),(10,1,20,2019073047403,1,'2',6299.00,'yd','3833554429606',1,2,'0',0,0.00,1564488283),(11,1,20,2019073077654,1,'2',25196.00,'sto','3717251865772',1,2,'0',0,0.00,1564491035),(39,1,20,2019080154190,1,'2',12598.00,'','',0,0,'1',5000,12548.00,1564630910),(40,1,20,2019080172460,1,'1',12598.00,'','',0,0,'0',0,0.00,1564631781),(41,1,20,2019080169284,1,'2',12598.00,'','',0,0,'1',5000,12548.00,1564631786),(42,1,20,2019080183991,1,'2',6299.00,'','',1,0,'1',5000,6249.00,1564631963),(43,1,20,2019080156409,1,'2',6299.00,'','',0,0,'1',629900,0.00,1564633156);
/*!40000 ALTER TABLE `eshop_order` ENABLE KEYS */;

#
# Structure for table "eshop_order_detail"
#

DROP TABLE IF EXISTS `eshop_order_detail`;
CREATE TABLE `eshop_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单表id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_count` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `goods_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性组合',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_order_detail"
#

/*!40000 ALTER TABLE `eshop_order_detail` DISABLE KEYS */;
INSERT INTO `eshop_order_detail` VALUES (1,1,7,1,'54,60'),(2,1,7,1,'62,60'),(3,2,7,1,'62,63'),(4,3,7,1,'62,61'),(5,4,7,2,'62,61'),(6,6,7,1,'62,61'),(7,7,7,1,'54,60'),(8,8,8,1,'64,67'),(9,9,8,1,'64,67'),(10,10,7,1,'54,60'),(11,11,7,1,'54,60'),(12,11,7,1,'62,60'),(13,11,7,1,'62,61'),(14,11,7,1,'62,63'),(57,36,7,1,'62,63'),(58,36,7,1,'54,61'),(59,37,7,1,'62,63'),(60,37,7,1,'54,61'),(61,38,7,1,'62,63'),(62,38,7,1,'54,61'),(63,39,7,1,'62,63'),(64,39,7,1,'54,61'),(65,40,7,1,'62,63'),(66,40,7,1,'54,61'),(67,41,7,1,'62,63'),(68,41,7,1,'54,61'),(69,42,7,1,'54,61'),(70,43,7,1,'54,61');
/*!40000 ALTER TABLE `eshop_order_detail` ENABLE KEYS */;

#
# Structure for table "eshop_privilege"
#

DROP TABLE IF EXISTS `eshop_privilege`;
CREATE TABLE `eshop_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限名称',
  `controller_name` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(255) NOT NULL DEFAULT '' COMMENT '方法名',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否导航显示 1显示0不显示',
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级权限的id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_privilege"
#

/*!40000 ALTER TABLE `eshop_privilege` DISABLE KEYS */;
INSERT INTO `eshop_privilege` VALUES (1,'商品管理','#','#',1,0),(2,'商品列表','goods','index',1,1),(3,'商品添加','goods','add',1,1),(4,'商品删除','goods','del',0,1),(5,'分类管理','#','#',1,0),(6,'添加分类','category','add',1,5),(7,'角色管理','role','index',1,0),(8,'添加角色','role','add',1,7),(9,'权限管理','#','#',1,0),(10,'权限列表','privilege','index',1,9),(11,'管理员与用户','#','#',1,0),(13,'添加用户','admin','add',1,11),(14,'分配权限','role','index',1,7),(15,'分类列表','category','index',1,5),(16,'商品类型','#','#',1,0),(17,'添加类型','type','add',1,16),(18,'类型列表','type','index',1,16),(19,'商品属性','attribute','index',1,16),(20,'添加属性','attribute','add',1,16);
/*!40000 ALTER TABLE `eshop_privilege` ENABLE KEYS */;

#
# Structure for table "eshop_role"
#

DROP TABLE IF EXISTS `eshop_role`;
CREATE TABLE `eshop_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL DEFAULT '' COMMENT '角色名称',
  `p_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '权限id 多个使用逗号分隔',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_role"
#

/*!40000 ALTER TABLE `eshop_role` DISABLE KEYS */;
INSERT INTO `eshop_role` VALUES (1,'超级管理员',''),(2,'商品管理员','1,2,3,4,5,6,7,9,11');
/*!40000 ALTER TABLE `eshop_role` ENABLE KEYS */;

#
# Structure for table "eshop_score_log"
#

DROP TABLE IF EXISTS `eshop_score_log`;
CREATE TABLE `eshop_score_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1增加 2减少',
  `before_score` int(11) NOT NULL DEFAULT '0' COMMENT '变化前的积分',
  `after_score` int(11) NOT NULL DEFAULT '0' COMMENT '变化后的积分',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '变化积分',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `way` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1签到 2购物',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_score_log"
#

/*!40000 ALTER TABLE `eshop_score_log` DISABLE KEYS */;
INSERT INTO `eshop_score_log` VALUES (1,1,1,0,100,100,'签到增加100积分',1,1564576454),(2,1,1,100,200,100,'签到增加100积分',1,1564576489),(3,1,2,5000,0,5000,'购买商品消耗5000积分',2,1564632011),(4,1,2,2147483647,2147483647,629900,'购买商品消耗629900积分',2,1564633156);
/*!40000 ALTER TABLE `eshop_score_log` ENABLE KEYS */;

#
# Structure for table "eshop_sign"
#

DROP TABLE IF EXISTS `eshop_sign`;
CREATE TABLE `eshop_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `date` varchar(255) NOT NULL DEFAULT '' COMMENT '签到的年月日',
  `addtime` varchar(255) NOT NULL DEFAULT '' COMMENT '签到时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_sign"
#

/*!40000 ALTER TABLE `eshop_sign` DISABLE KEYS */;
INSERT INTO `eshop_sign` VALUES (3,1,'20190730','1564576454'),(4,1,'20190731','1564576489');
/*!40000 ALTER TABLE `eshop_sign` ENABLE KEYS */;

#
# Structure for table "eshop_type"
#

DROP TABLE IF EXISTS `eshop_type`;
CREATE TABLE `eshop_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_type"
#

/*!40000 ALTER TABLE `eshop_type` DISABLE KEYS */;
INSERT INTO `eshop_type` VALUES (1,'手机'),(2,'电脑');
/*!40000 ALTER TABLE `eshop_type` ENABLE KEYS */;

#
# Structure for table "eshop_user"
#

DROP TABLE IF EXISTS `eshop_user`;
CREATE TABLE `eshop_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `phone` varchar(255) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户积分',
  `salt` varchar(255) NOT NULL DEFAULT '' COMMENT '密码盐',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否激活 1是0否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_user"
#

/*!40000 ALTER TABLE `eshop_user` DISABLE KEYS */;
INSERT INTO `eshop_user` VALUES (1,'lamlujun','Lammm','13728272324','416596401@qq.com','f7e76d389af3d77fa61f2f417ce0b67b',4294337395,'690135',1),(9,'newday','lam','13728275754','','db5a8c354f03f33252dc51e27f6dd188',0,'749708',1);
/*!40000 ALTER TABLE `eshop_user` ENABLE KEYS */;

#
# Structure for table "eshop_user_img"
#

DROP TABLE IF EXISTS `eshop_user_img`;
CREATE TABLE `eshop_user_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_img` varchar(255) NOT NULL DEFAULT '' COMMENT '用户图片',
  `user_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否使用 1是0否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Data for table "eshop_user_img"
#

/*!40000 ALTER TABLE `eshop_user_img` DISABLE KEYS */;
INSERT INTO `eshop_user_img` VALUES (7,1,'upload/header/20190729/17a43c5327eee14782b0077d33057693.jpg','upload/header/20190729/thumb_17a43c5327eee14782b0077d33057693.jpg',0),(8,1,'upload/header/20190729/658587601ba4016a2ce1ca1cef238333.jpg','upload/header/20190729/thumb_658587601ba4016a2ce1ca1cef238333.jpg',0),(9,1,'upload/header/20190729/055bee8e3779e50209b8584a6a4dd02e.jpg','upload/header/20190729/thumb_055bee8e3779e50209b8584a6a4dd02e.jpg',0),(10,1,'upload/header/20190729/3263ee37f830b5a7d1f6f6c89fed9a99.jpg','upload/header/20190729/thumb_3263ee37f830b5a7d1f6f6c89fed9a99.jpg',0),(11,1,'upload/header/20190729/a6a720d700493146c5abc70daee89238.jpg','upload/header/20190729/thumb_a6a720d700493146c5abc70daee89238.jpg',0),(12,1,'upload/header/20190729/12d07bd257d5f956d59f32b3516c0423.jpg','upload/header/20190729/thumb_12d07bd257d5f956d59f32b3516c0423.jpg',1),(13,9,'upload/header/20190729/95b7888e112ac03e18b98f12648a65fe.jpg','upload/header/20190729/thumb_95b7888e112ac03e18b98f12648a65fe.jpg',1);
/*!40000 ALTER TABLE `eshop_user_img` ENABLE KEYS */;

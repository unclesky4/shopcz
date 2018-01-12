# 创建数据库
CREATE database shopcz charset utf8;

# 选择数据库
use shopcz;

/*------------------------------------商品模块---------------------------------------*/

#创建商品类别表
create table cz_category(
	cat_id smallint unsigned not null auto_increment primary key comment '商品类别ID',
	cat_name varchar(30) not null default '' comment '商品类别名称',
	parent_id smallint unsigned not null default 0 comment '商品类别父ID',
	cat_desc varchar(255) not null default '' comment '商品类别描述',
	sort_order tinyint not null default 50 comment '排序依据',
	unit varchar(15) not null default '' comment '单位',
	is_show tinyint not null default 1 comment '是否显示，默认显示',
	index pid(parent_id)
)engine=MyISAM charset=utf8;

# 商品类型表
create table cz_goods_type(
	type_id smallint unsigned not null auto_increment primary key comment '商品类型ID',
	type_name varchar(50) not null default '' comment '商品类型名称'
)engine=MyISAM charset=utf8;

#创建商品品牌表
create table cz_brand(
	brand_id smallint unsigned not null auto_increment primary key comment '商品品牌ID',
	brand_name varchar(30) not null default '' comment '商品品牌名称',
	brand_desc varchar(255) not null default '' comment '商品品牌描述',
	url varchar(100) not null default '' comment '商品品牌网址',
	logo varchar(50) not null default '' comment '品牌logo',
	sort_order tinyint unsigned not null default 50 comment '商品品牌排序依据',
	is_show tinyint not null default 1 comment '是否显示，默认显示'
)engine=MyISAM charset=utf8;

#创建商品属性表
create table cz_attribute(
	attr_id smallint unsigned not null auto_increment primary key comment '商品属性ID',
	attr_name varchar(50) not null default '' comment '商品属性名称',
	type_id smallint not null default 0 comment '商品属性所属类型ID',
	attr_type tinyint not null default 1 comment '属性是否可选 0 为唯一，1为单选，2为多选',
	attr_input_type tinyint not null default 1 comment '属性录入方式 0为手工录入，1为从列表中选择，2为文本域',
	attr_value text comment '属性的值',
	sort_order tinyint not null default 50 comment '属性排序依据',
	index type_id(type_id)
)engine=MyISAM charset=utf8;

# 商品表
CREATE TABLE cz_goods(
  goods_id int unsigned not NULL auto_increment PRIMARY KEY comment '商品ID',
  goods_sn varchar(30) not null default '' comment '商品货号',
  goods_name VARCHAR (100) not null default '' comment '商品名称',
  goods_brief varchar(255) not null default '' comment '商品简单描述',
  goods_desc text comment '商品详情',
  cat_id smallint unsigned not null default 0 comment '商品所属类别ID',
	brand_id smallint unsigned not null default 0 comment '商品所属品牌ID',
	market_price decimal(10,2) not null default 0 comment '市场价',
	shop_price decimal(10,2) not null default 0 comment '本店价格',
	promote_price decimal(10,2) not null default 0 comment '促销价格',
	promote_start_time int unsigned not null default 0 comment '促销起始时间',
	promote_end_time int unsigned not null default 0 comment '促销截止时间',
	goods_img varchar(50) not null default '' comment '商品图片',
	goods_thumb varchar(50) not null default '' comment '商品缩略图',
	goods_number smallint unsigned not null default 0 comment '商品库存',
	click_count int unsigned not null default 0 comment '点击次数',
	type_id smallint unsigned not null default 0 comment '商品类型ID',
	is_promote tinyint unsigned not null default 0 comment '是否促销，默认为0不促销',
	is_best tinyint unsigned not null default 0 comment '是否精品,默认为0',
	is_new tinyint unsigned not null default 0 comment '是否新品，默认为0',
	is_hot tinyint unsigned not null default 0 comment '是否热卖,默认为0',
	is_onsale tinyint unsigned not null default 1 comment '是否上架,默认为1',
	add_time int unsigned not null default 0 comment '添加时间',
  index cat_id(cat_id),
  index brand_id(brand_id),
  index type_id(type_id)
)engine=MyISAM charset=utf8;

#创建商品属性对应表
create table cz_goods_attr(
	goods_attr_id int unsigned not null auto_increment primary key comment '编号ID',
	goods_id int unsigned not null default 0 comment '商品ID',
	attr_id smallint unsigned not null default 0 comment '属性ID',
	attr_value varchar(255) not null default '' comment '属性值',
	attr_price decimal(10,2) not null default 0 comment '属性价格',
	index goods_id(goods_id),
	index attr_id(attr_id)
)engine=MyISAM charset=utf8;

#创建商品相册表
create table cz_galary(
	img_id int unsigned not null auto_increment primary key comment '图片编号',
	goods_id int unsigned not null default 0 comment '商品ID',
	img_url varchar(50) not null default '' comment '图片URL',
	thumb_url varchar(50) not null default '' comment '缩略图URL',
	img_desc varchar(50) not null default '' comment '图片描述',
	index goods_id(goods_id)
)engine=MyISAM charset=utf8;

/*------------------------------------商品模块 end-----------------------------------*/


/*------------------------------------用户模块 start-----------------------------------*/
#创建用户表
create table cz_user(
	admin_id int unsigned not null auto_increment,
	-- 认证相关
	admin_name varchar(32) not null default '' comment '管理员姓名',
	admin_pass char(32) not null default '' comment '密码,md5加密后的密码',
	-- 权限
	role_id int unsigned not null default 0 comment '所属的角色ID，RBAC',
	-- 登录相关信息
	last_ip int unsigned not null default 0 comment '上次登录IP',
	last_time int comment '上次登录时间',
	-- 管理员属性信息
	primary key (admin_id)
)engine=MyISAM charset=utf8;

#插入几条用户数据
insert into cz_user values
	(23, 'admin', md5('1234abcd'), 0, 0, 0),
	(42, 'kang', md5('1234abcd'), 0, 0, 0),
	(45, 'php34', md5('1234abcd'), 0, 0, 0);
/*------------------------------------用户模块 end-----------------------------------*/

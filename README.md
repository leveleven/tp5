钉钉程序（生产流程）后台
===============

本项目使用Thinkphp5.0作为框架，实现数据的增删改查，url如下：

 + 主页数据表API：[url]/flow{ /id || /orderId}
 + 库存表API：[url]/storage{ /id || /orderId}
 + 生产表API：[url]/production{ /id || /orderId}
 + 质检表API：[url]/quality{ /id || /orderId}

> ThinkPHP5的运行环境要求PHP5.4以上。

详细开发文档参考 [ThinkPHP5完全开发手册](http://www.kancloud.cn/manual/thinkphp5)

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─config.php      模块配置文件
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

> router.php用于php自带webserver支持，可用于快速测试
> 切换到public目录后，启动命令：php -S localhost:8888  router.php
> 上面的目录结构和名称是可以改变的，这取决于你的入口文件和配置参数。

## 关于此项目

本项目一共创建了四个module，分别对应数据表（附上创建数据表命令）：
*   flow
```$xslt
create table think_main
(
  id           int unsigned auto_increment comment 'ID' primary key,
  orderId      int default '0' not null comment '订单编号',
  production   char(100) default '' not null comment '产品名字',
  customer     char(100) not null comment '客户',
  material     char(100) not null comment '材料名',
  picNumber    char(100) not null comment '图号',
  quantity     int default '0' not null comment '生产数量',
  startDate    date not null comment '开始时间',
  finished     int default '0' not null comment '成品数量',
  success      char(100) default '0' not null comment '合格率',
  delivery     int default '0' not null comment '交付数量',
  endDate      date null comment '交付时间',
  status       tinyint(1) default '0' not null comment '状态'
)
  comment '总览表' engine = MyISAM charset = utf8;
```
*   production
```$xslt
create table think_production
(
  id           int unsigned auto_increment comment 'ID' primary key,
  orderId      char(50) default '' not null comment '订单编号',
  workstage1   int default '0' not null comment '工序一',
  workstage2   int default '0' not null comment '工序二',
  workstage3   int default '0' not null comment '工序三',
  date         date null comment '日期',
  status       int unsigned default '0' not null comment '状态'
)
  comment '生产表' engine = MyISAM charset = utf8;
```
*   quality
```$xslt
create table think_quality
(
  id          int unsigned auto_increment comment 'ID' primary key,
  orderId     int default '0' not null comment '订单编号',
  quantity    int default '0' not null comment '总数',
  qualified   int default '0' not null comment '合格',
  pending     int default '0' not null comment '待判',
  unqualified int default '0' not null comment '不合格',
  status      int unsigned default '0' not null comment '状态'
)
  comment '质检表' engine = MyISAM charset = utf8;
```
*   storage
```$xslt
create table think_storage
(
  id           int unsigned auto_increment comment 'ID' primary key,
  orderId      char(50) default '' not null comment '订单编号',
  material     char(100) default '' not null comment '材料',
  quantity     int default '0' not null comment '数量',
  stockDate    date not null comment '入库时间',
  deliveryDate date null comment '出库时间',
  status       int unsigned default '0' not null comment '状态'
)
  comment '库存表' engine = MyISAM charset = utf8;
```

## 命名规范

`ThinkPHP5`遵循PSR-2命名规范和PSR-4自动加载规范，并且注意如下规范：

### 目录和文件

*   目录不强制规范，驼峰和小写+下划线模式均支持；
*   类库、函数文件统一以`.php`为后缀；
*   类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；
*   类名和类文件名保持一致，统一采用驼峰法命名（首字母大写）；

### 函数和类、属性命名

*   类的命名采用驼峰法，并且首字母大写，例如 `User`、`UserType`，默认不需要添加后缀，例如`UserController`应该直接命名为`User`；
*   函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
*   方法的命名使用驼峰法，并且首字母小写，例如 `getUserName`；
*   属性的命名使用驼峰法，并且首字母小写，例如 `tableName`、`instance`；
*   以双下划线“__”打头的函数或方法作为魔法方法，例如 `__call` 和 `__autoload`；

### 常量和配置

*   常量以大写字母和下划线命名，例如 `APP_PATH`和 `THINK_PATH`；
*   配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；

### 数据表和字段

*   数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表字段命名。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2018 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)

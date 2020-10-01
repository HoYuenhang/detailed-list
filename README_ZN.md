# detailed-list

![DetailedList](https://img.shields.io/badge/DetailedList-2.0.0-orange)

[English](https://github.com/Jackie1123/detailed-list/blob/master/README.md) | 中文

## 这是什么？
一个简单的任务清单帮你记录生活的琐事。
## 关于更新
2.0.0 ——> 你可以用你的私人账户登录清单。

1.0.0 ——> 清单诞生。
## Demo
### 桌面界面
![](https://s1.ax1x.com/2020/09/09/w34jTe.png)
### 移动界面
![](https://s1.ax1x.com/2020/09/09/w35A0S.jpg)
## 如何使用？
1. 电脑中需要安装本地服务器(可以解释PHP)和MySQL。
2. 创建一个叫做**detailed_list**的数据库。
```MySQL
CREATE DATABASE detailed_list charset=utf8;
```
3. 在detailed_list数据库里创建一个叫做**project**的表。
```MySQL
CREATE TABLE project(
    id int PRIMARY KEY auto_increment,
    isFinished TINYINT NOT NULL COMMENT '是否完成',
    content text NOT NULL COMMENT '内容',
    pub_time INT NOT NULL COMMENT '时间戳',
    label varchar(10) COMMENT '标签',
    admin varchar(50) COMMENT '所有者'
)charset utf8;
```
4. 在detailed_list数据库里创建一个叫做**project**的表。
```MySQL
CREATE TABLE admin(
    id int PRIMARY KEY auto_increment,
    admin varchar(50) NOT NULL unique COMMENT '所有者',
    password varchar(18) NOT NULL COMMENT '密码'
)charset utf8;
```
5. 进入项目目录```detail-list/app/```, 打开```database_login.php```, 修改```MySQL address:port```, MySQL ```user``` 和 ```password```。

![](https://s1.ax1x.com/2020/07/01/NTTBOe.jpg)

6. 在浏览器中输入localhost的地址即可访问(请访问名为login.html(```html/login.html```)的文件)。
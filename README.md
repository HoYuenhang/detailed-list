# detailed-list

![DetailedList](https://img.shields.io/badge/DetailedList-2.0.0-orange)

English | [中文](https://github.com/Jackie1123/detailed-list/blob/master/README_ZN.md)（同步更新）

## What is it？
A simple detailed-list.Help you remember trivia of live.
## What's new？
2.0.0 ——> You can login with your personal account.

1.0.0 ——> Birthday of detailed-list.
## Demo
### Desktop UI
![](https://s1.ax1x.com/2020/09/09/w34jTe.png)
### Mobile UI
![](https://s1.ax1x.com/2020/09/09/w35A0S.jpg)
## How to use？
1. A server(with PHP) and MySQL is necessary.
2. Create a database named **detailed_list**.
```MySQL
CREATE DATABASE detailed_list charset=utf8;
```
3. Create a table named **project** on detailed_list.
```MySQL
CREATE TABLE project(
    id int PRIMARY KEY auto_increment,
    isFinished TINYINT NOT NULL COMMENT '是否完成',
    content text NOT NULL COMMENT '内容',
    pub_time INT NOT NULL COMMENT '时间戳',
    label varchar(10) COMMENT '标签'
)charset utf8;
```
4.Create a table named **admin** on detailed_list.
```
CREATE TABLE admin(
    id int PRIMARY KEY auto_increment,
    admin varchar(50) NOT NULL unique COMMENT '所有者',
    password varchar(18) NOT NULL COMMENT '密码'
)charset utf8;
```
5. Enter directory ```detail-list/app/```, open```database_login.php```, modify the ```MySQL address:port```, MySQL ```user``` and ```password```.

![](https://s1.ax1x.com/2020/07/01/NTTBOe.jpg)

6. Input the localhost address in your browser(Visit the document named login.html(```html/login.html```) first).
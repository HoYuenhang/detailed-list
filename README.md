# detailed-list
![DetailedList](https://img.shields.io/badge/detailedlist-1.0.0-orange)
## What is it？
A simple detailed-list.Help you remember trivia of live.
## Demo
### Desktop UI
[![NTh6ns.png](https://s1.ax1x.com/2020/07/01/NTh6ns.png)](https://imgchr.com/i/NTh6ns)
### Mobile UI
[![NThcBn.jpg](https://s1.ax1x.com/2020/07/01/NThcBn.jpg)](https://imgchr.com/i/NThcBn)
## How to use？
1. A server and MySQL is necessary.
2. Create a database named **detailed-list**.
Code：
```MySQL
CREATE DATABASE detailed_list charset=utf8;
```
3. Create a table named **project** on detailed-list.
Code：
```MySQL
CREATE TABLE project(
    id int PRIMARY KEY auto_increment,
    isFinished TINYINT NOT NULL COMMENT '是否完成',
    content text NOT NULL COMMENT '内容',
    pub_time INT NOT NULL COMMENT '时间戳'
)charset utf8;
```
4. Enter directory ```detail-list/php/```, open```database_login.php```, modify the ```MySQL address:port```, MySQL ```user``` and ```password```.
![](https://s1.ax1x.com/2020/07/01/NTTBOe.jpg)
5. Input the localhost address in your browser.
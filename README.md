## 简介

edu：education，在线课程网站

## 主要功能

*  课程管理：创建课程、添加课时、添加课程资料
*  用户管理：角色管理、权限分配
*  个人中心：学习进度、课程收藏、文章收藏
*  文件管理：上传、删除文件，文件组管理
*  数据管理：数据备份、恢复

## 基本架构
Apache/2.4.23 + PHP/5.4.45 + MySQL/5.5.53

## 前端组件
*  bootstrap
*  adminlte
*  bootstrap-confirmation
*  bootstrap-notify
*  bootstrap-validation
*  seajs
*  jquery
*  jquery-ui
*  jquery-plupload-queue
*  ckeditor
*  video-js
*  jquery-perfect-scrollbar
*  jquery-sortable
*  bootstrap-fileinput

## 后端组件
*  ThinkPHP


## 更新日志

#### 2018.04.18
*  课程文件管理，文件的删除
*  课时文件添加，修复ckeditor编辑器加载错误
*  数据管理页面小问题

#### 2018.04.19
*  修复了登录和注册跳转问题
*  服务端会话中登记用户信息
*  默认登录两小时，选择记住登录可保持7天
*  添加站点首页
*  URL调整为rewirte模式

#### 2018.04.20
*  为后台添加了ajax login登录界面，对每个ajax的请求的错误进行了处理，如果返回的消息为unlogin，则弹出登录界面
*  记住登录后，系统更新会话时错误修复
*  添加课程详介绍页
*  添加课程学习页

#### 2018.04.22
*  修复后台课时内容未提交至服务端错误
*  前台学习界面完成

#### 2018.04.23
*  完成课程资料下载
*  完成视频课程播放
*  后台上传视频文件错误修复
*  完成课时资料添加

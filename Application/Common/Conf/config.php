<?php
return array(
	'SHOW_PAGE_TRACE'       =>  false,    // 显示错误信息
	//'配置项'=>'配置值'
    'DEFAULT_AVATAR' => '/Public/images/user-avatar.png',
    'UPLOAD_DIR' => './Uploads/',// 文件上传目录
    'UPLOAD_MAXSIZE_USER' => 10485760,// 普通用户最大上传文件大小 10M
    'UPLOAD_MAXSIZE_TEACHER' => 524288000,// 普通用户最大上传文件大小 100M
    'UPLOAD_MAXSIZE_ADMIN' => 524288000,// 普通用户最大上传文件大小 100M,
    'UPLOAD_FILE_TYPE' => array('jpg','jpeg','gif','png','txt','doc','docx','xls','xlsx','pdf','ppt','pptx','pps','mp4','mp3','avi','flv','wmv','wma','zip','rar','gz','tar','7z','swf'),
    'HTTP_CACHE_CONTROL'    =>  'no-cache',  // 网页缓存控制

    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'edu',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号

    'URL_MODEL'             =>  2,
);
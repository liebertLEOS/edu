<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_AVATAR' => '/Public/images/user-avatar.png',
    'UPLOAD_DIR' => './Uploads/',// 文件上传目录
    'UPLOAD_MAXSIZE_USER' => 10485760,// 普通用户最大上传文件大小 10M
    'UPLOAD_MAXSIZE_TEACHER' => 524288000,// 普通用户最大上传文件大小 100M
    'UPLOAD_MAXSIZE_ADMIN' => 524288000,// 普通用户最大上传文件大小 100M,
    'UPLOAD_FILE_TYPE' => array('jpg','jpeg','gif','png','txt','doc','docx','xls','xlsx','pdf','ppt','pptx','pps','mp4','mp3','avi','flv','wmv','wma','zip','rar','gz','tar','7z','swf'),
    'HTTP_CACHE_CONTROL'    =>  'no-cache',  // 网页缓存控制
);
<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_AVATAR' => '/Public/images/user-avatar.png',
    'UPLOAD_DIR' => './Uploads/',// 文件上传目录
    'UPLOAD_MAXSIZE_USER' => 10485760,// 普通用户最大上传文件大小 10M
    'UPLOAD_MAXSIZE_TEACHER' => 10485760,// 普通用户最大上传文件大小 100M
    'UPLOAD_MAXSIZE_ADMIN' => 10485760,// 普通用户最大上传文件大小 100M,
    'UPLOAD_FILE_TYPE' => array('jpg', 'gif', 'png', 'jpeg', 'mp4'),
);
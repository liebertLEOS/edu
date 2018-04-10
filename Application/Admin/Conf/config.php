<?php
return array(
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

    /* 数据库备份路径配置 */
    'DATA_BACKUP_PATH'           => './Data',
    'DATA_BACKUP_PART_SIZE'      => 20971520,
    'DATA_BACKUP_COMPRESS'       => 1,
    'DATA_BACKUP_COMPRESS_LEVEL' => 9,

    'SHOW_PAGE_TRACE'       =>  true,    // 显示错误信息
    'MENU' => array(
        array(
            'id'       => '1',
            'title'    => '系统配置',
            'url'      => '#',
            'icon'     => 'gear',
            'path'     => '1',
            'children' => array(
                array(
                    'id'       => '2',
                    'title'    => '网站设置',
                    'url'      => 'Admin/Setting/website',
                    'icon'     => 'circle-o',
                    'path'     => '1,2',
                    'children' => null
                ),
                array(
                    'id'       => '3',
                    'title'    => '用户设置',
                    'url'      => 'Admin/Setting/user',
                    'icon'     => 'circle-o',
                    'path'     => '1,3',
                    'children' => null
                ),
                array(
                    'id'       => '4',
                    'title'    => '课程设置',
                    'url'      => 'Admin/Setting/course',
                    'icon'     => 'circle-o',
                    'path'     => '1,4',
                    'children' => null
                ),
                array(
                    'id'       => '5',
                    'title'    => '系统日志',
                    'url'      => 'Admin/Setting/log',
                    'icon'     => 'circle-o',
                    'path'     => '1,5',
                    'children' => null
                )
            )
        ),
        array(
            'id'       => '6',
            'title'    => '用户管理',
            'icon'     => 'user',
            'url'      => '#',
            'path'     => '6',
            'children' => array(
                array(
                    'id'       => '7',
                    'title'    => '用户管理',
                    'url'      => 'Admin/User/index',
                    'icon'     => 'circle-o',
                    'path'     => '6,7',
                    'children' => null
                ),
//                array(
//                    'id'       => '8',
//                    'title'    => '教师管理',
//                    'url'      => '',
//                    'icon'     => 'circle-o',
//                    'path'     => '6,8',
//                    'children' => null
//                ),
                array(
                    'id'       => '9',
                    'title'    => '私信管理',
                    'url'      => '',
                    'icon'     => 'circle-o',
                    'path'     => '6,9',
                    'children' => null
                )
            )
        ),
        array(
            'id'       => '10',
            'title'    => '课程管理',
            'icon'     => 'graduation-cap',
            'url'      => '#',
            'path'     => '10',
            'children' => array(
                array(
                    'id'       => '11',
                    'title'    => '查看课程',
                    'url'      => '',
                    'icon'     => 'circle-o',
                    'path'     => '10,11',
                    'children' => null
                ),
                array(
                    'id'       => '12',
                    'title'    => '课程公告',
                    'url'      => '',
                    'icon'     => 'circle-o',
                    'path'     => '10,12',
                    'children' => null
                ),
                array(
                    'id'       => '13',
                    'title'    => '课程问答',
                    'url'      => '',
                    'icon'     => 'circle-o',
                    'path'     => '10,13',
                    'children' => null
                ),
                array(
                    'id'       => '14',
                    'title'    => '课程资料',
                    'url'      => '',
                    'icon'     => 'circle-o',
                    'path'     => '10,14',
                    'children' => null
                )
            )
        ),
        array(
            'id'       => '19',
            'title'    => '文件管理',
            'icon'     => 'file',
            'url'      => '#',
            'path'     => '19',
            'children' => array(
                array(
                    'id'       => '20',
                    'title'    => '查看文件',
                    'url'      => 'Admin/File/index',
                    'icon'     => 'circle-o',
                    'path'     => '19,20',
                    'children' => null
                ),
                array(
                    'id'       => '21',
                    'title'    => '查看文件组',
                    'url'      => 'Admin/FileGroup/index',
                    'icon'     => 'circle-o',
                    'path'     => '19,21',
                    'children' => null
                )
            )
        ),
        array(
            'id'       => '15',
            'title'    => '数据管理',
            'icon'     => 'database',
            'url'      => '#',
            'path'     => '15',
            'children' => array(
                array(
                    'id'       => '16',
                    'title'    => '数据维护',
                    'url'      => 'Admin/DataBase/repair',
                    'icon'     => 'circle-o',
                    'path'     => '15,16',
                    'children' => null
                ),
                array(
                    'id'       => '17',
                    'title'    => '数据备份',
                    'url'      => 'Admin/DataBase/export',
                    'icon'     => 'circle-o',
                    'path'     => '15,17',
                    'children' => null
                ),
                array(
                    'id'       => '18',
                    'title'    => '数据恢复',
                    'url'      => 'Admin/DataBase/import',
                    'icon'     => 'circle-o',
                    'path'     => '15,18',
                    'children' => null
                )
            )
        )
    )
);
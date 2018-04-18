<?php
return array(
    /* 数据库备份路径配置 */
    'DATA_BACKUP_PATH'           => './Data',
    'DATA_BACKUP_PART_SIZE'      => 20971520,
    'DATA_BACKUP_COMPRESS'       => 1,
    'DATA_BACKUP_COMPRESS_LEVEL' => 9,

    'MENU' => array(
        array(
            'id'       => '1',
            'title'    => '系统管理',
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
                    'url'      => 'Admin/Course/index',
                    'icon'     => 'circle-o',
                    'path'     => '10,11',
                    'children' => array(
                        array(
                            'id'       => '22',
                            'title'    => '课时管理',
                            'url'      => 'Admin/CourseLesson/index',
                            'icon'     => 'circle-o',
                            'path'     => '10,11,22',
                            'children' => null
                        ),
                        array(
                            'id'       => '23',
                            'title'    => '文件管理',
                            'url'      => 'Admin/CourseMaterial/listByCourseId',
                            'icon'     => 'circle-o',
                            'path'     => '10,11,23',
                            'children' => null
                        ),
                        array(
                            'id'       => '24',
                            'title'    => '学员管理',
                            'url'      => '',
                            'icon'     => 'circle-o',
                            'path'     => '10,11,24',
                            'children' => null
                        )
                    )
                ),
                array(
                    'id'       => '12',
                    'title'    => '课程话题',
                    'url'      => 'Admin/CourseTopic/index',
                    'icon'     => 'circle-o',
                    'path'     => '10,12',
                    'children' => null
                ),
                // array(
                //     'id'       => '13',
                //     'title'    => '课程问答',
                //     'url'      => '',
                //     'icon'     => 'circle-o',
                //     'path'     => '10,13',
                //     'children' => null
                // ),
                array(
                    'id'       => '14',
                    'title'    => '课程资料',
                    'url'      => 'Admin/CourseMaterial/index',
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
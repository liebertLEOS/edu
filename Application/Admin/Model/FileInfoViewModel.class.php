<?php

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/4/9
 * Time: 10:44
 */
namespace Admin\Model;

use Think\Model\ViewModel;

class FileInfoViewModel extends ViewModel
{
    public $viewFields = array(
        'file' => array(
            'id',
            'originName',
            'uri',
            'ext',
            'size',
            'status',
            'createdTime',
            'mime',
            '_type'=>'LEFT'
        ),
        'file_group' => array(
            'name' => 'filegroupname',
            '_on'=>'file.groupId=file_group.id',
            '_type'=>'LEFT'
        ),
        'user' => array(
            'nickname' => 'username',
            '_on'=>'file.userId=user.id',
        )
    );
}
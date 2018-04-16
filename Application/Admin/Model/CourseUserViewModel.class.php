<?php
/**
 *
 */
namespace Admin\Model;

use Think\Model\ViewModel;

class CourseUserViewModel extends ViewModel
{
    public $viewFields = array(
        'course' => array(
            'id',
            'title',
            'serializemode',
            'studentnum',
            'status',
            '_type'=>'LEFT'
        ),
        'user' => array(
            'nickname' => 'createduser',
            '_on'=>'course.userId=user.id',
        )
    );
}
<?php
/**
 *    BaseController(Admin\Controller\BaseController.class.php)
 *
 *    功　　能：后台首页基类控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/10
 *    修　　改：2018/04/10
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
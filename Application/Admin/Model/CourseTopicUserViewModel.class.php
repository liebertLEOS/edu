<?php
/**
 *    CourseTopicUserViewModel(Admin\Model\CourseTopicUserViewModel.class.php)
 *
 *    功　　能：课程话题+用户视图
 *
 *    作　　者：李康
 *    完成时间：2018/04/15 12:23
 *    修　　改：2018/04/15
 *
 */
namespace Admin\Model;

use Think\Model\ViewModel;

class CourseTopicUserViewModel extends ViewModel
{
    public $viewFields = array(
        'course_topic' => array(
            'id',
            'title',
            'content',
            'isElite',
            'isStick',
            'postNum',
            'hitNum',
            '_type'=>'LEFT'
        ),
        'user' => array(
            'nickname',
            '_on'=>'course_topic.userId=user.id',
        )
    );
}
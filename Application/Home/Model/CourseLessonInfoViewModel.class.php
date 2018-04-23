<?php
/**
 *    CourseLessonInfoViewModel(Admin\Model\CourseLessonInfoViewModel.class.php)
 *
 *    功　　能：课时详细信息视图
 *
 *    作　　者：李康
 *    完成时间：2018/04/23 11:10
 *    修　　改：2018/04/23
 *
 */
namespace Home\Model;

use Think\Model\ViewModel;

class CourseLessonInfoViewModel extends ViewModel
{
    public $viewFields = array(
        'course_lesson' => array(
            'id',
            'courseId',
            'title',
            'type',
            'number',
            'content',
            '_type'=>'LEFT'
        ),
        'file' => array(
            'uri',
            '_on'=>'course_lesson.mediaId=file.id',
        )
    );
}
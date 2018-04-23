<?php
/**
 *    CourseLessonMaterialViewModel(Admin\Model\CourseLessonMaterialViewModel.class.php)
 *
 *    功　　能：课时资料视图
 *
 *    作　　者：李康
 *    完成时间：2018/04/15 12:23
 *    修　　改：2018/04/15
 *
 */
namespace Admin\Model;

use Think\Model\ViewModel;

class CourseLessonMaterialViewModel extends ViewModel
{
    public $viewFields = array(
        'course_lesson' => array(
            'id',
            'courseId',
            'title',
            'summary',
            'type',
            'content',
            'mediaUri',
            'status',
            'mediaId',
            'free',
            '_type'=>'LEFT'
        ),
        'file' => array(
            'originName' => 'medianame',
            '_on'=>'course_lesson.mediaId=file.id',
        )
    );
}
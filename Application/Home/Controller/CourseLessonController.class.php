<?php
/**
 *    CourseLessonController(Home\Controller\CourseLessonController.class.php)
 *
 *    功　　能：前台课程课时控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/20 15:49
 *    修　　改：2018/04/19
 *
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class CourseLessonController extends BaseController
{
    public function __construct()
    {
        // 课时操作需要登录
        $this->ajaxLogin();
        parent::__construct();
    }

    public function learn()
    {
        $lessonId = I('request.lesson_id', 0);

        if ($lessonId <=0 ) {
            $this->error('课时ID不合法');
        }
        $lesson = M('CourseLesson')->field('id,title,type,number')->where("id={$lessonId}")->find();

        if (!$lesson) {
            $this->error('课时不存在');
        }

        $this->assign('lesson', $lesson);
    	$this->display();
    }

    /**
     *  课时预览
     */
    public function preview()
    {

    }

    public function ajaxGetContent()
    {
        $lessonId = I('request.lesson_id', 0);

        if ($lessonId <=0 ) {
            $this->error('课时ID不合法');
        }
        $lesson = M('CourseLesson')->field('type,content')->where("id={$lessonId}")->find();

        if (!$lesson) {
            $this->error('课时不存在');
        }
        $this->ajaxReturn(array(
            'type' => $lesson['type'],
            'content' => $lesson['content']
        ));
    }
}
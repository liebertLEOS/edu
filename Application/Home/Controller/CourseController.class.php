<?php
/**
 *    CourseController(Home\Controller\CourseController.class.php)
 *
 *    功　　能：前台课程控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/19 17:38
 *    修　　改：2018/04/19
 *
 */
namespace Home\Controller;
use Think\Controller;

class CourseController extends BaseController {

    public function index()
    {
    	$courseId = I('get.course_id');

    	if ($courseId <= 0) {
    		$this->error('课程ID参数错误！');
    	}
    	
    	$course = M('Course')->where("id={$courseId}")->find();

    	$this->assign('course', $course);
    	$this->assign('user', $this->user);
    	$this->display();
    }

    public function intro()
    {
    	$courseId = I('get.course_id');

    	if ($courseId <= 0) {
    		$this->error('课程ID参数错误！');
    	}
    	
    	$course = M('Course')->where("id={$courseId}")->find();

    	$this->assign('course', $course);
    	$this->assign('user', $this->user);
    	$this->display();
    }
}
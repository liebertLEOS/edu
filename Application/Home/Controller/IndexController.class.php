<?php
/**
 *    IndexController(Home\Controller\IndexController.class.php)
 *
 *    功　　能：前台首页控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/19 15:00
 *    修　　改：2018/04/19
 *
 */
namespace Home\Controller;
use Think\Controller;

class IndexController extends BaseController {

    public function index()
    {
    	
    	$courses = D('CourseInfoView')->order('course.createdTime')->limit(8)->select();

    	$this->assign('courses', $courses);
    	$this->display();
    }

    public function about ()
    {
    	$this->display();
    }
}
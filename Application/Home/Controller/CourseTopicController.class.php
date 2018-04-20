<?php
/**
 *    CourseTopicController(Home\Controller\CourseTopicController.class.php)
 *
 *    功　　能：前台课程话题控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/19 21:33
 *    修　　改：2018/04/19
 *
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class CourseTopicController extends BaseController {

    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $Model = M('CourseTopic');

        $data = $Model->page("$page, $numPerPage")->select();
        $count = $Model->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

    	$this->assign('data', $data);
        $this->assign('page', $pageHtml);
    	$this->display();
    }

}
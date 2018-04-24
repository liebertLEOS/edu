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
use Think\Page;

class CourseController extends CourseBaseController {

    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $Model = D('CourseInfoView');

        $data = $Model->page("$page, $numPerPage")->select();
        $count = $Model->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

    	$this->assign('data', $data);
        $this->assign('page', $pageHtml);
    	$this->display();
    }

    public function intro()
    {
    	$courseId = I('get.course_id');

    	if ($courseId <= 0) {
    		$this->error('课程ID参数错误！');
    	}
    	
    	$course = M('Course')->where("id={$courseId}")->find();
        $lessonItems = $this->getCourseLessonItems($courseId);
        $member = $this->getMember($courseId);

    	$this->assign('course', $course);
        $this->assign('member', $member);
        $this->assign('lessonItems', $lessonItems);
    	$this->display();
    }

    /**
     *  加入学习
     */
    public function learn()
    {
        // 用户必须登录
        $this->ajaxLogin();
        $user = $this->user;

        $courseId = I('get.course_id');

        if ($courseId <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '课程ID参数错误！'
            ));
        }

        if (IS_POST) {
            // 查看是否已经加入学习
            $Model = M('CourseMember');
            $data = $Model->where("courseId={$courseId} AND userId={$user['id']}")->find();
            
            if ($data) {
                $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '加入学习成功'
                ));
            }
            $data = array(
                'courseId' => $courseId,
                'userId' => $user['id'],
                'joinedType' => 'course',
                'role' => $this->isGrant('TEACHER') ? 'teacher' : 'student',
                'createdTime' => time()
            );
            $id = $Model->add($data);
            if ($id) {
                $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '加入学习成功'
                ));
            } else {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '加入失败'
                ));
            }
            
        }

        $this->assign('courseId', $courseId);
        $this->display();
    }

    public function ajaxGetLessonItems()
    {
        $courseId = I('get.course_id');
        $lessonId = I('get.lesson_id');

        if ($courseId <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '课程ID参数错误！'
            ));
        }
        $lessonItems = $this->getCourseLessonItems($courseId);

        $this->assign('lessonId', $lessonId);
        $this->assign('lessonItems', $lessonItems);
        $this->ajaxReturn(array(
            'success' => true,
            'content' => $this->fetch('lesson-items')
        ));
    }


    public function ajaxGetCourseFiles()
    {
        $courseId = I('get.course_id');

        if ($courseId <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '课程ID参数错误！'
            ));
        }

        $files = M('CourseMaterial')->where("courseId={$courseId}")->select();
        
        $this->assign('files', $files);
        $this->ajaxReturn(array(
            'success' => true,
            'content' => $this->fetch('course-files')
        ));
    }

    public function ajaxGetCourseTopic()
    {
        $courseId = I('get.course_id');

        if ($courseId <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '课程ID参数错误！'
            ));
        }

        $topic = M('CourseTopic')->where("courseId={$courseId}")->select();
        
        $this->assign('topic', $topic);
        $this->ajaxReturn(array(
            'success' => true,
            'content' => $this->fetch('course-topic')
        ));
    }
}
<?php
/**
 *          CourseController(Admin\Controller\CourseController.class.php)
 *
 *    功　　能：文件管理控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/10 10:45
 *    修　　改：2018/04/10
 *
 */

namespace Admin\Controller;
use Think\Upload;
use Think\Page;

class CourseController extends BaseController {

    /**
     * 显示课程列表
     */
    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $logModel = D('CourseUserView');

        $data = $logModel->page("$page, $numPerPage")->select();

        $data = array_map(function ($value) {
            switch ($value['serializemode']) {
                case 'serialize':
                    $value['serializemode'] = '连载中';
                    break;
                case 'finished':
                    $value['serializemode'] = '已完成';
                    break;
                default :
                    $value['serializemode'] = '非连载';
                    break;
            }

            switch ($value['status']) {
                case 'published':
                    $value['status'] = '已发布';
                    break;
                case 'closed':
                    $value['status'] = '已关闭';
                    break;
                default :
                    $value['status'] = '未发布';
                    break;
            }

            return $value;
        }, $data);

        $count = $logModel->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

        $this->assign('data', $data);
        $this->assign('page', $pageHtml);

        $this->display();
    } 

    public function add()
    {
        // sleep(2);
        if (IS_POST) {
            $title = I('post.title');
            $subtitle = I('post.subtitle');
            $about = I('post.about');
            $serializeMode = I('post.serializeMode');

            if ('' == $title) {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '标题不能为空！'
                ));
            }

            // 获取课程设置数据
            $sourseSetting = M('setting')->where('name="course"')->find();
            $sourseSetting = unserialize($sourseSetting);

            $id = M('course')->add(array(
                'title' => $title,
                'subtitle' => $subtitle,
                'about' => $about,
                'serializeMode' => $serializeMode,
                'smallPicture' => '', //
                'largePicture' => '', //
                'userId' => $this->uid,
                'createdTime' => time()
            ));

            if ($id) {
                $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '创建成功！'
                ));
            }

            $this->ajaxReturn(array(
                'success' => false,
                'message' => '创建失败！'
            ));
        } else {
            $this->display();
        }

    }

    public function edit()
    {
        $courseId = I('course_id', 0);

        if (0 == $courseId) {
            $this->error('参数不完整');
        }

        $course = M('Course')->field('id,title,subtitle,about,serializeMode')->where("id={$courseId}")->find();

        if (IS_POST) {
            $title = I('post.title');
            $subtitle = I('post.subtitle');
            $about = I('post.about');
            $serializeMode = I('post.serializeMode');

            if ('' == $title) {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '标题不能为空！'
                ));
            }

            M('course')->save(array(
                'id' => $courseId,
                'title' => $title,
                'subtitle' => $subtitle,
                'about' => $about,
                'serializeMode' => $serializeMode
            ));

            $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '更新成功！'
                ));
        }

        $this->assign('course', $course);
        $this->display(); 
    }

}
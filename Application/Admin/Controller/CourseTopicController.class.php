<?php
/**
 *          CourseTopicController(Admin\Controller\CourseTopicController.class.php)
 *
 *    功　　能：课程话题管理控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/18 10:45
 *    修　　改：2018/04/18
 *
 */

namespace Admin\Controller;
use Think\Upload;
use Think\Page;

class CourseTopicController extends BaseController {

    /**
     * 显示课程话题列表
     */
    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $CourseUserModel = D('CourseTopicUserView');

        $data = $CourseUserModel->page("$page, $numPerPage")->select();

        $count = $CourseUserModel->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

        $this->assign('data', $data);
        $this->assign('page', $pageHtml);

        $this->display();
    } 

    public function elite ($value = 1)
    {
        $id = I('get.id', 0);

        if (0 == $id) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' =>'参数不完整!'
            ));
        }

        M('CourseTopic')->where("id={$id}")->setField('isElite', $value);

        $this->ajaxReturn(array(
            'success' => true,
            'message' =>'操作成功！'
        ));

    }

    public function unelite ()
    {
        $this->elite(0);

    }

    public function stick ($value = 1)
    {
        $id = I('get.id', 0);

        if (0 == $id) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' =>'参数不完整!'
            ));
        }

        M('CourseTopic')->where("id={$id}")->setField('isStick', $value);

        $this->ajaxReturn(array(
            'success' => true,
            'message' =>'操作成功！'
        ));

    }

    public function unstick ()
    {
        $this->stick(0);

    }

    public function delete ()
    {
        $this->ajaxReturn(array(
            'success' => true,
            'message' =>'操作成功！'
        ));

    }

}
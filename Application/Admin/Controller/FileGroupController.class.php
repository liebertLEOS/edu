<?php
/**
 *          FileGroupController(Admin\Controller\FileGroupController.class.php)
 *
 *    功　　能：文件组管理控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/09 11:11
 *    修　　改：2018/04/09
 *
 */

namespace Admin\Controller;
use Think\Upload;
use Think\Page;

class FileGroupController extends BaseController {

    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $fileGroupModel = D('fileGroup');

        $data = $fileGroupModel->page("$page, $numPerPage")->select();

        $count = $fileGroupModel->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

        $this->assign('data', $data);
        $this->assign('page', $pageHtml);

        $this->display();
    }


    public function add()
    {


    }


    public function delete()
    {
        $ids = I('post.check_ids');

        // 数据校验
        if (count($ids) <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '请选择至少一个元素'
            ));
        }

        $ids = implode(',', $ids);
        var_dump($ids);

        // 从数据库中删除
        $data = M('FileGroup')->where("id in({$ids})")->delete();

        if ($data) {
            $this->ajaxReturn(array(
                'success' => true,
                'message' => "成功删除{$data}个记录"
            ));
        } else {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '删除失败'
            ));
        }
    }

    public function deleteTest()
    {
        $this->ajaxReturn(array(
            'success' => true,
            'message' => '删除失败'
        ));
    }

    public function get()
    {

    }
}
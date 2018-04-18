<?php
/**
 *    CourseMaterialController(Admin\Controller\CourseMaterialController.class.php)
 *
 *    功　　能：文件管理控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/08 15:22
 *    修　　改：2018/04/08
 *
 */

namespace Admin\Controller;
use Think\Upload;
use Think\Page;

class CourseMaterialController extends BaseController {

    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $logModel = D('CourseMaterialView');

        $data = $logModel->page("$page, $numPerPage")->select();

        $data = array_map(function ($value) {
            $value['createdtime'] = date('Y-m-d H:i:s', $value['createdtime']);
            return $value;
        }, $data);

        $count = $logModel->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

        $this->assign('data', $data);
        $this->assign('page', $pageHtml);
        $this->assign('course', $course);

        $this->display();
    }

    public function listByCourseId()
    {
        $where = array();

        $courseId = I('get.course_id', 0);
        // 查看课程是否存在
        if ($courseId <= 0) {
            $this->error('参数不完整！');
        } else {
            // 获取课程信息
            $course = M('Course')->field('id, title')->where("id={$courseId}")->find();

            if ($course == false) {
                $this->error('课程不存在！');
            }

            $where['courseId'] = $courseId;
        }

        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $logModel = D('CourseMaterialView');

        $data = $logModel->where($where)->page("$page, $numPerPage")->select();

        $data = array_map(function ($value) {
            $value['createdtime'] = date('Y-m-d H:i:s', $value['createdtime']);
            return $value;
        }, $data);

        $count = $logModel->count();

        $page = new Page($count, $numPerPage, 'pagination pagination-sm no-margin');
        $pageHtml = $page->show();

        $this->assign('data', $data);
        $this->assign('page', $pageHtml);
        $this->assign('course', $course);

        $this->display('index');
    }

    public function add()
    {
        // 用户权限过滤

        $courseId = I('post.course_id', 0);
        $lessonId = I('post.lesson_id', 0);
        $description = I('post.description', '');
        $link = I('post.link', '');


        // 保存文件到上传目录下
        $file = addFile($this->uid, $_FILES['file']);

        if ($file['type'] != 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => $file['message']
            ));
        }

        $id = M('CourseMaterial')->add(array(
            'courseId'     => $courseId,
            'lessonId'     => $lessonId,
            'title'        => $file['file']['name'],
            'description'  => $description,
            'link'         => $link,
            'fileId'       => $file['file']['id']
        ));

        if ($id) {
            $this->ajaxReturn(array(
                'success' => true,
                'file' => $file['file']
            ));
        } else {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '保存数据库失败'
            ));
        }

    }

    public function getCourseMaterialList()
    {
        //
        $courseId = I('get.course_id', 0);

        if ($courseId > 0) {
            $list = M('CourseMaterial')->where("courseId={$courseId}")->limit(100)->select();

            if ($list) {
                $this->ajaxReturn(array(
                    'success' => true,
                    'list' => $list
                ));
            }
        }

        $this->ajaxReturn(array(
            'success' => false
        ));
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

        // 从数据库中删除
        // 删除数据库中的记录CourseMaterial file
        // 删除文件
        $files = D('CourseMaterialView')->where("course_material.id in({$ids})")->select();
        $fileIds = array();
        foreach ($files as $file) {
          $filename = realpath(C('UPLOAD_DIR')) . DIRECTORY_SEPARATOR . $file['uri'];
          unlink($filename);
          $fileIds[] = $file['fileid'];
        }

        $fileIds = implode(',', $fileIds);

        // 删除数据库记录
        $model = M();
        $model->startTrans();
        $num1 = M('CourseMaterial')->where("id in({$ids})")->delete();
        $num2 = empty($fileIds) ? true : M('file')->where("id in({$fileIds})")->delete();

        if ($num1 && $num2) {
            $model->commit();
            $this->ajaxReturn(array(
                'success' => true,
                'message' => "成功删除{$num1}个记录"
            ));
        } else {
            $model->rollback();
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '删除失败'
            ));
        }
    }

    public function uploadModal(){
        $courseId = I('get.course_id', 0);

        $this->assign('courseId', $courseId);
        $this->display();
    }
}
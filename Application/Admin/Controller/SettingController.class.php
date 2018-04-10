<?php
/**
 *    SettingController(Admin\Controller\SettingController.class.php)
 *
 *    功　　能：系统设置控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/06
 *    修　　改：2018/04/06 创建控制器
 *
 */

namespace Admin\Controller;
use \Think\Page;



class SettingController extends BaseController
{
    public function index()
    {
        $this->redirect('website');
    }

    public function website()
    {
        $settingModel = M('setting');
        // 判断是否有数据提交过来，保存到数据库
        if (IS_POST) {

            // 处理上传文件，返回处理信息
            if ($_FILES['sitelogo']['size'] > 0) {
                $file = addFile($this->uid, $_FILES['sitelogo']);
            }

            if ($file['type'] == 0 ) {
                $data = array(
                    'sitename' => I('post.sitename', ''),
                    'subtitle' => I('post.subtitle', ''),
                    'email'    => I('post.email', ''),
                    'sitelogo'  => $file['file']['id']
                );
                $data = serialize($data);
                $setting = $settingModel->where("name='site'")->setField('value', $data);

            } else {
//                $this->error(serialize($file));
                var_dump($file);
            }
        }

        $setting = $settingModel->where("name='site'")->find();
        $setting = unserialize($setting['value']);

        $this->assign('setting', $setting);
        $this->display();
    }


    public function user()
    {
        $this->display();
    }

    public function course()
    {
        $settingModel = M('setting');
        // 判断是否有数据提交过来，保存到数据库
        if (IS_POST) {
            // 处理上传文件，返回处理信息
//            if ($_FILES['courselogo']['size'] > 0) {
//                $file = addFile($this->uid, $_FILES['sitelogo']);
//            }
            $data = array(
                'send' => I('post.send', 1),
                'welcome' => I('post.welcome', ''),
                'teacher_manage_student'    => I('post.teacher_manage_student', 1),
                'student_download' => I('post.student_download', 1),
                'allow_anonymous_preview' => I('post.allow_anonymous_preview', 1),
            );
            $data = serialize($data);
            $setting = $settingModel->where("name='course'")->setField('value', $data);

        }

        $setting = $settingModel->where("name='course'")->find();
        $setting = unserialize($setting['value']);

        $this->assign('setting', $setting);

        $this->display();
    }

    /**
     * log
     * 查看日志
     * 2018.04.06
     *
     */
    public function log()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $logModel = M('log');

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

        $this->display();
    }
}
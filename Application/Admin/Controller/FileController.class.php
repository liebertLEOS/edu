<?php
/**
 *          FileController(Admin\Controller\FileController.class.php)
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

class FileController extends BaseController {

    public function index()
    {
        $page = I('get.p', 1);
        $numPerPage = 10;

        if ($page < 1 ) {
            $page = 1;
        }

        $logModel = D('FileInfoView');

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


    public function addMultiFile()
    {
        // 用户权限过滤


        // 保存文件到上传目录下
        $upload = new Upload(array(
//            'mimes'         =>  array(), //允许上传的文件MiMe类型
            'maxSize'       =>  C('UPLOAD_MAXSIZE_ADMIN'), //上传的文件大小限制 (0-不做限制)
            'exts'          =>  C('UPLOAD_FILE_TYPE'), //允许上传的文件后缀
//            'autoSub'       =>  true, //自动子目录保存文件
//            'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'      =>  C('UPLOAD_DIR'), //保存根路径
//            'savePath'      =>  '', //保存路径
//            'saveName'      =>  array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
//            'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
//            'replace'       =>  false, //存在同名是否覆盖
//            'hash'          =>  true, //是否生成hash编码
//            'callback'      =>  false, //检测文件是否存在回调，如果存在返回文件信息数组
//            'driver'        =>  '', // 文件上传驱动
//            'driverConfig'  =>  array(), // 上传驱动配置
        ));

        $info = $upload->upload($_FILES);

        // 上传失败
        if (!$info) {
            if (IS_AJAX) {
                $this->ajaxReturn(array(
                    'type' => 1,
                    'error' => $upload->getError()
                ));
            } else {
                return array(
                    'type' => 1,
                    'error' => $upload->getError()
                );
            }

        }

        // 写入文件相关信息到数据库
        $createdTime = time();

        $files = [];
        foreach ($info as $key => $value) {
            $files[] = array(
                'userId' => $this->uid,
                'uri'    => $value['savepath'].$value['savename'],
                'mime'   => $value['type'],
                'ext'    => $value['ext'],
                'createdTime' => $createdTime
            );
        }

        $data = M('file')->addAll($files);

        // 返回操作情况
        if ($data) {
            if (IS_AJAX) {
                $this->ajaxReturn(array(
                    'type' => 0,
                    'file'  => array(
                        'userId' => $this->uid,
                        'id'     => $data,
                        'uri'    => $info['savepath'].$info['savename'],
                        'mime'   => $info['type'],
                        'ext'    => $info['ext'],
                        'createdTime' => $createdTime
                    )
                ));
            } else {
                return array(
                    'type' => 0,
                    'file'  => array(
                        'userId' => $this->uid,
                        'key'    => $data,
                        'uri'    => $info['savepath'].$info['savename'],
                        'mime'   => $info['type'],
                        'ext'    => $info['ext'],
                        'createdTime' => $createdTime
                    )
                );
            }
        } else {
            if (IS_AJAX) {
                $this->ajaxReturn(array(
                    'type' => 2,
                    'error' => '保存数据库失败'
                ));
            } else {
                return array(
                    'error' => 2,
                    'message' => '保存数据库失败'
                );
            }

        }

    }

    public function add()
    {
        // 用户权限过滤


        // 保存文件到上传目录下
        $upload = new Upload(array(
//            'mimes'         =>  array(), //允许上传的文件MiMe类型
            'maxSize'       =>  C('UPLOAD_MAXSIZE_ADMIN'), //上传的文件大小限制 (0-不做限制)
            'exts'          =>  C('UPLOAD_FILE_TYPE'), //允许上传的文件后缀
//            'autoSub'       =>  true, //自动子目录保存文件
//            'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'      =>  C('UPLOAD_DIR'), //保存根路径
//            'savePath'      =>  '', //保存路径
//            'saveName'      =>  array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
//            'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
//            'replace'       =>  false, //存在同名是否覆盖
//            'hash'          =>  true, //是否生成hash编码
//            'callback'      =>  false, //检测文件是否存在回调，如果存在返回文件信息数组
//            'driver'        =>  '', // 文件上传驱动
//            'driverConfig'  =>  array(), // 上传驱动配置
        ));

        $info = $upload->uploadOne($_FILES['file']);

        // 上传失败
        if (!$info) {
            if (IS_AJAX) {
                $this->ajaxReturn(array(
                    'type' => 1,
                    'error' => $upload->getError()
                ));
            } else {
                return array(
                    'type' => 1,
                    'error' => $upload->getError()
                );
            }

        }

        // 写入文件相关信息到数据库
        $createdTime = time();

        $file = array(
            'userId' => $this->uid,
            'uri'    => $info['savepath'].$info['savename'],
            'mime'   => $info['type'],
            'ext'    => $info['ext'],
            'originName' => $info['name'],
            'createdTime' => $createdTime
        );

        $data = M('file')->add($file);

        // 返回操作情况
        if ($data) {
            if (IS_AJAX) {
                $this->ajaxReturn(array(
                    'type' => 0,
                    'file'  => array(
                        'userId' => $this->uid,
                        'id'     => $data,
                        'name'   => $info['name'],
                        'name'   => $info['name'],
                        'uri'    => $info['savepath'].$info['savename'],
                        'mime'   => $info['type'],
                        'ext'    => $info['ext'],
                        'createdTime' => $createdTime
                    )
                ));
            } else {
                return array(
                    'type' => 0,
                    'file'  => array(
                        'userId' => $this->uid,
                        'key'    => $data,
                        'uri'    => $info['savepath'].$info['savename'],
                        'mime'   => $info['type'],
                        'ext'    => $info['ext'],
                        'createdTime' => $createdTime
                    )
                );
            }
        } else {
            if (IS_AJAX) {
                $this->ajaxReturn(array(
                    'type' => 2,
                    'error' => '保存数据库失败'
                ));
            } else {
                return array(
                    'error' => 2,
                    'message' => '保存数据库失败'
                );
            }

        }

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

        // 删除文件
        $files = M('file')->field('uri')->where("id in({$ids})")->select();
        foreach ($files as $file) {
          $filename = realpath(C('UPLOAD_DIR')) . DIRECTORY_SEPARATOR . $file['uri'];
          unlink($filename);
        }
        // 删除数据库记录
        $data = M('file')->where("id in({$ids})")->delete();

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
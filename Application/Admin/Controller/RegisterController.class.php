<?php
/**
 *          RegisterController(Admin\Controller\RegisterController.class.php)
 *
 *    功　　能：注册控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/05
 *    修　　改：
 *
 */

namespace Admin\Controller;

class RegisterController extends BaseController {

    /**
     * 检测用户是否登录
     *
     * @return bool :true，已经登录；false，未登录
     */
    public function index()
    {
//        $returnUrl = '../login/index';
//        $isRegister = $this->checkRegister();
//
//        if($isRegister) {
//            $this->success('用户已注册', $returnUrl, 1000);
//        } else {
//            $this->assign('returnUrl', $returnUrl);
//            $this->display();
//        }
        $this->display();
    }

    /**
     * 验证用户是否存在
     */
    public function checkUserName()
    {
        $username = I('get.value', '');

        $userModel = M('user');
        $data = $userModel->field('id')->where("`nickname`='{$username}'")->find();

        if ($data) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '用户已存在'
            ));
        } else {
            $this->ajaxReturn(array(
                'success' => true
            ));
        }

    }

    /**
     * 验证邮箱是否存在
     */
    public function checkEmail()
    {
        $email = I('get.value', '');
        $email = preg_replace('/\!/', '.', $email);

        $userModel = M('user');
        $data = $userModel->field('id')->where("`email`='{$email}'")->find();

        if ($data) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '邮箱已存在'
            ));
        } else {
            $this->ajaxReturn(array(
                'success' => true
            ));
        }
    }

    /**
     * 注册用户
     */
    public function register()
    {
        return ;
        // 获取表单数据
        $username = I('post.username', '');
        $password = I('post.password', '');
        $email = I('post.email', '');
        $returnUrl = I('post.returnUrl', '');


        // 表单数据合法性校验
        if ( empty($username) || empty($password) || empty($email) ) {
            $this->error('数据不能为空');
        }

        if (strlen($username) > 20) {
            $this->error('用户名长度不能超过20');
        }

        if (strlen($password) > 20 || strlen($password) < 5) {
            $this->error('请确保密码长度在5至20之间');
        }

        // 密码处理
        $salt = md5(time());
        $password = md5($username.$password.$salt);

        // 存储到数据库中
        $userModel = M('user');

        $id = $userModel->add(array(
            'nickname' => $username,
            'password' => $password,
            'salt' => $salt,
            'email' => $email,
            'createdIp' => get_client_ip(),
            'createdTime' => time()
        ));

        if ($id) {
            // 记录日志
            saveLog($id, 'register', 'register', "{$username}成功注册");

            $this->success('注册成功，正在跳转至登录...！', U('Admin/Login/index'), 3);
        } else {
            $this->error('注册失败！');
        }

    }

}
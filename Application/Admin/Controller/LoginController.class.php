<?php
/**
 *          LoginController(Admin\Controller\BaseController.class.php)
 *
 *    功　　能：后台首页登录控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/04
 *    修　　改：2018/04/04 增加了ajaxReturn，处理客户端的异步请求
 *
 */

namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {

    /**
     * 检测用户是否登录
     *
     * @return bool :true，已经登录；false，未登录
     */
    public function index()
    {
        $returnUrl = U('Admin/Index/index');

        $uid = $this->checkLogin();

        if($uid) {
            $this->success('用户已登录', U('Admin/Index/index'), 3);
        } else {
            $this->assign('returnUrl', $returnUrl);
            $this->display();
        }
    }

    public function login()
    {
        $username = I('post.username', '');
        $password = I('post.password', '');
        $remember_me = I('post.remember_me', '');
        $returnUrl = I('post.return_url', '');

        // 校验参数
        if (empty($username) || empty($password)) {
            $this->error('用户名或密码不能为空');
        }

        // 用户是否存在
        $userModel = M('user');
        $user =  $userModel->field('id, nickname, password, salt, locked')->where("`nickname`='$username'")->find();

        // 用户不存在
        if (!$user) {
            $this->ajaxReturn(array(
                'status' => false,
                'msg' => '用户不存在'
            ));
        }

        // 用户是否被禁用
        if ($user['locked'] > 0) {
            $this->ajaxReturn(array(
                'status' => false,
                'msg' => '用户被禁用'
            ));
        }

        // 用户名和密码是否一致
        $password = md5($user['nickname'].$password.$user['salt']);
        if ($password != $user['password']) {
            $this->ajaxReturn(array(
                'status' => false,
                'msg' => '密码错误'
            ));
        }

        // 写入会话
        session('uid', $user['id']);

        cookie('uid', $user['id'], 3600*24*7);
        cookie('nickname', $user['nickname'], 3600*24*7);

        // 是否记住登录
        if ($remember_me) {
            $remember_me = md5($password.time());
            cookie('remember_me', $remember_me, 3600*24*7);
            $userModel->where("id={$user['id']}")->setField('loginSessionId', $remember_me);
        }

        // 记录日志
        saveLog($user['id'], 'login', 'login', "用户{$username}在".date('Y-m-d H:i:s')."登录系统");

        $this->ajaxReturn(array(
            'status' => true,
            'return_url' => $returnUrl
        ));

    }

    public function logout()
    {
        session('uid', null);
        cookie('uid', null);

        $this->redirect('Admin/Login/index');
    }

    /**
     * 检测用户是否登录
     *
     * @return bool :true，已经登录；false，未登录
     */
    private function checkLogin()
    {
        // 获取服务器端的uid
        $uid = $_SESSION['uid'];

        if ($uid == null) {
            return false;
        }

        // 获取客户端的userid
        $userid = cookie('uid');
        if ($userid == $uid) {
            return $uid;
        } else {
            return false;
        }
    }
}

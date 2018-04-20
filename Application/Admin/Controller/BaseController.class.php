<?php
/**
 *    BaseController(Admin\Controller\BaseController.class.php)
 *
 *    功　　能：后台首页基类控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/04
 *    修　　改：2018/04/04 增加了ajaxReturn，处理客户端的异步请求
 *              2018/04/20 增加了ajax请求的未登录拦截处理
 *                         系统自动更新会话错误修复
 *
 */
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {

    public  $uid = 0;

    public function __construct()
    {
        $uid = $this->checkLogin();

        if($uid) {
            $this->uid = $uid;
        } else {
            if (IS_AJAX) {
                header('HTTP/1.1 404');
                $this->error('unlogin');
            } else {
                $this->redirect('Admin/Login/index');
            }
            
        }

        parent::__construct();
    }

    /**
     * 检测用户是否登录
     *
     * @return bool :true，已经登录；false，未登录
     */
    public function checkLogin()
    {
        // 获取服务器端的uid
        $uid = $_SESSION['uid'];

        if ($uid) {
            return $uid;
        }


        // 1 用户是否选择了记住登录
        // 1.1 如果用户没有选择记住登录，跳转到登录界面
        // 1.2 如果用户选择了记住登录，就要查询数据库，看客户端cookie中的token是否和数据库中的一致
        // 获取客户端的rememberme
        $rememberMe = cookie('remember_me');
        if (!$rememberMe) {
            return false;
        }



        // 1 去数据库中查询会话token
        // 1.1 如果数据库中存在
        // 1.1.1 获取用户信息，更新会话token，重写入服务器session，更新客户端的cookie
        // 1.1.2 将更新后的cookie写入数据库
        // 1.2 不存在，返回false

        // 去数据库中查询会话token
        $userid = cookie('uid');
        $userModel = M('user');

        $user = $userModel->field('id, password')->where("id='{$userid}' AND loginSessionId='{$rememberMe}'")->find();

        if ($user) {
            // 更新会话token
            $remember_me = md5($user->password.time());
            // 写入会话
            session('uid', $user['id']);
            session('uname', $user['nickname']);
            session('uavatar', $user['avatar']);
            session('uroles', $user['roles']);

            // 更新客户端的cookie
            cookie('remember_me', $remember_me, 3600*24*7);

            // 将更新后的remember_me
            $userModel->where("id={$user['id']}")->setField('loginSessionId', $remember_me);
        } else {
            return false;
        }

    }


}
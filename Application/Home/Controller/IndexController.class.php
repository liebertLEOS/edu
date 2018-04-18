<?php
/**
 *    IndexController(Home\Controller\BaseController.class.php)
 *
 *    功　　能：前台首页控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/18 16:19
 *    修　　改：2018/04/18
 *
 */
namespace Home\Controller;
use Think\Controller;

class IndexController extends BaseController {

    public function index()
    {
    	$this->display();
    }
}
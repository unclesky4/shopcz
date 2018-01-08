<?php

/**
 * 后台基础控制器
 * User: Levi
 * Date: 2017/2/8
 * Time: 10:41
 */
class BaseController extends Controller
{

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->checkLogin();
    }

    /**
     * 验证用户登陆
     */
    private function checkLogin()
    {
        //使用session来判断
        if(!isset($_SESSION['admin'])){
            $this->jump("index.php?p=admin&c=login&a=login","请先登录");
        }
    }
}
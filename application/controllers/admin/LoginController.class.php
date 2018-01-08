<?php

/**
 * 登录控制器
 * User: Levi
 * Date: 2017/2/8
 * Time: 10:50
 */
class LoginController extends Controller
{
    //显示登录页面
    public function loginAction()
    {
        //载入视图
        include CUR_VIEW_PATH . "login.html";
    }

    //验证用户登陆
    public function signinAction()
    {
        //收集用户名和密码
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        //转义防止sql注入攻击
//        $username=addslashes($username);
//        $password=addslashes($password);
        //引入辅助函数
        $this->helper('input');
        $username=deepslashes($username);
        $password=deepslashes($password);
        //验证码
        $captcha = trim($_POST['captcha']);
        //验证信息
        if ($username === '') {
            $this->jump("index.php?p=admin&c=login&a=login", '用户名不能为空');
        }
        if ($password === '') {
            $this->jump("index.php?p=admin&c=login&a=login", '密码不能为空');
        }
        if ($_SESSION['captcha'] != strtolower($captcha)) {
            $this->jump("index.php?p=admin&c=login&a=login", '验证码不正确');
        }
        //调用模型 完成用户的检查 并给出提示
        $adminModel = new AdminModel('admin');
        $user = $adminModel->checkUser($username, $password);
        if (!empty($user)) {
            //登录成功，先保存登录的标识符
            $_SESSION['admin'] = $user;
            $this->jump('index.php?p=admin&c=index&a=index', '', 0);
        } else {
            $this->jump("index.php?p=admin&c=login&a=login", '用户名或密码错误');
        }
    }

    //退出
    public function logoutAction()
    {
        unset($_SESSION['admin']);
        session_destroy();
        $this->jump("index.php?p=admin&c=login&a=login", '', 0);
    }

    //生成验证码
    public function captchaAction()
    {
        //载入验证码
        $this->library('Captcha');
        //实例化对象
        $captcha = new Captcha();
        //调用方法生成验证码
        $captcha->generateCode();
        //将验证码保存到session中
        $_SESSION['captcha'] = $captcha->getCode();
    }
}
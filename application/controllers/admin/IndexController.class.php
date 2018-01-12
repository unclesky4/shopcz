<?php 

	ini_set('display_errors',1);            //错误信息
	/**
	* 后台首页控制器
	*/
	class IndexController extends Controller{

		//test
		public function testAction() {
			$data = "huangzhibiao";
			//include CUR_VIEW_PATH . "test.html";
			include CUR_VIEW_PATH . "test.php";
		}
		
		public function indexAction() {
			//echo "admin...index";
			include CUR_VIEW_PATH . "index.html";
		}

		public function topAction() {
			include CUR_VIEW_PATH . "top.html";
		}

		public function menuAction() {
			include CUR_VIEW_PATH . "menu.html";
		}

		public function dragAction() {
			include CUR_VIEW_PATH . "drag.html";
		}

		public function mainAction() {
			//include CUR_VIEW_PATH . "main.html";
			
			//辅助函数的加载
			$this->helper("input");
			test();

			//实例化admin模型
        	/*$adminModel = new AdminModel('admin'); //不带前缀的表名
			$admins = $adminModel->getAdmins();
	        echo "<pre>";
	        var_dump($admins);
	        var_dump($_SESSION['admin']);
	        include CUR_VIEW_PATH . "main.html";*/
		}

		//生成验证码
	    public function codeAction(){
	        //引入验证码类
	        $this->library('Captcha');
	        //实例化对象
	        $captcha = new Captcha();
	        //调用方法生成验证码
	        $captcha->generateCode();
	    }
		
	}

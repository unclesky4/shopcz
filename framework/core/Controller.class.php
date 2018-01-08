<?php 
	 //基础控制器
	 class Controller {
	 	
	 	/**
	 	 * 定义跳转方法
	 	 * @param  string $url     跳转的地址
	 	 * @param  string $message 要提示的信息
	 	 * @param  int $wait    多少秒实现跳转
	 	 */
	 	public function jump($url, $message, $wait) {
	 		if($wait == 0) {
	 			header("Location:$url");
	 		} else {
	 			include CUR_VIEW_PATH . "message.html";
	 		}
	 		//强制退出
	 		exit();
	 	}


	 	/**
	 	 * 定义载入辅助函数方法
	 	 * @param  string $helper [description]
	 	 */
	 	public function helper($helper) {
	 		require HELPER_PATH . "{$helper}_helper.php";
	 	}

	 	/**
	 	 * 定义载入类库方法
	 	 * @param  string $lib [description]
	 	 */
	 	public function library($lib) {
	 		require LIB_PATH . "{$lib}.class.php";
	 	}
	 }
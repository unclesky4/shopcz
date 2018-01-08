<?php 
	/**
	* 核心加载类
	*/
	class Framework
	{
		/**
		 * 让项目启动起来
		 */
		public static function run() {
			//echo "running.";
			self::init();
			self::autoload();
			self::router();
		}
		
		/**
		 * 初始化方法
		 */
		public static function init() {
			//定义路径,常量
			define("DS", DIRECTORY_SEPARATOR);
			define("ROOT", getcwd().DS);
			define("APP_PATH", ROOT."application".DS);
			define("FRAMEWORK_PATH", ROOT."framework".DS);
			define("PUBLIC_PATH", ROOT."public".DS);

			define("MODEL_PATH", APP_PATH."models".DS);
			define("VIEW_PATH", APP_PATH."views".DS);
			define("CONTROLLER_PATH", APP_PATH."controllers".DS);
			define("CONFIG_PATH", APP_PATH."config".DS);

			define('CORE_PATH', FRAMEWORK_PATH."core".DS);
			define('DB_PATH', FRAMEWORK_PATH."database".DS);
			define('HELPER_PATH', FRAMEWORK_PATH."helpers".DS);
			define('LIB_PATH', FRAMEWORK_PATH."libraries".DS);
			
			//前后台控制器和视图目录的定义 - 解析url中的参数，确定具体的路径
			//index.php?p=admib&c=goods&a=add
			define('PLATFROM', isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');
			define('CONTROLLER', isset($_REQUEST['c']) ? ucfirst($_REQUEST['c']) : 'Index');
			define('ACTION', isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');

			//当前的控制器路径
			define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFROM . DS);
			//当前视图路径
			define("CUR_VIEW_PATH", VIEW_PATH . PLATFROM . DS);


			//手动载入核心类
			require CORE_PATH . "Controller.class.php";
			include CORE_PATH . "Model.class.php";
        	include DB_PATH . "Mysql.class.php";

        	//载入配置文件
	        $GLOBALS['config'] = include CONFIG_PATH . "config.php";

	        //开启session
	        session_start();
		}

		/**
		 * 路由方法
		 */
		public function router() {
			//确定控制器类名和方法
			$controller_name = CONTROLLER . "Controller";
			$action_name = ACTION . "Action";
			//实例化控制器，然后调用相应的方法
			$controller = new $controller_name;
			$controller->$action_name();
		}

		/**
		 * 注册加载方法
		 */
		public static function autoload() {
			//注册给定的函数作为 __autoload 的实现
			//将函数注册到SPL __autoload函数队列中。如果该队列中的函数尚未激活，则激活它们。 
			spl_autoload_register(array(__CLASS__,'load'));
		}

		/**
		 * 自动加载方法 - 只加载application下的controller类和model类
		 */
		public static function load($classname) {
			if (substr($classname, -10) == "Controller") {
				require CUR_CONTROLLER_PATH . "{$classname}.class.php";
			} elseif (substr($classname, -5) == "Model") {
				require MODEL_PATH . "{$classname}.class.php";
			} else {
				//暂无其他情况
			}
		}
	}
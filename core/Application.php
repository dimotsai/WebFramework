<?php 
class Application
{
	private static $_app;
	private $_router;
	private $_mysql;
	private $_error_handler;
	private $_configuration;
	private $_url_manager;
	
	public function __construct()
	{
		Application::$_app = $this;
		$this->loadComponents();
		$this->initialSystemHandlers();
	}
	
	public static function app()
	{
		return Application::$_app;
	}
	
	public function run()
	{
		$this->_url_manager->prepoccess();
		$this->_router->route();
		$controller_name = $this->_router->getController();
		$controller = new $controller_name();
		$controller->setRouter($this->_router);
		$controller->run();
		$this->_router = null;
		$this->_mysql = null;
	}
	
	public static function loadClass($class)
	{
		$files = array(
			$class . '.php',
			str_replace('.', '/', $class) . '.php',
		);
		foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $base_path)
		{
			foreach ($files as $file)
			{
				$path = "$base_path/$file";
				if (file_exists($path) && is_readable($path))
				{
					include_once $path;
					return true;
				}
			}
		}
		return false;
	}
	
	protected function loadComponents()
	{
		$this->_configuration = new Configuration();
		$this->_url_manager = new UrlManager();
		$this->_router = new Router();
		$this->_mysql = new MySQL();
		$this->_error_handler = new ErrorHandler();
	}
	
	public function getDb()
	{
		return $this->_mysql;
	}
	
	public function redirect($url)
	{
		header("Location: index.php?r=$url");
	}
	
	public function configuration()
	{
		return $this->_configuration;
	}
	
	public function createUrl($r, $get = array())
	{
		return $this->_url_manager->createUrl($r, $get);
	}
	
	public function getBaseUrl()
	{
		return $this->_url_manager->getBaseUrl();
	}
	
	public function getCurrentController(){
		return $this->_router->getControllerName();
	}

	public function  getCurrentAction(){
		return $this->_router->getAction();
	}

	public function getErrorHandler(){
		return $this->_error_handler;
	}

	protected function initialSystemHandlers()
	{
		set_error_handler(array($this->_error_handler,'handleError'));
		set_exception_handler(array($this->_error_handler,'handleException'));
	}
	

}
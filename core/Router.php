<?php 
class Router
{
	protected $controller = 'site';
	protected $action = 'index';
	protected $default_controller;
	protected $error_controller;

	public function __construct()
	{
		$c = Application::app()->configuration();
		$this->default_controller = $c->getConfig('default_controller')?:'site';
		$this->error_controller = $c->getConfig('error_controller')?:'error';
	}
	
	public function route()
	{
		$route = isset($_GET['r'])?strtolower($_GET['r']):'site/index';
		$tokens = explode('/', $route);
		$this->controller = isset($tokens[0])&&!empty($tokens[0])?$tokens[0]:$this->default_controller;
		$this->action = isset($tokens[1])&&!empty($tokens[1])?$tokens[1]:'';

		//檢查CLASS或METHOD是否存在，不存在就導向404PAGE
		$controller = ucfirst($this->controller) . 'Controller';
		if(class_exists($controller))
		{
			Application::loadClass($controller);
			if($this->action !== '' && !method_exists ($controller, $this->action))
			{
				$this->controller = $this->error_controller;
				$this->action = '';
			}
		}
		else
		{
			$this->controller = $this->error_controller;
			$this->action = '';
		}
	}
	
	public function getController()
	{
		$controller = ucfirst($this->controller) . 'Controller';
		return $controller;
	}
	
	public function getControllerName(){
		return strtolower($this->controller);
	}

	public function getAction()
	{
		return $this->action;
	}
	
	
}
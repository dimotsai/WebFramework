<?php 
class Router
{
	protected $controller = 'site';
	protected $action = 'index';
	
	public function __construct()
	{
		
	}
	
	public function route()
	{
		$route = isset($_GET['r'])?strtolower($_GET['r']):'site/index';
		$patterns = explode('/', $route);
		$this->controller = isset($patterns[0])&&!empty($patterns[0])?$patterns[0]:'site';
		$this->action = isset($patterns[1])&&!empty($patterns[1])?$patterns[1]:'index';
	}
	
	public function getController()
	{
		$controller = ucfirst($this->controller) . 'Controller';
		$result = Application::loadClass($controller);
		if(!$result) $controller = 'SiteController';
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
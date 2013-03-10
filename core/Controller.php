<?php 
abstract class Controller
{
	//動作名稱
	protected $action = null;
	//抽象
	protected abstract function index();
	
	public function setRouter(Router $router)
	{
		if (method_exists($this, ($action = $router->getAction())))
			$this->action = $action;
		else
			$this->action = 'index';
	}
	
	public final function run()
	{
		$this->{$this->action}();
	}
	
	protected function redirectTo($url)
	{
		header('Location: ' . $url);
	}
}
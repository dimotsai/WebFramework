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
			$this->action = $this->action?:$this->getDefaultAction();
	}
	
	public final function run()
	{
		$this->{$this->action}();
	}
	
	protected function redirectTo($url)
	{
		header('Location: ' . $url);
		exit();
	}

	public function getCurrentAction(){
		return $this->action;
	}

	public function getDefaultAction(){
		if(!$this->action) $this->action = 'index';
		return $this->action;
	}
}
<?php
class UrlManager
{
	private $path_rules;
	private $is_seo;
	private $show_script_name;
	private $suffix = '';
	public function __construct()
	{
		$c = Application::app()->configuration();
		$this->path_rules = $c->getConfig('path_rules');
		$this->is_seo = $c->getConfig('is_seo');
		$this->show_script_name = $c->getConfig('show_script_name');
		$this->suffix = $c->getConfig('url_suffix');
	}

	public function prepoccess()
	{
		// $route = $router->getController() . '/' . $router->getAction();
		if($this->is_seo)
			$this->parsePathInfo();
	}
	
	//parse path info and save them to $_GET and $_REQUEST
	public function parsePathInfo()
	{
		if(!isset($_SERVER['PATH_INFO'])) return;
		$path_info = $_SERVER['PATH_INFO'];
		$params = preg_split('#/#',substr($path_info, 1));
		//r=c/a
		$params[0] = isset($params[0])?$params[0]:'';
		$params[1] = isset($params[1])?$params[1]:'';
		$route =  $params[0] .'/'. $params[1];
		unset($params[0]);
		unset($params[1]);
		$params = array_values($params);
		$_REQUEST['r'] = $_GET['r'] = $route;
		if(!isset($this->path_rules[$route])) return;
		$rules = $this->path_rules[$route];
		$n = count($params);
		foreach($params as $key => $param)
		{
			if($param == '') continue;
			if(!isset($rules[$key])) break;
			$name = $rules[$key];
			
			$_REQUEST[$name] = $_GET[$name] = $param;
		}
		// print_r($_GET);
		// print_r($rules);
		
	}
	
	public function createUrl($r, $get = array())
	{
		$url = $this->show_script_name?$_SERVER['SCRIPT_NAME']:dirname($_SERVER['SCRIPT_NAME']);
		$route = $r;
		$rules = isset($this->path_rules[$route])?$this->path_rules[$route]:array();
		// print_r($rules);
		if($this->is_seo)
		{
			$url = $this->show_script_name?$_SERVER['SCRIPT_NAME']:dirname($_SERVER['SCRIPT_NAME']);
			$url .= '/' . $r;
			$g = array_keys($get);
			$normal_query = array_diff($g, $rules);
			$path_query = array_diff($g, $normal_query);
			foreach($path_query as $key)
			{
				$url .= '/' . $get[$key];
			}
			$normal_query = array_map(function($key) use ($get){
				return $key . '=' . $get[$key];
			}, $normal_query);
			
			if(!empty($normal_query))
				$url .= '?' . implode('&', $normal_query);
		}
		else
		{
			$url .= '?r=' . $r;
			foreach($get as $name => $value)
			{
				$url .= '&' . $name . '=' . $value;
			}
		}
		return $url;
	}
	
	public function getBaseUrl()
	{
		return dirname($_SERVER['SCRIPT_NAME']);
	}
}

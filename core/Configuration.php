<?php
class Configuration
{
	private $_configs;
	public function __construct()
	{
		global $configs;
		$this->_configs = $configs;
	}
	public function getConfig($name)
	{
		if(isset($this->_configs[$name]))
			return $this->_configs[$name];
		else
			return null;
	}
}
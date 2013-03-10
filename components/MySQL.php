<?php
class MySQL
{
	protected $_database_source;
	protected $_server;
	protected $_username;
	protected $_password;
	
	public function __construct()
	{
		if(defined('MYSQL_SERVER') && defined('MYSQL_USERNAME') && defined('MYSQL_PASSWORD')){
			$this->_server = MYSQL_SERVER;
			$this->_username = MYSQL_USERNAME;
			$this->_password = MYSQL_PASSWORD;
			$this->connect();
		}
	}
	
	public function __destruct()
	{
		$this->disconnect();
	}
	
	protected function connect()
	{
		$this->_database_source = new PDO($this->_server, $this->_username, $this->_password);
        $this->_database_source->query('SET NAMES UTF8;');
	}
	
	protected function disconnect()
	{
		$this->_database_source = null;
	}
	
	public function prepare($statement, $driver_options = array() )
	{
		return $this->_database_source->prepare($statement, $driver_options);
	}
	
	public function errorInfo()
	{
		return $this->_database_source->errorInfo();
	}
}
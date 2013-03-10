<?php
abstract class View
{
	// protected $vars = array();
	
	// public function setVar($tpl_vars)
	// {
		// if(is_array($tpl_vars))
		// {
			// foreach($tpl_vars as $key => $val)
			// {
				// if($key != '')
				// {
					// $this->vars[$key] = $val;
				// }
			// }
		// }
	// }
	
	// public function __get($name)
	// {
		// return isset($this->vars[$name]) ? $this->vars[$name] : NULL;
	// }
	
    // 抽象：擷取結果
    public abstract function fetch();
    // 抽象：輸出結果
    public abstract function render();
}


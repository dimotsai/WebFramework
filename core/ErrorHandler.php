<?php
class ErrorHandler
{
	protected $errors = array();
	protected $backtrace;
	protected $is_error = false;
	protected $custom_display = true;
	public function handleError($errno, $errstr, $errfile, $errline)
	{
		$this->is_error = true;
		if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}
		$size = count($this->errors);
		$backtrace = debug_backtrace();
		
		switch ($errno) {
		case E_USER_ERROR:
			$this->errors[$size] =  "<h4><b>ERROR</b> [$errno] $errstr<br />"
			. "  Fatal error on line $errline in file $errfile"
			. ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />"
			. "Aborting...</h4>";
			break;
		case E_USER_WARNING:
			$this->errors[$size] = "<h4><b>USER WARNING</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;

		case E_USER_NOTICE:
			$this->errors[$size] = "<h4><b>USER NOTICE</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;
		case E_WARNING:
			$this->errors[$size] = "<h4><b>WARNING</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;
		case E_NOTICE:
			$this->errors[$size] = "<h4><b>NOTICE</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;
		default:
			$this->errors[$size] = "<h4>Unknown error type: [$errno] $errstr at $errfile on $errline</h4>";
			break;
		}
		$this->errors[$size] .=  "<ul>";
		foreach($backtrace as $key => $item)
		{
			$args = isset($item['args'])?$item['args']:array();
			$args = array_map(function($i){
				if(is_array($i))
					return 'Array ()';
				else if(is_object($i))
					return get_class($i);
				else
					return $i;
			}, $args);
			$args = implode(',', $args );
			$this->errors[$size] .= "<li>#$key <b>{$item['class']}::{$item['function']}({$args})</b> called at <b>{$item['file']}</b> on <b>{$item['line']}</b> </li>";
		}
		$this->errors[$size] .= "</ul>";
		
		// $this->render();
		
		/* Don't execute PHP internal error handler */
		return true;
	}
	
	public function handleException($e)
	{
		$this->errors[$size] = $e->getMessage();
		// $this->render();
	}
	public function isError(){
		return $this->is_error;
	}

	public function render()
	{
		ob_start();
?>
	<style type="text/css">
		div#error-container
		{
			padding: 10px; 
			margin: 10px; 
			border: 5px solid red; 
			font-family: consolas;
		}
		div#error-container h4
		{
			padding: 5px;
			margin: 5px;
			color: #FF0600;
			font-size: 1.2em;
		}
		div#error-container b
		{
			
		}
	</style>
	<div id="error-container">
		<?php 
			echo implode('', $this->errors);
		?>
	</div>
<?php
		$result = ob_get_clean();
		if(!$this->custom_display)
			echo $result;
	
		return $result;
	}
}
?>
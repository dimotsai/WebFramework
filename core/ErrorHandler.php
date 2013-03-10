<?php
class ErrorHandler
{
	protected $error;
	protected $backtrace;
	
	public function handleError($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}
		
		$backtrace = debug_backtrace();
		
		switch ($errno) {
		case E_USER_ERROR:
			$this->error =  "<h4><b>ERROR</b> [$errno] $errstr<br />"
			. "  Fatal error on line $errline in file $errfile"
			. ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />"
			. "Aborting...</h4>";
			$this->render();
			exit(1);
			break;
		case E_USER_WARNING:
			$this->error = "<h4><b>USER WARNING</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;

		case E_USER_NOTICE:
			$this->error = "<h4><b>USER NOTICE</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;
		case E_WARNING:
			$this->error = "<h4><b>WARNING</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;
		case E_NOTICE:
			$this->error = "<h4><b>NOTICE</b> [$errno] $errstr at $errfile on $errline</h4>";
			break;
		default:
			$this->error = "<h4>Unknown error type: [$errno] $errstr at $errfile on $errline</h4>";
			break;
		}
		$this->error .=  "<ul>";
		foreach($backtrace as $key => $item)
		{
			$args = array_map(function($i){
				if(is_array($i))
					return 'Array ()';
				else if(is_object($i))
					return get_class($i);
				else
					return $i;
			}, $item['args']);
			$args = implode(',', $args );
			$this->error .= "<li>#$key <b>{$item['class']}::{$item['function']}({$args})</b> called at <b>{$item['file']}</b> on <b>{$item['line']}</b> </li>";
		}
		$this->error .= "</ul>";
		
		$this->render();
		
		/* Don't execute <p></p>HP internal error handler */
		return true;
	}
	
	public function handleException($e)
	{
		$this->error = $e->getMessage();
		$this->render();
	}
	
	public function render()
	{
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
<?php echo $this->error;?>
	</div>
<?php
	}
}
?>
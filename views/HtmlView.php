<?php
class HtmlView extends View
{
	protected $layout = null;
	public $title = APP_NAME;
	public function __construct()
	{
		$this->layout = defined('LAYOUT_NAME') ? LAYOUT_NAME:'layout';
	}
	
	public function fetch()
	{
		$args = func_get_args();
        $template_filename = $args[0];
        $data = $args[1];
        $partial = $args[2];
		
		ob_start(array($this, 'fatal_error_handler'));
		// ob_start();
		extract($data);
		include TEMPLATE_PATH . '/' . $template_filename . '.php';
		$content = ob_get_contents();
		ob_end_clean();
		
		$errh = Application::app()->getErrorHandler();
		if(!Application::app()->configuration()->getConfig('production_mode'))
			$errors = $errh->isError()?$errh->render():'';
		else
			$errors = '';

		if($this->layout != null && !$partial)
		{
			ob_start();
			include TEMPLATE_PATH . '/' . $this->layout . '.php';
			$html = ob_get_contents();
			unset($content);
			unset($errors);
			ob_end_clean();
		}
		else
		{
			$html = $content;
		}
        
        return $html;
	}

	public function render()
	{
		// 因為 View 類別的 render 函式沒有參數
        // 所以 render 要自行取得
        $args = func_get_args();
        $template_filename = $args[0];
        $data = isset($args[1])?$args[1]:array();
        $partial = isset($args[2])?$args[2]:false;
        header('Content-Type: text/html; charset=utf-8');
        echo $this->fetch($template_filename, $data, $partial);
	}
	
	public function fatal_error_handler($str)
	{
		$error = error_get_last();
		if ($error && $error["type"] == E_USER_ERROR || $error["type"] == E_ERROR)
		{
			return ini_get("error_prepend_string").
			  "\n<b>Fatal error: </b>$error[message] in $error[file] on line $error[line]\n".
			  ini_get("error_append_string");
		}
		return $str;
	}
}

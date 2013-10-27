<?php
class ErrorController extends Controller
{
	protected $view = 'index';
	public function __construct()
	{
		$this->view = new HtmlView;
		$this->view->title = APP_NAME;
	}
	
	public function index()
	{
		$this->view->render('error/missing');
	}

	public function notfound()
	{
		$this->view->render('error/missing');
	}
}

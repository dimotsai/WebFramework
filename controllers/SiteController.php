<?php
class SiteController extends Controller
{
  protected $view;
  public function __construct()
  {
      $this->view = new HtmlView;
      $this->view->title = APP_NAME;
  }

  public function index()
  {
      $this->view->render('index');
  }
}
Installation
============
1. Create folders like these:
  * assets/
  * components/
  * controllers/
  * databases/
  * files/
  * models/
  * templates/
  * theme/
  * views/

2. Copy ./config.sample.php to ./config.php and then modify it

3. Create SiteController.php into controllers/

4. Modified SiteController.php

  ``` php
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
  ```

5. enjoy

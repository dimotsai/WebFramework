<?php
require_once 'config.php';
require_once 'core/Application.php';
$include_path = array();
$include_path[] = get_include_path();

$include_path[] = APP_REAL_PATH . '/core';
$include_path[] = APP_REAL_PATH . '/components';
$include_path[] = APP_REAL_PATH . '/controllers';
$include_path[] = APP_REAL_PATH . '/models';
$include_path[] = APP_REAL_PATH . '/views';

set_include_path(join(PATH_SEPARATOR, $include_path));

function __autoload($class_name)
{
	Application::loadClass($class_name);
}

$app = new Application;
$app->run();
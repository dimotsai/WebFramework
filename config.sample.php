<?php

define( 'APP_REAL_PATH', str_replace( '\\', '/', dirname( __FILE__ ) ) );
define( 'APP_NAME', 'mysite' );

# define( 'MYSQL_SERVER', 'mysql:host=localhost;dbname=name' );
# define( 'MYSQL_USERNAME', 'username' );
# define( 'MYSQL_PASSWORD', 'password' );

define( 'TEMPLATE_PATH', './templates' );

define( 'THEME_PATH', './theme' );
define( 'IMAGE_PATH', THEME_PATH . '/images' );


$configs['path_rules'] = array(
	//ex: convert ?r=site/view&id=<id>&title=<title> to site/view/<id>/<title>
	'site/view' => array(
		'id',
		'title'
	)
);

$configs['is_seo'] = false;
$configs['show_script_name'] = true;
$configs['url_suffix'] = '';
$configs['production_mode'] = false;
$configs['default_controller'] = 'site';
$configs['error_controller'] = 'error';
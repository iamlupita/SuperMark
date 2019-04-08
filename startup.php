<?php
/*
 Copyright © Renaisoft Solutions Private Limited
*/
//we dont want direct access to startup.php
if (substr($_SERVER['SCRIPT_NAME'],-12)=='/startup.php')
{
	header("Location: index.php");
	die;
}	

define('COOKIE_USERNAME','cart_usr');
define('COOKIE_PASSWORD','cart_pwd');
define('COOKIE_LOGINID','cart_loginid');
define('COOKIE_SOCIALLOGIN','cart_sociallogin');
define('COOKIE_SOCIALLOGINEMAIL','cart_socialloginemail');
define('COOKIE_FBLOGINSUCCESS','cart_fbloginsuccess');
define('COOKIE_GPTOKEN','cart_gp_session_token');

define('COOKIE_ADMIN_USERNAME','cart_admin_user');
define('COOKIE_ADMIN_PASSWORD','cart_admin_pwd');
define('COOKIE_ADMIN_LOGINID','cart_admin_loginid');


define('COOKIE_COMPARE','cart_compare');
define('COOKIE_COMPARE_CATEGORY','cart_compare_category');
define('COOKIE_CART_ITEMS','cart_items');//prod_id-count
define('COOKIE_REORDER_ITEMS','reorder_items');//prod_id-count
define('COOKIE_ZIP','cart_zip');






define('PAGINATION_SIZE',20);

date_default_timezone_set("GMT");

define('MOD_REWRITE', false);
define('USE_HTTPS', false);

if(($_SERVER['HTTP_HOST'] == "demo.xyzscripts.com") || ($_SERVER['HTTP_HOST'] == "www.demo.xyzscripts.com"))
{
	define('DEMO_MODE',TRUE);		// TRUE for demo
}
else
{
	define('DEMO_MODE',FALSE);		// FALSE for production
}

if(!defined('DB_INTERFACE'))
{
	if(function_exists('mysqli_connect'))
	define('DB_INTERFACE','mysqli');
	else 
	define('DB_INTERFACE','mysql');
}




define('PRODUCT_CODE','XYZSHCFRE');
define('PRODUCT_VERSION','V 1.0');
define('VALIDATOR_SERVER_COUNT',2);

define('DS', DIRECTORY_SEPARATOR);					// let us abbreviate
define('ROOT_DIR_PATH', dirname(__FILE__).'/');		// absolute path to root folder
define('LIB_DIR_PATH', PATH_TO_ROOT.'library/');	// path to library folder with trailing slash
define('CONFIG_DIR_PATH', PATH_TO_ROOT.'config/');	// path to config folder with trailing slash
define('COMMON_DIR_PATH', PATH_TO_ROOT.'common/');	// path to common folder with trailing slash

include(CONFIG_DIR_PATH."basic.php");

if(!defined('INSTALL_DIR'))
define('INSTALL_DIR','installation');	


define('DATA_DIR_PATH', PATH_TO_ROOT.DATA_DIR.'/');	// path to data folder with trailing slash
// Dispatching the request
include(LIB_DIR_PATH."core.php");
ob_start();
Dispatcher::dispatch();
?>
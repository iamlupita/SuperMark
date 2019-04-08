<?php
/*
 Copyright © 16-Feb-2012 F1logic. All rights reserved.
*/
error_reporting(E_ALL); // PHP error reporting level; 0 recommended for live site
define ('ER',1); // framework error reporting level; 0 recommended for live site

define('PATH_TO_ROOT', '../'); // relative path to application root folder
define('CONTROL_DIR', 'controllers'); // name of folder containing controller files
define('VIEW_DIR', 'views'); // name of folder containing view files 

// ok let us start
include PATH_TO_ROOT.'startup.php';
?>
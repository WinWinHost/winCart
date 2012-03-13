<?php

error_reporting(E_ALL|E_STRICT); // this line for debuging
ini_set('display_errors', 'on'); // this line for debuging

date_default_timezone_set('America/Los_Angeles');

// Define path to base directory
defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', BASE_PATH . '/../application');


// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(), //this line is for global php includes
)));

//require_once 'Zend/Loader/Autoloader.php';
//Zend_Loader_Autoloader::getInstance()->suppressNotFoundWarnings(false);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()->run();
<?php

use C4\Configure;
use Doctrine\Common\ClassLoader;
use C4\Container;
use C4\Container\TemplateContainer;
use C4\TemplateFactory;
use C4\ConfigFactory;
use C4\Registry;

// Hardcore defines
define('LIB_PATH', realpath(dirname(__FILE__)));
define('WWW_PATH', realpath(dirname(__FILE__) . '/../webroot'));
define('ROOT_PATH', realpath(dirname(__FILE__). '/..'));
define('VENDOR_PATH', realpath(dirname(__FILE__). '/../vendor'));
define('APP_PATH', realpath(dirname(__FILE__) . '/../app'));


defined('APP_ENV') ? : define('APP_ENV', 'production');

// Doctrine autoloader
require VENDOR_PATH . '/doctrine-common/lib/Doctrine/Common/ClassLoader.php';


$classLoader = new ClassLoader('Doctrine\\Common', VENDOR_PATH . '/doctrine-common/lib');
$classLoader->register();

$classLoader = new ClassLoader('C4', LIB_PATH);
$classLoader->register();

// Site configuration
Configure::init('yaml', APP_PATH . '/config/app.yml');
$cfg = Configure::get();
Registry::set('config', $cfg);

// Service container
//Registry::set('container', new Container($cfg));



$classLoader = new ClassLoader('Monolog', VENDOR_PATH . '/monolog/src');
$classLoader->register();


if (file_exists(APP_PATH . '/bootstrap.php')) {
	require_once APP_PATH . '/bootstrap.php';
}

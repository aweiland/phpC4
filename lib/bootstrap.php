<?php

use C4\Configure;
use Doctrine\Common\ClassLoader;
use C4\Container;
use C4\Container\TemplateContainer;
use C4\TemplateFactory;
use C4\ConfigFactory;
use C4\Registry;


define('LIB_PATH', realpath(dirname(__FILE__)));
define('WWW_PATH', realpath(dirname(__FILE__) . '/../webroot'));
define('ROOT_PATH', realpath(dirname(__FILE__). '/..'));
define('VENDOR_PATH', realpath(dirname(__FILE__). '/../vendor'));


defined('APP_ENV') ? : define('APP_ENV', 'production');

require LIB_PATH . '/Doctrine/Common/ClassLoader.php';

//
$classLoader = new ClassLoader('Doctrine', LIB_PATH);
$classLoader->register();


$classLoader = new ClassLoader('C4', LIB_PATH);
$classLoader->register();

// Site configuration
Configure::init('yaml', ROOT_PATH . '/config/app.yml');
$cfg = Configure::get();
Registry::set('config', $cfg);

// Service container
//Registry::set('container', new Container($cfg));






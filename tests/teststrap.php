<?php
//require_once realpath(dirname(__FILE__) . '/../lib/bootstrap.php');

use C4\Service\Container;
use C4\Configure;
use Doctrine\Common\ClassLoader;
use C4\Container\TemplateContainer;
use C4\TemplateFactory;
use C4\ConfigFactory;
use C4\Registry;

// Hardcore defines
define('LIB_PATH', realpath(dirname(__FILE__)) . '/../lib');
define('WWW_PATH', realpath(dirname(__FILE__) . '/../webroot'));
define('ROOT_PATH', realpath(dirname(__FILE__). '/..'));
define('VENDOR_PATH', realpath(dirname(__FILE__). '/../vendor'));
define('APP_PATH', realpath(dirname(__FILE__) . '/../src'));
define('TMP_PATH', ROOT_PATH . '/tmp');
define('TEST_PATH', realpath(dirname(__FILE__)));

define('APP_ENV', 'test');

// Doctrine autoloader
require VENDOR_PATH . '/doctrine-common/lib/Doctrine/Common/ClassLoader.php';


$classLoader = new ClassLoader('Doctrine\\Common', VENDOR_PATH . '/doctrine-common/lib');
$classLoader->register();

$classLoader = new ClassLoader('C4', LIB_PATH);
$classLoader->register();


$classLoader = new ClassLoader('Doctrine\\DBAL', VENDOR_PATH . '/doctrine-dbal/lib');
$classLoader->register();

$classLoader = new ClassLoader('Doctrine\\ODM\\MongoDB', VENDOR_PATH . '/doctrine-mongodb-odm/lib');
$classLoader->register();

$classLoader = new ClassLoader('Doctrine\\MongoDB', VENDOR_PATH . '/doctrine-mongodb/lib');
$classLoader->register();

$classLoader = new ClassLoader('Doctrine', VENDOR_PATH . '/doctrine/lib');
$classLoader->register();

$classLoader = new ClassLoader('App', APP_PATH);
$classLoader->register();

$classLoader = new ClassLoader('TestDocuments', ROOT_PATH . '/tests');
$classLoader->register();

$classLoader = new ClassLoader('TestEntities', ROOT_PATH . '/tests');
$classLoader->register();


$classLoader = new ClassLoader('Monolog', VENDOR_PATH . '/monolog/src');
$classLoader->register();

// hack for code coverage
require_once VENDOR_PATH . '/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_String();
$twig = new  Twig_Environment($loader);



// App bootstrap
//if (file_exists(APP_PATH . '/bootstrap.php')) {
//	require_once APP_PATH . '/bootstrap.php';
//}


<?php
/*
 * App specific bootstrap
 */
use Doctrine\Common\ClassLoader;


$classLoader = new ClassLoader('Doctrine\\DBAL', VENDOR_PATH . '/doctrine-dbal/lib');
$classLoader->register();

$classLoader = new ClassLoader('Doctrine\\ODM\\MongoDB', VENDOR_PATH . '/doctrine-mongodb-odm/lib');
$classLoader->register();

$classLoader = new ClassLoader('Doctrine\\MongoDB', VENDOR_PATH . '/doctrine-mongodb/lib');
$classLoader->register();

$classLoader = new $classLoader('Doctrine', VENDOR_PATH . '/doctrine/lib');
$classLoader->register();

$classLoader = new ClassLoader('App', APP_PATH);
$classLoader->register();
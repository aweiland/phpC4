<?php
use C4\Controller\FrontController;
use C4\Configure;
use Game\Container;
use Game\Registry;

chdir('..');
//include('includes/site.php');

require 'lib/bootstrap.php';

//if ($site->userinfo->userid) {
  //	header("Location: city.php");
//}


/* @var $c Container  */
//$c = Registry::get('container');
//$tmpl = $c->getTemplate();
//$tmpl->render('index/frontpage.html');
//$site->render('tw:index/frontpage');


//$tz = TWDateTimeZone::getTimeZones();
//print_r($tz);

//Configure::read('smarty.resources.tw');


$front = FrontController::getInstance();
$front->dispatch();

?>
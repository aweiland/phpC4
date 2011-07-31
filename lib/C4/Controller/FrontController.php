<?php
namespace C4\Controller;

use C4\View\View;

use C4\Container;
use C4\Configure;

final class FrontController {
	
	private static $instance;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Container
	 */
	private $container;
	
	
	/**
	 * @return FrontController
	 */
	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new FrontController();
		}
		
		return self::$instance;
	}
	
	
	private function __construct()
	{
		$config = Configure::get();
		$this->container = new Container($config);
	}

	/**
	 * Dispatch an action to a controller
	 * @todo Remove "Layout"  It was an idea borrowed from zend, but both smarty and twig do inheritance, it's dumb
	 * 
	 */
	public function dispatch()
	{
		$uri = $_SERVER['REQUEST_URI'];
		
		$parts = explode('/', $uri);
		
		// Pop off the index file
		array_shift($parts);
		array_shift($parts);
		
		$controllerName = array_shift($parts);
		$actionName = array_shift($parts);
		
		$rawControllerName = (empty($controllerName)) ? 'index' : $controllerName;
		$controllerName = self::inflect($rawControllerName);
		
		$rawActionName = (empty($actionName)) ? 'index' : $actionName;
		$actionName = self::inflect($rawActionName, false);
		$fullActionName = $rawActionName . 'Action';
		
		$controllerClass = Configure::read('frontController.controllerNamespace') . '\\' . $controllerName . 'Controller';
		if (!class_exists($controllerClass)) {
			throw new InvalidControllerException(sprintf('Invalid controller [%s]', $controllerName));
		} 
		
		$controller = new $controllerClass();
		
		if (!($controller instanceof ControllerAbstract)) {
			throw new InvalidActionException(sprintf('Controller is invalid subclass [%s]', $controllerName));
		}
		
		if (!method_exists($controller, $fullActionName)) {
			throw new InvalidActionException(sprintf('Invalid action [%s] for controller [%s]', $actionName, $controllerName));
		}
		
		$view = new View();
		$view->setViewAction("$controllerName/$actionName");
		
//		$layout = Configure::read('layout.default');
//		if ($layout) {
//			$view->setLayout($layout);
//		}
		$controller->setView($view);
		
		$controller->init();
		$controller->$fullActionName();
	
		$view->display();
	}
	
	/**
	 * Inflect a string
	 * @todo Cake has this as it's own static final class.  Not sure if one function needs it's own class...
	 * @param unknown_type $string
	 * @param unknown_type $ucFirst
	 */
	public static function inflect($string, $ucFirst = true)
	{
		$parts = explode('-', $string);
		foreach ($parts as &$part) {
			$part = ucfirst($part);
		}
		
		$string = implode('', $parts);
		if (!$ucFirst) {
			$string = lcfirst($string);
		}
		
		return $string;
	}
	
	public function setContainer(Container $container)
	{
		$this->container = $container;
	}
	
	/**
	 * Get the container
	 * return C4\Container
	 */
	public function getContainer()
	{
		return $this->container;
	}
	
}
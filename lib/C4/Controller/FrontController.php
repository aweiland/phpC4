<?php
namespace C4\Controller;

use C4\Inflector;

use C4\View\View;

use C4\Configure;

final class FrontController {
	
	private static $instance;
	
	
	
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
	}

	
	public function dispatch($uri = null) {
		if (empty($uri)) {
			$uri = $_SERVER['REQUEST_URI'];	
		}
	}
	
	
	/**
	 * Dispatch an action to a controller
	 */
	public function dispatch2()
	{
		$uri = $_SERVER['REQUEST_URI'];
		
		$parts = explode('/', $uri);
		var_dump($parts);
		// Pop off the index file
		array_shift($parts);
		array_shift($parts);
		
		$controllerName = array_shift($parts);
		$actionName = array_shift($parts);
		
		$rawControllerName = (empty($controllerName)) ? 'index' : $controllerName;
		$controllerName = Inflector::inflect($rawControllerName);
		
		$rawActionName = (empty($actionName)) ? 'index' : $actionName;
		$actionName = Inflector::inflect($rawActionName, false);
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
	
	
	protected function getControllerName($uri)
	{
		$parts = explode('/', $uri);
		
		// Pop off the index file
		array_shift($parts);
		array_shift($parts);
		
		$controllerName = array_shift($parts);
		$rawControllerName = (empty($controllerName)) ? 'index' : $controllerName;
		$controllerName = Inflector::inflect($rawControllerName);

		return $controllerName;
	}
	
	protected function getActionName($uri)
	{
		$parts = explode('/', $uri);
		
		// Pop off the index file
		array_shift($parts);
		array_shift($parts);
		array_shift($parts);  // This one is the controller
		
		$actionName = array_shift($parts);
		
		$rawActionName = (empty($actionName)) ? 'index' : $actionName;
		$actionName = Inflector::inflect($rawActionName, false);
		
		return $actionName;
	}
	
	
	
}
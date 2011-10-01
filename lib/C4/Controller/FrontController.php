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
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new FrontController();
		}
		
		return self::$instance;
	}
	
	
	private function __construct() { }

	
	public function dispatch($uri = null) {
		if (empty($uri)) {
			$uri = $_SERVER['REQUEST_URI'];	
		}
		
		
		$controllerName = $this->getControllerName($uri);
		$actionName = $this->getActionName($uri);
		
		$controller = $this->getController($controllerName);
		
		if (!method_exists($controller, $actionName)) {
			throw new InvalidActionException(sprintf('Invalid action [%s] for controller [%s]', $actionName, $controllerName));
		}
		
		$view = new View();
		$view->setViewAction("$controllerName/$actionName");
		
		$controller->setView($view);
		
		$controller->init();
		$controller->$actionName();
	
		$view->display();
		
	}
	
	
	public function getController($controllerName) {
		$controllerClass = Configure::read('frontController.controllerNamespace') . '\\' . $controllerName . 'Controller';
		if (!class_exists($controllerClass)) {
			throw new InvalidControllerException(sprintf('Invalid controller [%s]', $controllerName));
		} 
		
		$controller = new $controllerClass();
		
		if (!($controller instanceof ControllerAbstract)) {
			throw new InvalidActionException(sprintf('Controller is invalid subclass [%s]', $controllerName));
		}
		
		return $controller;
	}
	
	
	
	public function getControllerName($uri)
	{
		$parts = explode('/', $uri);
		
		
		// Pop off the empty
//		array_shift($parts);
		array_shift($parts);
		
		$controllerName = array_shift($parts);
		$rawControllerName = (empty($controllerName)) ? 'index' : $controllerName;
		$controllerName = Inflector::inflect($rawControllerName);

		return $controllerName;
	}
	
	public function getActionName($uri)
	{
		$parts = explode('/', $uri);
		
		// Pop off the index file
		// Used to do that, does this not happen anymore?
//		array_shift($parts);
		array_shift($parts);
		array_shift($parts);  // This one is the action
		
		$actionName = array_shift($parts);
		
		$rawActionName = (empty($actionName)) ? 'index' : $actionName;
		$actionName = Inflector::inflect($rawActionName, false);
		
		return $actionName;
	}
	
	
	
}
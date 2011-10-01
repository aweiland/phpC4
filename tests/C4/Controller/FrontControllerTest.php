<?php
use C4\Controller\FrontController;
class FrontControllerTest extends PHPUnit_Framework_TestCase
{
	
	private $uri = '/eric/cartman';
	
	public function testInstance()
	{
		$front = FrontController::getInstance();
		self::assertTrue($front instanceof FrontController);
	}

	
	public function testDefaultController()
	{
		$front = FrontController::getInstance();
		$name = $front->getControllerName('/');
		
		self::assertEquals('Index', $name);
	}
	
	public function testDefaultAction() 
	{
		$front = FrontController::getInstance();
		$name = $front->getActionName('/');
		
		self::assertEquals('index', $name);
	}
	
	public function testControllerName()
	{
		$front = FrontController::getInstance();
		$name = $front->getControllerName($this->uri);
		
		self::assertEquals('Eric', $name);
	}
	
	public function testActionName()
	{
		$front = FrontController::getInstance();
		$name = $front->getActionName($this->uri);
		
		self::assertEquals('cartman', $name);
	}
	
}
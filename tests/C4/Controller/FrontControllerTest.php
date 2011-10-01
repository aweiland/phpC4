<?php
use C4\Controller\FrontController;
class FrontControllerTest extends PHPUnit_Framework_TestCase
{
	
	public function testInstance()
	{
		$front = FrontController::getInstance();
		self::assertTrue($front instanceof FrontController);
	}
	
}
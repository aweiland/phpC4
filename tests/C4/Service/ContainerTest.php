<?php
use C4\Service\MongoService;
use C4\Service\Container;
class ContainerTest extends PHPUnit_Framework_TestCase
{
	
	public function testConfig()
	{
		C4\Service\Container::init('yaml', ROOT_PATH . '/tests/config/mongo.yml');
	}
	
	
	/**
	 * @depends testConfig
	 */
	public function testService()
	{
		$odm = Container::get('odm');

		self::assertTrue($odm instanceof MongoService);
		
	}
	
	/**
	 * @depends testConfig
	 * @expectedException C4\Service\InvalidServiceException
	 */
	public function testInvalidService()
	{
		Container::get('bad service');
	}
	
	
	/**
	 * @depends testConfig
	 */
	public function testRegister()
	{
		Container::register('test', new stdClass());		
	}
	
	/**
	 * @depends testConfig
	 * @expectedException C4\Service\ServiceExistsException
	 */
	public function testRegisterTooMany()
	{
		Container::register('odm', new stdClass());		
	}
}
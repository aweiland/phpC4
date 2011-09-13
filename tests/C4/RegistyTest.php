<?php
use C4\Registry;
class RegistryTest extends PHPUnit_Framework_TestCase
{

	const KEY = 'key';
	const STRING = 'testing';
	
	public function testRegistry()
	{
		Registry::set(self::KEY, self::STRING);
		
		$this->assertEquals(Registry::get(self::KEY), self::STRING);
	}
	
	/**
	 * @expectedException Exception
	 * Enter description here ...
	 */
	public function testInvalidKey()
	{
		Registry::get('DNE');
	}
}
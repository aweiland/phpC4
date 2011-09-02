<?php
use C4\Inflector;
class InflectorTest extends PHPUnit_Framework_TestCase {

	const TEST = 'this-is-test';
	
	const UPPER = 'ThisIsTest';
	
	const LOWER = 'thisIsTest';
	
	const UNDO = 'ThisIsTest';
	
	public function testUpperInflect()
	{
		$string = Inflector::inflect(self::TEST);
		
		$this->assertEquals($string, self::UPPER);
	}
	
	public function testLowerInflect()
	{
		$string = Inflector::inflect(self::TEST, false);
		
		$this->assertEquals($string, self::LOWER);
	}
	
	public function testUninflect()
	{
		$string = Inflector::uninflect(self::UNDO);
		$this->assertEquals($string, self::TEST);
	}
}
<?php
use C4\Configure;
class ConfigureTest extends PHPUnit_Framework_TestCase
{
	
	private $oldConfig;
	
	const TEST_VAR = 'test.var';
	const TEST_VAL = 'testing';
	
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testBadType()
	{
		Configure::init('bad type', 'invalid');
	}
	
	/**
	 * @expectedException C4\Exception
	 * @depends testBadType
	 */
	public function testEmpty()
	{
		Configure::clear();
		Configure::read('DNE');
	}	
	
	/**
	 * @depends testEmpty
	 */
	public function testSimpleArrayConfig()
	{
		Configure::init('array', $this->getTestConfig());

		$this->assertNotNull(Configure::read('app'));
		$this->assertEquals(Configure::read('override'), 'me');
		$this->assertEquals(Configure::read('value'), 'set');
	}
	
	/**
	 * @depends testSimpleArrayConfig
	 */
	public function testSimpleReplacements()
	{
		$this->assertEquals(Configure::read('lib'), LIB_PATH, 'Lib path');
		$this->assertEquals(Configure::read('www'), WWW_PATH, 'www path');
		$this->assertEquals(Configure::read('root'), ROOT_PATH, 'root path');
		$this->assertEquals(Configure::read('tmp'), TMP_PATH, 'tmp path');
		$this->assertEquals(Configure::read('app'), APP_PATH, 'app path');
	}
	
	
	/**
	 * @depends testSimpleArrayConfig
	 */
	public function testWrite()
	{
		Configure::write(self::TEST_VAR, self::TEST_VAL);
		
//		$this->assertEquals(Configure::read(self::TEST_VAR), self::TEST_VAL);
	}
	
	
		
	protected function getTestConfig()
	{
		return array(
			'default' => array(
				'appenv' => 'APP_ENV', 
				'lib' => 'LIB_PATH', 
				'www' => 'WWW_PATH', 
				'root' => 'ROOT_PATH', 
				'tmp' => 'TMP_PATH', 
				'app' => 'APP_PATH',
				'override' => 'not me'
			), 
			'test' => array(
				'override' => 'me',
				'inherit' => 'parent'
			),
			'parent' => array(
				'value' => 'set'
			)
		);
		
	}
}
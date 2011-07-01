<?php
namespace C4\Service;

use C4\Container;

use C4\Exception;

use C4\Registry;

class ServiceAbstract
{
	protected $container;

	public function __construct($container = null)
	{
		if ($container === null) {
			$container = Registry::get('container');
			if ($container === null) {
				throw new Exception('No Service Container');
			}
		}
		
		if (!$container instanceof Container) {
			throw new Exception('Invalid Container');
		} 
		
		
		$this->container = $container;
	}
	
	public function setContainer($container)
	{
		$this->container = $container;
	}
}
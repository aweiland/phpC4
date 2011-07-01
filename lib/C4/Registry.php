<?php
namespace C4;
use Doctrine\Common\Collections\ArrayCollection;

final class Registry
{
	/**
	 * @var ArrayCollection
	 */
	private $registry;
	
	/**
	 * Registry instance
	 * @var Registry
	 */
	private static $instance;
	
	/**
	 * @return Registry
	 */
	private static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new Registry();
		}

		return self::$instance;
	}
	
	private function __construct()
	{
		$this->registry = new ArrayCollection();
	}
	
	/**
	 * Set a value in the registry
	 * Enter description here ...
	 * @param string $key
	 * @param mixed $value
	 */
	public static function set($key, $value)
	{
		self::getInstance()->registry->set($key, $value);
	}
	
	/**
	 * Get something from the registry
	 * @param string $key
	 * @return mixed
	 */
	public static function get($key)
	{
		$val = self::getInstance()->registry->get($key);
		
		if ($val === null) {
			throw new Exception("No element in registry for key '$key'");
		}
		
		return $val;
	}
}
<?php
namespace C4;

final class Configure
{
	
	private static $config;
	
	/**
	 * Init the config
	 * @todo Add caching
	 */
	public static function init($type, $file)
	{
		self::$config = ConfigFactory::create($type, $file);
	}
	
	/**
	 * Get a config value
	 * @param string $var
	 */
	public static function read($var)
	{
		
		$parts = explode('.', $var);
		
		$config = self::get();
		do {
			$var = array_shift($parts);
			if (!isset($config[$var])) return null;
			$config = $config[$var];
		} while (count($parts));
		
		return $config;
	}
	
	/**
	 * Write a value to the configuration
	 * @param string $var Key
	 * @param mixed $val Value
	 * @todo Write this
	 */
	public static function write($var, $val)
	{
		self::$config[$var] = $val;
	}
	
	/**
	 * @throws Exception
	 * @return ArrayObject
	 */
	public static function get()
	{
		if (self::$config === null) {
			throw new Exception('Configuration not initialized');
		}
		
		return self::$config;
	}

	public static function set(\ArrayObject $cfg)
	{
		self::$config = $cfg;
	}
	
	public static function clear()
	{
		self::$config = null;
	} 
}
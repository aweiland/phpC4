<?php
namespace C4\Service;

use C4\Configure;

use C4\ConfigFactory;

/**
 * Service Container
 * @todo Singleton?
 */
final class Container {

	/**
	 * Services
	 */
	private static $services = array();

	private static $serviceConfig;
	
	/**
	 * @todo Don't hard code the yaml parser, probably means a config refactor
	 */
	public static function init($type, $file)
	{
		//self::$serviceConfig = ConfigFactory::create($type, $file);
		self::$serviceConfig = yaml_parse_file($file);
		
		self::zeroPass();
		self::firstPass();
		self::secondPass();
		self::thirdPass();
	}
	
	/**
	 * Replace config place holders in config with real values
	 */
	private static function zeroPass()
	{
		foreach (self::$serviceConfig as $key => &$config) {
			foreach ($config['properties'] as $var => $value) {
				if (preg_match('/\$(.*?)\$$/', $value, $matches)) {
					$config[$var] = Configure::read($matches[1]);
				}
			}
		}
	}
	
	/**
	 * Class instantiation
	 * @throws InvalidServiceException
	 */
	private static function firstPass()
	{
		foreach (self::$serviceConfig as $key => $s) {
			$class = $s['class'];
			if (empty($class)) {
				throw new InvalidServiceException(sprintf('No class defined for service [%s]', $key));	
			}
			
			$rc = new \ReflectionClass($class);
			if (!$rc->implementsInterface('C4\Service\ServiceInterface')) {
				throw new InvalidServiceException(sprintf('Service [%s] does not implement ServiceInterface', $class));
			}

			$service = new $class();
			$service->setProperties($s['properties']);
			self::$services[$key] = $service;
		}
	}
	

	/**
	 * Class dependency resolution
	 */
	private static function secondPass() 
	{
		foreach (self::$serviceConfig as $key => $s) {
			
		}			
	}
	
	
	/**
	 * Call each service's init()
	 */
	private static function thirdPass()
	{
		foreach (self::$services as $service) {
			$service->init();
		}
	}
	
	/**
	 * Register a service with the container
	 * @param string $serviceName
	 * @param object $service
	 * @throws ServiceExistsException
	 */
	public static function register($serviceName, $service) {
		if (isset(self::$services[$serviceName])) {
			throw new ServiceExistsException(sprintf('Service already registered with container: [%s]', get_class(self::$services[$serviceName])));
		}
		
		self::$services[$serviceName] = $service;
	}
	
	public static function get($serviceName) {
		if (!isset(self::$services[$serviceName])) {
			throw new InvalidServiceException();
		}
		
		return self::$services[$serviceName];
	}
	
}
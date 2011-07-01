<?php
namespace C4;

use C4\ConfigAbstract;
use C4\Config\Yaml;

final class ConfigFactory
{
	/**
	 * Create a config object
	 * @param string $type
	 * @param string $file
	 * @return ConfigAbstract
	 * @throws \InvalidArgumentException
	 */
	public static function create($type, $file)
	{
		switch ($type) {
			case 'yaml' : $cfg = new Yaml($file);
				break;
		
			default: throw new \InvalidArgumentException('Bad config type');
		}

		return $cfg;
		
	}
	
	
	
}
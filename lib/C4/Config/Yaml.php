<?php
namespace C4\Config;

use C4\Exception;
use C4\Config\ConfigAbstract;


class Yaml extends ConfigAbstract
{

	public function __construct($file)
	{
		if (!file_exists($file)) {
			throw new \InvalidArgumentException("'$file' does not exist");
		}
		
		if (function_exists('yaml_parse_file')) {
			$data = $this->runNativeParser($file);
		}
		else {
			$data = $this->runSpycParser($file);
		}

		if ($data === null) {
			throw new SyntaxException('Invalid YAML file'); 
		}
		
		$cfg = $this->resolveInheritance($data);
		
		parent::__construct($cfg, \ArrayObject::ARRAY_AS_PROPS);
	}
	
	/**
	 * Rund the PHP extension YAML parser
	 * @param string $file
	 */
	protected function runNativeParser($file)
	{
		$data = yaml_parse_file($file);
		return $data;	
	}
	
	/**
	 * Run the Spyc parser
	 * @param string $file
	 */
	protected function runSpycParser($file)
	{
		require_once LIB_PATH . '/Spyc/spyc.php';
		$data = \Spyc::YAMLLoad($file);
	}
	
	
}
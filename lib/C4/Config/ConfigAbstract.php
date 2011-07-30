<?php
namespace C4\Config;

/**
 * Just an abstract wrapper around ArrayObject
 */
abstract class ConfigAbstract extends \ArrayObject
{
/**
	 * Resolve any config inheritance data
	 * @param array $data
	 * @throws Exception
	 */
	protected function resolveInheritance(array $data)
	{
		if (!isset($data['default'])) {
			throw new Exception('No default config section');
		}
		
		$config = $data['default'];
		
		if (defined('APP_ENV') && isset($data[APP_ENV])) {
			$cfg = $data[APP_ENV];
			
			// merge in all the inherited values
			while (!empty($cfg['inherit'])) {
				$subCfg = $data[$cfg['inherit']];
				$cfg = $this->mergeArrays($subCfg, $cfg);
				$cfg['inherit'] = (isset($subCfg['inherit'])) ? $subCfg['inherit'] : '';
			}
			
			$config = $this->mergeArrays($config, $cfg);
		}
		
		$config = $this->replaceConstants($config);
		
		return $config;
		
	}
	
	
	protected function mergeArrays($Arr1, $Arr2)
	{
  		foreach($Arr2 as $key => $Value) {
			if(array_key_exists($key, $Arr1) && is_array($Value))
      			$Arr1[$key] = $this->mergeArrays($Arr1[$key], $Arr2[$key]);
    		else
      			$Arr1[$key] = $Value;

  		}

  		return $Arr1;

	}
	
	private function replaceConstants($cfg)
	{
		$search = array('APP_ENV', 'LIB_PATH', 'WWW_PATH', 'ROOT_PATH', 'TMP_PATH', 'APP_PATH');
		$replace = array(APP_ENV, LIB_PATH, WWW_PATH, ROOT_PATH, TMP_PATH, APP_PATH);
		
		foreach ($cfg as &$val) {
			if (is_array($val)) {
				self::replaceConstants($val);
			}
			
			$val = str_replace($search, $replace, $val);
		}
		
		return $cfg;
	}
}
<?php
namespace C4;

class Inflector
{
	/**
	 * Inflect a string
	 * @param string $string String to inflect
	 * @param bool $ucFirst Whether to uppercase the first char
	 */
	public static function inflect($string, $ucFirst = true)
	{
		$parts = explode('-', $string);
		foreach ($parts as &$part) {
			$part = ucfirst($part);
		}
		
		$string = implode('', $parts);
		if (!$ucFirst) {
			$string = lcfirst($string);
		}
		
		return $string;
	}
	
	/**
	 * Remove the inflection from a string (precede caps with underscores and lower case)
	 * Enter description here ...
	 * @param unknown_type $string
	 */
	public static function uninflect($string)
	{
		return preg_replace('/([A-Z])/e', "'_' . strtolower('\\1')", $string);	
	}
}
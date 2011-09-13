<?php
namespace C4\Config;

/**
 * Config data that's just an array
 */
class ArrayData extends ConfigAbstract
{
	public function __construct(array $data) {
		parent::__construct($data);
	}
}
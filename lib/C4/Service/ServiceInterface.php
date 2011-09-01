<?php
namespace C4\Service;

interface ServiceInterface {
	
	/**
	 * Set all the properties for the service
	 * @param array $properties
	 */
	public function setProperties(array $properties);
	
	
	/**
	 * Called after properties are set to initialize the service
	 */
	public function init();
}
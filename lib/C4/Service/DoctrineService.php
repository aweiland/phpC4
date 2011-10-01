<?php
namespace C4\Service;


use Doctrine\ORM\EntityManager;

use Doctrine\ORM\Configuration;

class DoctrineService implements ServiceInterface
{
	
	/**
	 * EntityManager
	 * @var Doctrine\ORM\EntityManager
	 */
	private $em;
	
	
	private $properties;
	
	
	/* (non-PHPdoc)
	 * @see C4\Service.ServiceInterface::init()
	 */
	public function init() {
		$config = new Configuration();

		$config->setProxyDir($this->properties['proxyDir']);
		$config->setProxyNamespace($this->properties['proxyNamespace']);		
		
		$driverImpl = $config->newDefaultAnnotationDriver($this->properties['metadataDriverPath']);
		$config->setMetadataDriverImpl($driverImpl);
		
		$cache = new $this->properties['cacheClass']();
		$config->setQueryCacheImpl($cache);
		
		$config->setAutoGenerateProxyClasses($this->properties['autoGenerateProxies']);
		
		$connectionOptions = $this->properties['connectionOptions'];
		
		$this->em = EntityManager::create($connectionOptions, $config);
		
	}

	/* (non-PHPdoc)
	 * @see C4\Service.ServiceInterface::setProperties()
	 */
	public function setProperties(array $properties) {
		$this->properties = $properties;		
	}

	/**
	 * get the Entity Manager
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		return $this->em;
	}
	
	/**
	 * Shortcut for the lazy
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEm()
	{
		return $this->getEntityManager();
	}
	
}
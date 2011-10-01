<?php
namespace C4\Service;
use C4\Configure;

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;



class MongoService implements ServiceInterface
{
	
	private $properties = array();
	
	/**
	 * @var Doctrine\ODM\MongoDB\DocumentManager
	 */
	private $dm;
	
	/* (non-PHPdoc)
	 * @see C4\Service.ServiceInterface::setProperties()
	 */
	public function setProperties(array $properties) {
		$this->properties = $properties;		
	}

	public function init() {
		$config = new Configuration();
		$config->setProxyDir($this->properties['proxyDir']);
		$config->setProxyNamespace($this->properties['proxyDir']);

		$config->setHydratorDir($this->properties['hydratorDir']);
		$config->setHydratorNamespace($this->properties['hydratorNamespace']);
		
		$config->setDefaultDB($this->properties['defaultDb']);

		$reader = new AnnotationReader();
		AnnotationDriver::registerAnnotationClasses();
//		$reader->setDefaultAnnotationNamespace($this->properties['annotationNamespace']);
		$config->setMetadataDriverImpl(new AnnotationDriver($reader, $this->properties['metadataDriverPath']));

		$this->dm = DocumentManager::create(new Connection($this->properties['host']), $config);
	}
	
	
	/**
	 * Get the service DocumentManager
	 * @return Doctrine\ODM\MongoDB\DocumentManager
	 */
	public function getDocumentManager()
	{
		return $this->dm;
	}
	
}
<?php
namespace C4\Service;
use C4\Configure;

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;



class MongoService extends ServiceAbstract
{
	
	/**
	 * The DocumentManager
	 * @var DocumentManager
	 */
	static $dm;
	
	
	/**
	 * Get and/or start up the document manager
	 * @return DocumentManager
	 */
	protected static function getDm()
	{
		if (isset(self::$dm)) {
			return self::$dm;
		}
		
		$config = Configure::get();
		
		$config = new Configuration();
		$config->setProxyDir($config['doctrine']['odm']['proxyDir']);
		$config->setProxyNamespace($config['doctrine']['odm']['proxyDir']);

		$config->setHydratorDir($config['doctrine']['odm']['hydratorDir']);
		$config->setHydratorNamespace($config['doctrine']['odm']['hydratorNamespace']);

		$reader = new AnnotationReader();
		$reader->setDefaultAnnotationNamespace($config['doctrine']['odm']['annotationNamespace']);
		$config->setMetadataDriverImpl(new AnnotationDriver($reader, $config['doctrine']['odm']['metadataDriverPath']));

		$dm = DocumentManager::create(new Connection(), $config);
		
		self::$dm = $dm;
		
		return self::$dm;
	}
	
	/**
	 * Get the document manager
	 * @return DocumentManager
	 */
	protected function getDocumentManager()
	{
		return self::getDm();
	}
	
	
	/**
	 * Add a document to be persisted
	 * @param mixed $document
	 */
	public function add($document)
	{
		$this->getDocumentManager()->persist($document);
	}
	
	
	/**
	 * Save a document
	 * @param mixed $document
	 */
	public function save($document)
	{
		$this->getDocumentManager()->flush();
	}
	
}
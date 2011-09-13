<?php

use C4\Configure;
use C4\Service\MongoService;
class MongoServiceTest extends PHPUnit_Framework_TestCase
{
	
	const NAME = 'Test Guy';
	
	
	private $serviceConfig;
	
	protected function setUp()
	{
		$this->serviceConfig = array(
			'host' => 'localhost',
			'defaultDb' => 'c4test',
			'proxyDir' => ROOT_PATH . '/tests/tmp',
			'hydratorDir' => ROOT_PATH . '/tests/tmp',
			'hydratorNamespace' => 'Hydrators',
			'annotationNamespace' => 'Doctrine\ODM\MongoDB\Mapping\\',
    		'metadataDriverPath' =>  ROOT_PATH . '/tests/Documents'
		);
		
		Configure::init('yaml', TEST_PATH . '/config/test.yml');
	}
	
	
	public function testCreation()
	{
		$service = new MongoService();
		
		$this->assertTrue($service instanceof MongoService);
		
		$service->setProperties($this->serviceConfig);
		$service->init();
		
		$service->getDocumentManager()->getConnection()->connect();
		$this->assertTrue($service->getDocumentManager()->getConnection()->isConnected());
		
		return $service;
	}
	
	
	/**
	 * @depends testCreation
	 */
	public function testDocuments(MongoService $service)
	{
		$person = new TestDocuments\Person;
		$person->setName(self::NAME);
		
		$age = rand(20, 50);
		$person->setAge($age);
		
		$service->getDocumentManager()->persist($person);
		$service->getDocumentManager()->flush();
		
		$id = $person->getId();
		
		$service->getDocumentManager()->clear();
		
		$newPerson = $service->getDocumentManager()->find('TestDocuments\Person', $id);
		
	}
	
	
}
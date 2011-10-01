<?php

use C4\Service\DoctrineService;
use C4\Configure;

class DoctrineTest extends PHPUnit_Framework_TestCase
{
	
	const NAME = 'Test Guy';
	
	
	private $serviceConfig;
	
	protected function setUp()
	{
		$this->serviceConfig = array(
			'host' => 'localhost',
			'defaultDb' => 'c4test',
			'proxyDir' => ROOT_PATH . '/tests/tmp',
			'proxyNamespace' => 'TestProxies',
    		'metadataDriverPath' =>  ROOT_PATH . '/tests/TestEntities',
    		'autoGenerateProxies' => true,
			'cacheClass' => 'Doctrine\Common\Cache\ArrayCache',
			'connectionOptions' => array(
				'driver' => 'pdo_sqlite',
				'path' => ':memory:'
			)
		);
		
		Configure::init('yaml', TEST_PATH . '/config/test.yml');
		
	}
	
	public function testCreation()
	{
		$service = new DoctrineService();
		
		$this->assertTrue($service instanceof DoctrineService);
		
		$service->setProperties($this->serviceConfig);
		$service->init();
		
		$service->getEntityManager()->getConnection()->connect();
		$this->assertTrue($service->getEntityManager()->getConnection()->isConnected());
		
		return $service;
	}
	
	/**
	 * @depends testCreation
	 */
	public function testEntity(DoctrineService $service) {
		$em = $service->getEntityManager();
		
		$tool = new Doctrine\ORM\Tools\SchemaTool($em);
		$metars = $em->getMetadataFactory()->getAllMetadata();

		$tool->createSchema($metars);
		
		$p = new TestEntities\Person();
		
		$p->setName('Timmy');
		$em->persist($p);
		$em->flush();
		
	}
	
	
}
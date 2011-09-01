<?php
namespace C4;
use C4\Config\ConfigAbstract;
use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;


use C4\View\Template\Adapter\SmartyAdapter;
use C4\View\Template\Template;
use C4\Registry;

final class Container2
{
	
	protected static $shared;
	
	protected static $config;
	
	public function __construct(ConfigAbstract $config)
	{
		self::setConfig($config);
	}
	
	/**
	 * Set the Container config
	 * @param ConfigAbstract $config
	 */
	public static function setConfig(ConfigAbstract $config)
	{
		self::$config = $config;
	}
	
	
	/**
	 * Get Container config
	 * @return ConfigAbstract
	 */
	public static function getConfig()
	{
		return self::$config;
	}
	
	/**
	 * Get Doctrine document manager
	 * @return Doctrine\ODM\MongoDB\DocumentManager
	 * @todo Use values from config 
	 */
	public function getDocumentManager($name = 'default')
	{
		if (isset(self::$shared['dm'][$name])) {
			return self::$shared['dm'][$name];
		}
		
		$config = new Configuration();
		$config->setProxyDir(self::$config['doctrine']['proxyDir']);
		$config->setProxyNamespace(self::$config['doctrine']['proxyDir']);

		$config->setHydratorDir(self::$config['doctrine']['hydratorDir']);
		$config->setHydratorNamespace(self::$config['doctrine']['hydratorNamespace']);

		$reader = new AnnotationReader();
		$reader->setDefaultAnnotationNamespace(self::$config['doctrine']['annotationNamespace']);
		$config->setMetadataDriverImpl(new AnnotationDriver($reader, self::$config['doctrine']['metadataDriverPath']));

		$dm = DocumentManager::create(new Connection(), $config);
		
		self::$shared['dm'] = $dm;
		
		return self::$shared['dm'];	
	}

	/**
	 * Get template engine
	 * @return Game\Template\Template
	 */
	public function getTemplate()
	{
		if (isset(self::$shared['template'])) {
			return self::$shared['template'];
		}
		
		$tmpl = new Template();
		
		switch (self::$config['templateEngine']) {
			case 'smarty' : $tmpl->setTemplateAdapter($this->getSmartyAdapter());
				break;
			default: throw new Exception('Invalid Template Engine');	
		}
		
		
		self::$shared['template'] = $tmpl;
		
		return self::$shared['template'];
	}
	
	
	/**
	 * Get the smarty template adapter
	 * @return SmartyAdapter
	 */
	protected function getSmartyAdapter()
	{
		require_once LIB_PATH . '/Smarty/Smarty.class.php';
		$smarty = new \Smarty();
		
		$cfg = Registry::get('config');

		$smarty->setTemplateDir($cfg['smarty']['templateDir']);
		$smarty->setCompileDir($cfg['smarty']['compileDir']);
		$smarty->setCacheDir($cfg['smarty']['cacheDir']);
		$smarty->setConfigDir($cfg['smarty']['configDir']);
		
		if (isset($cfg['smarty']['resources']) && is_array($cfg['smarty']['resources'])) {
			foreach ($cfg['smarty']['resources'] as $name => $class) {
				$obj = new $class;
				$smarty->registerResource($name, array(
					array($obj, 'get_template'),
					array($obj, 'get_timestamp'),
					array($obj, 'get_secure'),
					array($obj, 'get_trusted')
				));
			}
		}
		
		// Make the config available to the template
		$smarty->assign('config', $cfg);
		
		$adapter = new SmartyAdapter($smarty);
		return $adapter;
	}
	
}
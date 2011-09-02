<?php
namespace C4\View;

use C4\View\Template\Extension\TwigUrlExtension;

use C4\Inflector;

use C4\View\Template\Adapter\TwigAdapter;

use C4\Configure;
use C4\View\Template\Template;
use C4\View\Template\TemplateInterface;
use C4\View\Template\Adapter\SmartyAdapter;
use C4\Exception;

/**
 * @todo Evaluate: View sits on top of template, which sits on top of templateadapter.  Is this too much?
 */
class View 
{
	
	/**
	 * Template system
	 * @var Template
	 */
	protected $template;
	
	protected $viewAction;

	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 * @deprecated Twig and smary do template inheritance, this is not needed
	 */
	protected $layout = 'layouts/default';
	
	
	
	public function __construct()
	{
		$this->initTemplate();
	}
	
	
	/**
	 * Render the view action
	 * @deprecated
	 */
	public function render()
	{
		$this->template->render();
	}
	
	/**
	 * @return the $viewAction
	 */
	public function getViewAction() {
		return $this->viewAction;
	}

	/**
	 * Set the view action (aka template name)
	 * @param field_type $viewAction
	 */
	public function setViewAction($viewAction) {
		$this->viewAction = $viewAction;
	}

	/**
	 * Get template engine
	 * @todo Config should have a template adapter class with options
	 * @return C4\View\Template\Template
	 */
	public function initTemplate()
	{
		$tmpl = new Template();
		
		switch (Configure::read('templateEngine')) {
			case 'smarty' : $tmpl->setTemplateAdapter($this->getSmartyAdapter());
				break;
			case 'twig' : $tmpl->setTemplateAdapter($this->getTwigAdapter());
				break;
			default: throw new Exception('Invalid Template Engine');	
		}
		
		$this->setTemplate($tmpl);
	}
	
	/**
	 * Get the Twig adapter
	 * @return TwigAdapter
	 * @todo This (and smarty) needs to move or done better.  Probably move into the TwigAdapter contructor.
	 *        The problem with a micro framework is we start moving into hardcore DI stuff.  Not bad, but not necessarily the best solution
	 */
	protected function getTwigAdapter()
	{
		
		$loader = new \Twig_Loader_Filesystem(Configure::read('twig.templateDir'));
		
		$twigOpts = Configure::read('twig');
		$opts = array();

		// de-inflect the config options
		foreach ($twigOpts as $key => $val) {
			$opts[Inflector::uninflect($key)] = $val;
		}
		
		$twig = new \Twig_Environment($loader, $opts);
		
		
		return new TwigAdapter($twig);
	}
	
	
	
	/**
	 * Get the smarty template adapter
	 * @return SmartyAdapter
	 * @deprecated In favor of twig.  Could still be resurrected
	 */
	protected function getSmartyAdapter()
	{
		require_once LIB_PATH . '/Smarty/Smarty.class.php';
		$smarty = new \Smarty();
		
		$cfg = Configure::get();

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
		if (isset($cfg['smarty']['defaultResourse'])) {
			$adapter->setDefaultResource($cfg['smarty']['defaultResourse']);	
		}
		
		return $adapter;
	}
	
	
	
	
	
	/**
	 * @return the $template
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @param field_type $template
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}


	/**
	 * Assign a value to a variable.  Wraps around Template.assign
	 * 
	 * @param string $var
	 * @param mixed $val
	 */
	public function assign($var, $val) {
		$this->template->assign($var, $val);		
	}

	public function display() {
		$this->template->display($this->getViewAction());		
	}

	
	public function fetch($name)
	{
		return $this->template->fetch($name);
	}
	
	
}
<?php 
namespace C4\View\Template\Adapter;

use C4\View\Template\TemplateInterface;
use C4\View\Template\Adapter\TemplateAdapterAbstract;

class SmartyAdapter extends TemplateAdapterAbstract
{
	
	/**
	 * Smarty instance 
	 * @var \Smarty
	 */
	protected $smarty;
	
	/**
	 * Default smarty resource
	 */
	protected $defaultResource = 'c4';

	
	public function __construct(\Smarty $smarty)
	{
		$this->smarty = $smarty;
	}
	
	/**
	 * Set the smarty object for this wrapper
	 * @param \Smarty $smarty
	 */
	public function setSmarty(\Smarty $smarty)
	{
		$this->smarty = $smarty;
	}
	
	/**
	 * @return \Smarty
	 */
	public function getSmarty()
	{
		return $this->smarty;
	}
	
	/* (non-PHPdoc)
	 * @see Game\Templace.TemplateInterface::assign()
	 */
	public function assign($var, $val) {
		$this->smarty->assign($var, $val);
	}

	/* (non-PHPdoc)
	 * @see Game\Templace.TemplateInterface::render()
	 */
	public function display($name) {
		$this->smarty->display($this->getTemplateName($name));
		
	}
	
	public function fetch($name)
	{
		return $this->smarty->fetch($this->getTemplateName($name));
	}
	
	private function getTemplateName($name)
	{
		if (!empty($this->defaultResource)) {
			$name = $this->defaultResource . ':' . $name;
		}

		return $name;
	}

	public function __call($name, $args)
	{
		if (method_exists($this->smarty, $name)) {
			call_user_func_array(array($this->smarty, $name), $args);
		}
	}
	
	
	/**
	 * @return the $defaultResource
	 */
	public function getDefaultResource() {
		return $this->defaultResource;
	}

	/**
	 * @param field_type $defaultResource
	 */
	public function setDefaultResource($defaultResource) {
		$this->defaultResource = $defaultResource;
	}

	
	
	
	
}


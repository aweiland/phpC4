<?php 
namespace C4\View\Template;

use C4\View\Template\Adapter\TemplateAdapterAbstract;
use C4\View\Template\TemplateInterface;

class Template implements TemplateInterface
{
	
	/**
	 * @var TemplateAdapterAbstract
	 */
	protected $templateAdapter;
	
	public function setTemplateAdapter(TemplateInterface $adapter)
	{
		$this->templateAdapter = $adapter;
	}
	

	/**
	 * Get the template Adapter
	 * @return TemplateInterface
	 */
	public function getTemplateAdapter()
	{
		return $this->templateAdapter;
	}
	
	public function assign($var, $val) {
		return $this->templateAdapter->assign($var, $val);		
	}

	public function display($name) {
		return $this->templateAdapter->display($name);		
	}

	public function fetch($name)
	{
		return $this->templateAdapter->fetch($name);
	}
	
}
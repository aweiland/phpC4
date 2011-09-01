<?php
namespace C4\View\Template\Extension;

use C4\Exception;

class TwigExtensions extends \Twig_Extension
{
	
	public function url(array $urlParts)
	{
		if (!isset($urlParts['controller'])) {
			throw new InvalidUrlException('Controller is required to build a url');
		}
		
		if (!isset($urlParts['action'])) {
			throw new InvalidUrlException('Action is required to build a url');
		}
		
		$url = "/{$urlParts['controller']}/{$urlParts['action']}/";
		
		unset($urlParts['controller'], $urlParts['action']);
		
		foreach ($urlParts as $key => $val) {
			$url .= $key . '/' . $val;
		}
		
		return $url;
	}
	
	public function action($action, $controller, $vars = array())
	{
		$vars['action'] = $action;
		$vars['controller'] = $controller;
		
		return $this->url($vars);
	}
	
	/* (non-PHPdoc)
	 * @see Twig_Extension::getFunctions()
	 */
	public function getFunctions() {
		return array(
			'url' => new \Twig_Function_Method($this, 'url'),
			'action' => new \Twig_Function_Method($this, 'action')
		);
		
	}

	
	
	public function getName()
	{
		return 'C4Extensions';
	}
	
	public function getFitlers()
	{
		return array();
	}
	
}
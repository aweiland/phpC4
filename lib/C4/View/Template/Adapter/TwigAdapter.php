<?php
namespace C4\View\Template\Adapter;

use C4\View\Template\Extension\TwigExtensions;

use C4\View\Template\Extension\TwigUrlExtension;
use C4\View\Template\Extension\InvalidUrlException;
use C4\View\Template\TemplateInterface;

class TwigAdapter implements TemplateInterface
{
	
	protected $vars = array();
	
	/**
	 * Twig
	 * @var \Twig_Environment
	 */
	protected $twig;
	
	protected $extender;
	
	
	public function __construct(\Twig_Environment $twig)
	{
		$this->twig = $twig;
		
		$this->registerExtensions();
	}
	
	private function registerExtensions()
	{
		$this->twig->addExtension(new TwigExtensions());
	}
		
		
	
	/**
	 * Twig doesn't store vars, but expects them as an array at render time.  We store them
	 * in an array here so they can be set and overridden.  It's up to the user
	 * @see C4\View\Template.TemplateInterface::assign()
	 */
	public function assign($var, $val) {
		$this->vars[$var] = $val;
		
	}

	/* (non-PHPdoc)
	 * 
	 */
	public function display($name) {
		if (strpos($name, '.twig') === false) {
			$name .= '.twig';
		}
		
		$template = $this->twig->loadTemplate($name);
		echo $template->render($this->vars);
	}
	
	/* (non-PHPdoc)
	 * @see C4\View\Template.TemplateInterface::fetch()
	 */
	public function fetch($name) {
		// TODO Auto-generated method stub
		if (strpos($name, '.twig') === false) {
			$name .= '.twig';
		}
		
		$template = $this->twig->loadTemplate($name);
		
		// Yep render().  Seems like a strange name but check it out!
		return  $template->render($this->vars);
	}


	
}
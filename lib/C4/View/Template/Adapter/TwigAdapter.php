<?php
namespace C4\View\Template\Adapter;

use C4\View\Template\TemplateInterface;

class TwigAdapter implements TemplateInterface
{
	
	protected $vars = array();
	
	/**
	 * Twig
	 * @var Twig_Environment
	 */
	protected $twig;
	
	
	public function __construct(\Twig_Environment $twig)
	{
		$this->twig = $twig;
	}
	
	
	/* (non-PHPdoc)
	 * @see Game\Templace.TemplateInterface::assign()
	 */
	public function assign($var, $val) {
		$this->vars[$var] = $val;
		
	}

	/* (non-PHPdoc)
	 * @see Game\Templace.TemplateInterface::render()
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
		
	}


	
}
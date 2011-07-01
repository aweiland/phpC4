<?php
namespace C4\View\Template;

interface TemplateInterface
{
	
	public function assign($var, $val);
	
//	public function assignByRef($var, &$val);
	
	public function display($name);
	
	public function fetch($name);
}
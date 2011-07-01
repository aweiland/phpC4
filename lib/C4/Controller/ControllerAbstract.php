<?php
namespace C4\Controller;

use C4\View\View;

abstract class ControllerAbstract
{
	
	/**
	 * 
	 * Enter description here ...
	 * @var View
	 */
	protected $view;
	
	public function init() {
		
	}
	
	
	/**
	 * @return the $view
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * @param View $view
	 */
	public function setView($view) {
		$this->view = $view;
	}

	
	
	
	
}
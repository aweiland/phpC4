<?php
namespace C4\View\Template;


class SmartyExtensions {
	
	public function get_template($tpl_name, &$tpl_source, $smarty) {
		if (file_exists(ROOT_PATH . "/templates/$tpl_name.html")) {
			$tpl_source = file_get_contents(ROOT_PATH . "/templates/$tpl_name.html");
			return true;
		}
		
    	return false;
	}

	public function get_timestamp($tpl_name, &$tpl_timestamp, $smarty) {
	
		if (file_exists(ROOT_PATH . "/templates/$tpl_name.html")) {
			$tpl_timestamp = filemtime(ROOT_PATH . "/templates/$tpl_name.html");
			return true;
		}
		else {
			//critical_error("Template Error", "Cannot load template <em>$tpl_name</em>", true);
		}
		
	    return false;
	}

	public function get_secure($tpl_name, &$smarty) {
    	return true;
	}

	public function get_trusted($tpl_name, &$smarty) {	
	
	}
	
	
}
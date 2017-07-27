<?php
include PATH."/class/admin.class.php";

/* This is the first class in the chain */

class templates_functions extends admin_functions {

	public function page_header() {
		$data = null;
		$template = "header.html.tpl";
		$dir = "/design";
		$this->load_smarty($data,$template,$dir);
	}

}
?>
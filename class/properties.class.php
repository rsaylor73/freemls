<?php
include PATH."/class/templates.class.php";

/* This is the first class in the chain */

class properties_functions extends templates_functions {

	public function homepage() {
		// This is the first page
		print "<br><h1>Home Page!</h1><br>";
	}

}
?>

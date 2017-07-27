<?php
/* -----------------------------------------
// This file controls the actions of the template class
// Version 1.00
// Author: Robert Saylor
// robert@customphpdesign.com
*/


// This is PHP Smarty
require_once(PATH .'/libs/Smarty.class.php');
$smarty=new Smarty();

$smarty->setTemplateDir(PATH . '/templates/');
$smarty->setCompileDir(PATH . '/templates_c/');
$smarty->setConfigDir(PATH . '/configs/');
$smarty->setCacheDir(PATH . '/cache/');

// init the core class (custom code)
include PATH."/class/loader.class.php";
$core = new loader($linkID);

?>

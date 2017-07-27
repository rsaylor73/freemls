<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "include/settings.php";
include "include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

// init
$section = "";

// header
$core->page_header();

if ($_GET['section'] != "") {
        $section = $_GET['section'];
}
if ($_POST['section'] != "") {
        $section = $_POST['section'];
}

if ($section == "") {
	$core->load_module('homepage');
} else {
	$core->load_module($section);
}

print "<br><br>Welcome you have survived many packages just now code base framework is under construction.<br>";


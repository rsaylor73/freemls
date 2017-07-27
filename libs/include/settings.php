<?php
// Set global setting for the path
define('PATH',$_SERVER['DOCUMENT_ROOT']."/");

// MySQL settings file that is unique to each install
$HOST = "localhost"; // the hostname you can also specify the hostname:port
$USER = "sundance_root"; // the mysql username
$PASSWORD = "cJ?UK4D4ryhK"; // the mysql password
$DATABASE = "sundance_db"; // the mysql database

define('HOST',$HOST);
define('USER',$USER);
define('PASSWORD',$PASSWORD);
define('DATABASE',$DATABASE);

$linkID = new mysqli(HOST, USER, PASSWORD, DATABASE);

// IP of virtual host
define('SERVER_IP','66.71.252.139');

define('LINK1','http://www.google.com');
define('LINK2','http://www.yahoo.com');
define('LINK3','http://www.ask.com');

define('TITLE1','HMC');
define('TITLE2','Patient Pal');
define('TITLE3','Telemedicine');

// email headers - This is fine tuned, please do not modify
$sitename = "Sundance Benefits";
$site_email = "info@sundancebenefits.com";
define('SITENAME',$sitename);

$header = "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
$header .= "From: $sitename <$site_email>\r\n";
$header .= "Reply-To: $sitename <$site_email>\r\n";
$header .= "X-Priority: 3\r\n";
$header .= "X-Mailer: PHP/" . phpversion()."\r\n";
define('header_email',$header);

?>

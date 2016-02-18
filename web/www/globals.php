<?php
# PHP settings
# These should be set in either Apache conf/vhost/.htaccess or php.ini
# Here is just a simple fallback
error_reporting(E_ALL);
ini_set('display_errors', True);

# Application-wise vars
$APP = array(
	"HTML_Title"  => "MestreLion's ConquerClub Tools",
	"VirtualPath" => "/conquerclub",
	"Environment" => "desktop",
	"DataDir"     => $_SERVER["DATA_DIR"],

	"VisibleAnnouncements" =>  3,
	"MaxAnnouncements"     => 10,
);

# Session vars
session_start();

if (!isset($_SESSION["username"])) {
	$_SESSION["username"] = "MestreLion";
}
?>

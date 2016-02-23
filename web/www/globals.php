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

# Clan global array
$CLAN = array(
	"name"      => "",
	"shortname" => "",
	"clanid"    =>  0,
	"groupid"   =>  0,
	"forumid"   =>  0,
);
if (($fd = @fopen($APP['DataDir'] . "/clan.txt", "r"))) {
	$data = fgetcsv($fd, 1000, "\t");
	if (count($data) == count($CLAN)) {
		$CLAN["name"]      = trim(  $data[0]);
		$CLAN["shortname"] = trim(  $data[1]);
		$CLAN["clanid"]    = intval($data[2]);
		$CLAN["groupid"]   = intval($data[3]);
		$CLAN["forumid"]   = intval($data[4]);
	}
	unset($data);
	fclose($fd);
}
unset($fd);

# Session vars
session_start();

if (!isset($_SESSION["username"])) {
	$_SESSION["username"] = "MestreLion";
}
?>

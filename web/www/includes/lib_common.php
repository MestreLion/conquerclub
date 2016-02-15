<?php
function get_str($var, $default="") {
	return isset($_GET[$var]) ? $_GET[$var] : $default;
}

function get_int($var, $default=0) {
	return intval(!empty($_GET[$var]) ? $_GET[$var] : $default);
}

# Alias to get_str
function get($var, $default="") {
	return get_str($var, $default);
}

function session($var, $default="") {
	return isset($_SESSION[$var]) ? $_SESSION[$var] : $default;
}
?>

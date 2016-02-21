<?php
# Generic get
function get($var, $default="") {
	return isset($_GET[$var]) ? $_GET[$var] : $default;
}

# get() with trim(), defaults to empty string
function get_str($var, $default="") {
	return trim(get($var, $default));
}

# get() with intval(), defaults to 0
function get_int($var, $default=0) {
	return intval(!empty($_GET[$var]) ? $_GET[$var] : $default);
}

# get(), defaults to empty array
function get_arr($var, $default=array()) {
	return get($var, $default);
}

function session($var, $default="") {
	return isset($_SESSION[$var]) ? $_SESSION[$var] : $default;
}

# Function aliases
# PHP 5.3:  $g = function($v) { return f($v); };
# PHP 5.5:  function g() { return call_user_func_array("f", func_get_args()); }
# PHP 5.6+: use function f as g;
# All (wrapper): function g(args) { return f(args); }
function _H($v) { return htmlspecialchars($v, ENT_QUOTES); }  # PHP5.4: add | ENT_HTML401
function _U(  ) { return call_user_func_array("urlencode",   func_get_args()); }
function _J(  ) { return call_user_func_array("json_encode", func_get_args()); }
?>

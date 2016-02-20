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

# Function aliases
# PHP 5.3:  $g = function($v) { return f($v); };
# PHP 5.5:  function g() { return call_user_func_array("f", func_get_args()); }
# PHP 5.6+: use function f as g;
# All (wrapper): function g(args) { return f(args); }
function _H($v) { return htmlspecialchars($v, ENT_QUOTES); }  # PHP5.4: add | ENT_HTML401
function _U(  ) { return call_user_func_array("urlencode",   func_get_args()); }
function _J(  ) { return call_user_func_array("json_encode", func_get_args()); }
?>

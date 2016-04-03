<?include "globals.php"?>
<?include "includes/lib_common.php"?>
<?include "includes/lib_html.php"?>
<?php

# Default values
$player = get_str("player", session("username"));
$types  = get_arr("type",   array('P', 'D', 'T', 'Q'));

HTML_Header("Map Rank");
HTML_Content_Title("Map Rank", "");
HTML_Form($player, $types);

if ($_GET) {
	$url = "cgi-bin/maprank.cgi" .
		"?player=" . urlencode($player) .
		"&types="  . urlencode(implode($types, ','));
	HTML_AnimatedLoadNestedURLs($url, $url . "&info=1", "", "<br>", "<strong>", "</strong>");
}
HTML_Footer();
?>
<?function HTML_Form($player, $types) {?>
<form class="ccform" action="" method="get" id="find">
<fieldset>
<legend>Search</legend>
<div class="field-row">
	<label class="field-label" for="player">Player</label>
	<input type="text" class="field" name="player" id="player" maxlength="16" value="<?=_H($player)?>"/>
</div>
<div class="field-row">
	<span class="field-label">Game Type</span>
<?
	foreach(
		array(
			'S' => "Standard",
			'C' => "Terminator",
			'A' => "Assassin",
			'P' => "Polymorphic",
			'D' => "Doubles",
			'T' => "Triples",
			'Q' => "Quadruples",
		) as $type => $name) {
?>
	<input type="checkbox" name="type[]" id="game_type_<?=$type?>" value="<?=$type?>"<?if (in_array($type, $types)) {?> checked="checked"<?}?>/><label for="game_type_<?=$type?>"><?=_H($name)?></label>
<?
	}
?>
</div>
<br/>
<div class="field-row">
	<input type="submit" class="button" name="submit" value="Search"/>
</div>
</fieldset>
</form>
<br/>
<?}?>

<?include "globals.php"?>
<?include "includes/lib_common.php"?>
<?include "includes/lib_html.php"?>
<?php
HTML_Header("CL7 Scoreboards");
HTML_Content_Title("CL7 Scoreboards", "");

$scores = array(
	array("mode" => "finished", "title" => "Finished matches only:"),
	array("mode" => "ongoing",  "title" => "Including ongoing matches:"),
);
foreach($scores as $score) {
	HTML_Item($score["title"]);
	HTML_AnimatedLoadURL(
		"cgi-bin/league_scoreboard.cgi" .
			"?mode=" . _U($score["mode"]) .
			"&clan=" . _U($CLAN['shortname']),
		$score["mode"]
	);
}
HTML_Footer();
?>
<?function HTML_Item($title="") {?>
	<h4><?=_H($title)?></h4>
<?}?>

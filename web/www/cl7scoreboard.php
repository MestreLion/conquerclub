<?include "globals.php"?>
<?include "includes/lib_common.php"?>
<?include "includes/lib_html.php"?>
<?php
HTML_Header("CL7 Scoreboards");
HTML_Content_Title("CL7 Scoreboards", "");

$cgi="cgi-bin/league_scoreboard.cgi";

$scores = array(
	array("mode" => "finished", "title" => "Finished matches only:"),
	array("mode" => "ongoing",  "title" => "Including ongoing matches:"),
);
foreach($scores as $score) {
	HTML_Item($score["title"]);
	HTML_AnimatedLoadURL(
		$cgi . "?mode=" . _U($score["mode"]) . "&clan=" . _U($CLAN['shortname']),
		$score["mode"]
	);
}
HTML_Legend();
HTML_Item($CLAN['name'] . " matches:");
HTML_AnimatedLoadURL($cgi . "?mode=matches&clanid=" . _U($CLAN['clanid']), "list");
HTML_Footer();
?>
<?function HTML_Item($title="") {?>
	<h4><?=_H($title)?></h4>
<?}?>
<?function HTML_Legend() {?>
<h4>Legend:</h4>
<ul>
	<li><b>Rank:</b> Current position on the scoreboard. Only takes into account Points and Game Difference, but <a href="https://www.conquerclub.com/forum/viewtopic.php?f=441&amp;t=215023">CL7 has more rules for tie-breaking</a>!</li>
	<li><b>Clan:</b> Clan name, duh! Actually it's the abbreviated name, usually an acronym</li>
	<li><b>Matches:</b> A match is a set of 8 games, so "Home Games for PACK vs ATN" are 1 match.</li>
	<li><b>MWon, MDraw, MLost:</b> Matches Won, Draw (tied), Lost</li>
	<li><b>Points:</b> The main ranking criteria. Each match win is worth 2 points, and 1 for a draw.</li>
	<li><b>GDiff:</b> Game Difference between games won and lost.</li>
	<li><b>Games:</b> Games won and Games lost</li>
	<li><b>More details:</b> <a href="https://www.conquerclub.com/forum/viewtopic.php?f=441&amp;t=215026#p4728916">Official (but most likely outdated) scoreboard</a></li>
</ul>
<?}?>

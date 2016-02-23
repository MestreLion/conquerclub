<?include "globals.php"?>
<?include "includes/lib_common.php"?>
<?include "includes/lib_html.php"?>
<?php
HTML_Header("CL7 Scoreboards");
HTML_Content_Title("CL7 Scoreboards", "");
HTML_AnimatedLoadURL("cgi-bin/league_scoreboard.cgi?clan=" . urlencode($CLAN['shortname']));
HTML_Footer();
?>

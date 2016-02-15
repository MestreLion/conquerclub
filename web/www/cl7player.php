<?include "globals.php"?>
<?include "includes/lib_common.php"?>
<?include "includes/lib_html.php"?>
<?php
HTML_Header("CL7 Player Rank");
HTML_Content_Title("CL7 Player Rank", "");
HTML_AnimatedLoadURL("cgi-bin/clanplayerrank.cgi?player=" . urlencode(session('username')));
HTML_Footer();
?>

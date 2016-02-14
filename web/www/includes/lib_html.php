<?php
function HTML_Header($title="") {
	global $APP;

	if ($title)
		$title = " :: $title";

	// CCT = EST (but actually calculated CST+1, so DST kicks in at a different hour)
	$cctime = new DateTime(null, new DateTimeZone('America/New_York'));
	$currenttime = $cctime->format("M d Y, H:i:s");
	$currenttime_html = $cctime->format("M d, H:i:s");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=$APP['HTML_Title']?><?=$title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Tools for ConquerClub players" />
	<meta name="keywords" content="conquer club,risk" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="css/skidoo_too.min.css" type="text/css" />
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<link   type="text/css"       href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" />
	<script type="text/javascript">
		// Load local jquery as fallback if CDN is not available
		// Use a single test for all files, assuming that if first fails all others will fail too
		window.jQuery ||
		document.write(
			'\x3Cscript type="text/javascript" src="js/jquery-1.12.0.min.js"\x3E\x3C/script\x3E\n' +
			'\x3Cscript type="text/javascript" src="js/jquery-ui-1.11.4.min.js"\x3E\x3C/script\x3E\n' +
			'\x3Clink   type="text/css"      href="css/jquery-ui-1.11.4.smoothness.min.css" rel="stylesheet" /\x3E\n'
		);
	</script>
	<script type="text/javascript">
		var app_id = '';
		var app_context = '';
		var is_mobile_device = false;
		var is_new_recruit = false;
		var is_new_player = false;
		var currenttime = '<?=$currenttime?>';
		var GameHideNav = 'N';
	</script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/lightbox.js"></script>
	<script type="text/javascript" src="js/pagination1.js"></script>
</head>

<body>
<div id="pageWrapper">

<div id="mainheader">
	<div id="mainNavAndLogo">
		<div id=CC_mainlogo><a href="<?=strtok($_SERVER["REQUEST_URI"],'?')?>"><img src="images/static/cc_logo.png" alt="MestreLion's Conquer Club Tools" title="MestreLion's ConquerClub Tools" /></a></div>
		<div id=mainNav>
			<li><a>Welcome to MestreLion's amazing ConquerClub humble tools!</a></li>
		</div>
	</div>
	<div id="rightNav">
		<li><a href="">FORUM</a></li><br />
		<li><a href="">HELP</a></li><br />
		<li><a href="">RULES</a></li><br />
	</div>
</div>
<div id="mainheader_mobile">
	<div id=CC_mainlogo_mobile><a href="<?=strtok($_SERVER["REQUEST_URI"],'?')?>"><img src="images/static/icon.png" alt="MestreLion's Conquer Club Tools" title="MestreLion's ConquerClub Tools" /></a></div>
	<div id=mainNav_mobile>
		<span><a>MestreLion's ConquerClub Tools</a></span>
	</div>
</div>

<div id="outerColumnContainer">
	<div id="innerColumnContainer">
		<div id="SOWrap">
			<div id="leftColumn">
				<div id=leftColumninner class="inside">
<!--- left column begin -->
<div class="vnav" id="leftnav">
	<div id="cctime" style="font-size:12px; font-weight:bold; color:black; display: inline-block; text-align:center;z-index:10;padding:0px;width:100%;">
		<span id="servertime"><?=$currenttime_html?> CCT</span>
	</div>
	<p style='margin-bottom:0px;width:100%;display: inline-block; text-align:center;'>[<a href="<?=$APP['VirtualPath']?>">logout <b>MestreLion</b></a>]</p>

	<h3>Game Menu</h3>
	<ul>
		<li><a href="">Central Command</a></li>
		<li><a href="">Join Games</a></li>
		<li><a href="">Start Games</a></li>
		<li><a href="">Game Finder</a></li>
		<li><a href="">Battle Royale</a></li>
		<li><a href="">Other Games</a></li>
	</ul>

	<h3>Announcements</h3>
	<ul style='opacity:.9;font-size:10px;'>
		<li><a title='Clans: February Platoon Report is here!' href=''><span class='player6'>&bull;</span>February Platoon Report is here!</a></li>
		<li><a title='Events: Official February Challenge -- Febenario!' href=''><span class='player5'>&bull;</span>Official February Challenge -- Febenario!</a></li>
		<li><a title='Tournaments: Fight For a Beer' href=''><span class='player7'>&bull;</span>Fight For a Beer</a></li>
		<li class=announcements style='display:none;'><a title='Events: Monumental Battle Royale Game Reforged' href=''><span class='player5'>&bull;</span>Monumental Battle Royale Game Reforged</a></li>
		<li class=announcements style='display:none;'><a title='Community: Congrats to GreenBaize on SOS Africa II Triumph' href=''><span class='player2'>&bull;</span>Congrats to GreenBaize on SOS Africa II Triumph</a></li>
		<li class=announcements style='display:none;'><a title='Events: Five tourneys left for Decade in Review Challenge' href=''><span class='player5'>&bull;</span>Five tourneys left for Decade in Review Challenge</a></li>
		<li class=announcements style='display:none;'><a title='Tournaments: Quads Teams Needed for New TPA tourney.' href=''><span class='player7'>&bull;</span>Quads Teams Needed for New TPA tourney.</a></li>
		<li class=announcements style='display:none;'><a title='Community: Say Something Nice' href=''><span class='player2'>&bull;</span>Say Something Nice</a></li>
		<li class=announcements style='display:none;'><a title='Community: Congratulations to all the Olympic Medalists' href=''><span class='player2'>&bull;</span>Congratulations to all the Olympic Medalists</a></li>
		<li class=announcements style='display:none;'><a title='Webmaster: CC Will Soon Celebrate its Tenth Birthday!' href=''><span class='player1'>&bull;</span>CC Will Soon Celebrate its Tenth Birthday!</a></li>
		<li class=announcements style='display:none;'><a title='Maps: WWI Gallipoli has been Quenched!' href=''><span class='player3'>&bull;</span>WWI Gallipoli has been Quenched!</a></li>
		<li class=announcements style='display:none;'><a title='Maps: Beta testers needed for new maps.' href=''><span class='player3'>&bull;</span>Beta testers needed for new maps.</a></li>
		<li class=announcements style='display:none;'><a title='Webmaster: New Campaigns!' href=''><span class='player1'>&bull;</span>New Campaigns!</a></li>
		<li class=announcements style='display:none;'><a title='Maps: Open callout for Foundry Volunteers' href=''><span class='player3'>&bull;</span>Open callout for Foundry Volunteers</a></li>
		<li><a id=more href="#" onClick="showannouncements(); return false;">More</a></li>
	</ul>

	<h3>Interaction Menu</h3>
	<ul>
		<li><a href="">Forum</a></li>
		<li><a href="">Chat Rooms</a></li>
		<li><a href="">Inbox<span id="privmsg"></span></a></li>
		<li><a href="">Wall<span id="wall"></span></a></li>
		<li><a href="">My Ratings</a></li>
	</ul>
	<h3>Personal Menu</h3>
	<ul>
		<li><a href="">Store</a></li>
		<li><a href="">Control Panel</a></li>
		<li><a href="">Settings</a></li>
		<li><a href="">Referral Program</a></li>
		<li><a href="">Dice Stats</a></li>
		<li><a href="">Medal Stats</a></li>
		<li><a href="">Inventory</a></li>
	</ul>
</div>
<!--- left column end -->
				</div>
			</div>
			<div id="middleColumn">
				<div class="inside">
<!--- middle (main content) column begin -->
<?}?>
<?function HTML_Content_Title($title="Results", $subtitle="Here are all the results that match your search criteria:") {?>
<h2><?=$title?></h2>
<div id="headerline">&nbsp;</div>
<?if ($subtitle) {?>
<p><?=$subtitle?></p>
<?}?>
<?}?>
<?function HTML_Pagination($page=1, $totalpages=1, $results=0, $url='?page=', $topbottom="top") {?>
<?if ($topbottom == "top") {?>
<script type="text/javascript">
	var totalPages = <?=$totalpages?>;
	var currentPage = <?=$page?>;
	var gotoUrl = "<?=$url?>";
</script>
<?}?>
<div class="ccpagination">
	<span class="search_results"><?=$results?> results on <?=$totalpages?> pages:</span>
	<a href="<?=$url?>1" class="firstLast<?=($page<=1)?' disabled':''?>">&lt;&lt;</a>
	<a href="<?=$url?><?=$page-1?>" class="nextPrev<?=($page<=1)?' disabled':''?>">&lt;</a>
	<span class="current_page">Page <?=$page?></span>
	<a href="<?=$url?><?=$page+1?>" class="nextPrev<?=($page>=$totalpages)?' disabled':''?>">&gt;</a>
	<a href="<?=$url?><?=$totalpages?>" class="firstLast<?=($page>=$totalpages)?' disabled':''?>">&gt;&gt;</a>
	<a href="#" onclick="togglePagePicker('<?=$topbottom?>'); return false;" class="dropdown<?=($totalpages<=1)?' disabled':''?>">&nbsp;<img src="images/static/pagination_open.gif" alt="v" />&nbsp;</a>
	<div id="page_picker_<?=$topbottom?>" class="page_picker" style="display:none">
		<h4 style="text-align:center">Go to page...</h4>
		<input type="button" value="&lt;" onmousedown="startTicker(-1, '<?=$topbottom?>');" class="ticker_button" />
		<input type="text" id="page_picker_input_<?=$topbottom?>" size="4" onkeydown="keyCheck(event, '<?=$topbottom?>');" />
		<input type="button" value="&gt;" onmousedown="startTicker(1, '<?=$topbottom?>');" class="ticker_button" />
		<input type="button" value="Go" onclick="gotoPage('<?=$topbottom?>');" class="page_picker_button" />
	</div>
</div>
<?}?>
<?function HTML_Footer() {?>
<!--- middle (main content) column end -->
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>


<!-- footer begin -->
<div id="footer">
	<table width=100% border=0>
		<tr height=40>
			<td align=left valign=center>
				<div id=footer_nav class=footerNav   style='display: table-cell;height:30px;vertical-align:middle;'>
					<a href="https://www.conquerclub.com/player.php?mode=mygames1">Conquer Club</a> |
					<a href="/">Rodrigo Silva</a> |
					<a href="mailto:conquerclub@rodrigosilva.com">Contact</a>
				</div>
			</td>
			<td width=20></td>
			<td align=center>
				<div id=footer_copyright style='width:100%;text-align:center;display: table-cell;height:30px;vertical-align:middle;'>
					MestreLion's Tools is not associated with Conquer Club or RISK online in any way. Copyright &copy; 2016 by MestreLion
				</div>
			</td>
			<td width=20></td>
			<td align=right>
				<div id=footer_social>
					<a style='padding-left:5px;padding-right:5px;' href='http://facebook.com/rodrigo.es.silva' target=_blank><img border=0 src='images/static/footer-facebookicon.png'></a>
					<a style='padding-left:5px;padding-right:5px;' href='http://twitter.com/@RodrigoESSilva' target=_blank><img src='images/static/footer-twittericon.png'></a>
				</div>
			</td>
		</tr>
	</table>
</div>
<!-- footer end -->


</div>
</body>
</html>
<?}?>

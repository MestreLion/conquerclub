<?php
function HTML_Header($title="") {
	global $APP;
	global $CLAN;

	if ($title)
		$title = " :: $title";

	// CCT = EST (but actually calculated CST+1, so DST kicks in at a different hour)
	$cctime = new DateTime(null, new DateTimeZone('America/New_York'));
	$currenttime = $cctime->format("M d Y, H:i:s");
	$currenttime_html = $cctime->format("M d, H:i:s");

	// Annoucements
	$announcements = array();
	if (($fd = @fopen($APP['DataDir'] . "/announcements.txt", "r"))) {
		$i = 0;
		while (($announcement = fgetcsv($fd, 1000, "\t")) && (++$i <= $APP['MaxAnnouncements'])) {
			$announcements[] = array(
				"title"  => $announcement[0],
				"url"    => count($announcement) > 1 ? $announcement[1] : "",
				"hidden" => ($i > $APP['VisibleAnnouncements']),
				"style"  => "1",
			);
		}
		fclose($fd);
	}

	// Localhost matching
	$is_local = in_array($_SERVER["SERVER_NAME"],
		array(
			"localhost",
			"127.0.0.1",
			gethostname(),
		)
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=_H($APP['HTML_Title'])?><?=_H($title)?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="Tools for ConquerClub players"/>
	<meta name="keywords"    content="conquer club,risk"/>
	<meta name="viewport"    content="width=device-width, initial-scale=1"/>
	<link rel="shortcut icon" href="favicon.ico"/>
	<link rel="stylesheet" href="css/skidoo_too.min.css"/>
	<link rel="stylesheet" href="css/stylesheet.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"                          integrity="sha384-XxcvoeNF5V0ZfksTnV+bejnCsJjOOIzN6UVwF85WBsAnU3zeYh5bloN+L4WLgeNE" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"                    integrity="sha384-YWP9O4NjmcGo4oEJFXvvYSEzuHIvey+LbXkBNJ1Kd0yfugEZN9NCQNpRYBVC1RvA" crossorigin="anonymous"></script>
	<link rel="stylesheet"        href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css" integrity="sha384-A/CgvDCSM2jOpa4G++hlEtzweAjg53uGXJLUnen/qb5faVDcN+vaHrL5czAdzhK8" crossorigin="anonymous"/>
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
		var currenttime = <?=_J($currenttime)?>;
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
		<div id="CC_mainlogo"><a href="<?=_H($APP['VirtualPath'])?>"><img src="images/static/cc_logo.png" alt="<?=_H($APP['HTML_Title'])?>" title="<?=_H($APP['HTML_Title'])?>"/></a></div>
		<div id="mainNav">
			<ul><li><a>Welcome to MestreLion's amazing ConquerClub humble tools!</a></li></ul>
		</div>
	</div>
	<div id="rightNav"></div>
</div>
<div id="mainheader_mobile">
	<div id="CC_mainlogo_mobile"><a href="<?=_H($APP['VirtualPath'])?>"><img src="images/static/icon.png" alt="<?=_H($APP['HTML_Title'])?>" title="<?=_H($APP['HTML_Title'])?>"/></a></div>
	<div id="mainNav_mobile">
		<span><a><?=_H($APP['HTML_Title'])?></a></span>
	</div>
</div>

<div id="outerColumnContainer">
	<div id="innerColumnContainer">
		<div id="SOWrap">
			<div id="leftColumn">
				<div id="leftColumninner" class="inside">
<!--- left column begin -->
<div class="vnav" id="leftnav">
	<div id="cctime" style="font-size:12px; font-weight:bold; color:black; display: inline-block; text-align:center;z-index:10;padding:0px;width:100%;">
		<span id="servertime"><?=_H($currenttime_html)?> CCT</span>
	</div>
	<p style='margin-bottom:0px;width:100%;display: inline-block; text-align:center;'>[<a href="logout.php">logout <b><?=_H(session('username'))?></b></a>]</p>

	<h3>Main Tools</h3>
	<ul>
		<li><a href="maprank.php">Map Rank</a></li>
	</ul>

	<h3>Clan League 7</h3>
	<ul>
		<li><a href="cl7scoreboard.php">Scoreboards</a></li>
		<li><a href="cl7player.php">Player Rank</a></li>
	</ul>

<?	if ($announcements) {?>
	<h3>Announcements</h3>
	<ul style='opacity:.9;font-size:10px;'>
<?		foreach($announcements as $i) {?>
		<li<?if($i['hidden']){?> class="announcements" style="display:none;"<?}?>><a title="<?=_H($i['title'])?>" href="<?=_H($i['url'])?>"><span class="player<?=_H($i['style'])?>">&bull;&nbsp;</span><?=_H($i['title'])?></a></li>
<?		}?>
		<li><a id="more" href="#" onclick="showannouncements(); return false;">More</a></li>
	</ul>

<?	}?>
	<h3>Conquer Club</h3>
	<ul>
		<li><a href="https://www.conquerclub.com/player.php?mode=mygames1">Central Command</a></li>
		<li><a href="https://www.conquerclub.com/forum/memberlist.php?mode=viewprofile&amp;un=<?=_U(session('username'))?>">Profile</a></li>
		<li><a href="https://www.conquerclub.com/forum/index.php">Forum</a></li>
		<li><a href="https://www.conquerclub.com/forum/viewforum.php?f=<?=_U($CLAN['forumid'])?>"><?=_H($CLAN['shortname'])?> Forum</a></li>
	</ul>

	<h3>Risk Tools</h3>
	<ul>
		<li><a href="http://gamesbyemail.com/games/gambit/battleodds">Gambit Battle Odds</a></li>
		<li><a href="http://riskodds.com">RISK&copy; Odds Generator</a></li>
		<li><a href="http://www.morningtoast.com/feature/risk/">Risk Dice Roller</a></li>
		<li><a href="http://diceroll.stritar.net/risk.html">Dice Roll Simulation</a></li>
	</ul>

<?	if ($is_local) {?>
	<h3>Development</h3>
	<ul>
		<li><a href="template.html">HTML Template</a></li>
		<li><a href="template.php">PHP Template</a></li>
		<li><a href="phpinfo.php">PHP Info</a></li>
		<li><a href="error.php">Error Test</a></li>
	</ul>

<?	}?>
</div>
<!--- left column end -->
				</div>
			</div>
			<div id="middleColumn">
				<div class="inside">




<!--- middle (main content) column begin -->
<?}?>
<?function HTML_Content_Title($title="Results", $subtitle="Here are all the results that match your search criteria:") {?>
<h2><?=_H($title)?></h2>
<div id="headerline">&nbsp;</div>
<p><?=_H($subtitle)?></p>
<?}?>
<?function HTML_Pagination($page=1, $totalpages=1, $results=0, $url='?page=', $topbottom="top") {?>
<?	if ($topbottom == "top") {?>
<script type="text/javascript">
	var totalPages = <?=_J($totalpages)?>;
	var currentPage = <?=_J($page)?>;
	var gotoUrl = <?=_J($url)?>;
</script>
<?	}?>
<div class="ccpagination">
	<span class="search_results"><?=_H($results)?> results on <?=_H($totalpages)?> pages:</span>
	<a href="<?=_H($url)?>1" class="firstLast<?if ($page<=1) {?> disabled<?}?>">&lt;&lt;</a>
	<a href="<?=_H($url)?><?=_H($page-1)?>" class="nextPrev<?if ($page<=1) {?> disabled<?}?>">&lt;</a>
	<span class="current_page">Page <?=_H($page)?></span>
	<a href="<?=_H($url)?><?=_H($page+1)?>" class="nextPrev<?if ($page>=$totalpages) {?> disabled<?}?>">&gt;</a>
	<a href="<?=_H($url)?><?=_H($totalpages)?>" class="firstLast<?if ($page>=$totalpages) {?> disabled<?}?>">&gt;&gt;</a>
	<a href="#" onclick="togglePagePicker(<?=_H(_J($topbottom))?>); return false;" class="dropdown<?if ($totalpages<=1) {?> disabled<?}?>">&nbsp;<img src="images/static/pagination_open.gif" alt="v"/>&nbsp;</a>
	<div id="page_picker_<?=_H($topbottom)?>" class="page_picker" style="display:none">
		<h4 style="text-align:center">Go to page...</h4>
		<input type="button" value="&lt;" onmousedown="startTicker(-1, <?=_H(_J($topbottom))?>);" class="ticker_button"/>
		<input type="text" id="page_picker_input_<?=_H($topbottom)?>" size="4" onkeydown="keyCheck(event, <?=_H(_J($topbottom))?>);"/>
		<input type="button" value="&gt;" onmousedown="startTicker( 1, <?=_H(_J($topbottom))?>);" class="ticker_button"/>
		<input type="button" value="Go" onclick="gotoPage(<?=_H(_J($topbottom))?>);" class="page_picker_button"/>
	</div>
</div>
<?}?>
<?function HTML_AnimatedLoadURL($url, $id="1", $header="", $footer="", $image=true) {?>
<div id="animatedloadurl_content_<?=_H($id)?>" align="center">
	<?=$header?><?if($image){?><img src="images/static/loading-animation-7.gif" alt="loading..."/><?}?><?=$footer?>
</div>
<script type="text/javascript">
$(<?=_J("#animatedloadurl_content_" . $id)?>).load(<?=_J(_H($url))?>.replace(/\x26amp;/g, "\x26"));
</script>
<?}?>
<?function HTML_AnimatedLoadNestedURLs(
		$outer_url,
		$inner_url,
		$id="1",
		$sep="",
		$outer_header="",
		$outer_footer="",
		$inner_header="",
		$inner_footer=""
) {
?>
<div id="animatedloadurl_content_<?=_H($id)?>_outer" align="center">
	<?=$outer_header?>
	<?HTML_AnimatedLoadURL($inner_url, $id . "_inner", $inner_header, false, $inner_footer)?>
	<?=$sep?>
	<img src="images/static/loading-animation-7.gif" alt="loading..."/>
	<?=$outer_footer?>
</div>
<script type="text/javascript">
$(<?=_J("#animatedloadurl_content_" . $id . "_outer")?>).load(<?=_J(_H($outer_url))?>.replace(/\x26amp;/g, "\x26"));
</script>
<?}?>
<?function HTML_Footer() {?>




<!--- middle (main content) column end -->
				<br/>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>


<!-- footer begin -->
<div id="footer">
	<table width="100%" border="0">
		<tr style="height: 40px;">
			<td align="left" valign="middle">
				<div id="footer_nav" class="footerNav" style="display: table-cell;height:30px;vertical-align:middle;">
					<a href="https://www.conquerclub.com">Conquer Club</a> |
					<a href="/">Rodrigo Silva</a> |
					<a href="https://github.com/MestreLion/conquerclub">Github Project</a> |
					<a href="mailto:conquerclub@rodrigosilva.com">Contact</a>
				</div>
			</td>
			<td width="20"></td>
			<td align="center">
				<div id="footer_copyright" style="width:100%;text-align:center;display: table-cell;height:30px;vertical-align:middle;">
					MestreLion's Tools is not associated with Conquer Club or RISK online in any way. Copyright &copy; 2016 by MestreLion
				</div>
			</td>
			<td width="20"></td>
			<td align="right">
				<div id="footer_social">
					<a style='padding-left:5px;padding-right:5px;' href='http://facebook.com/rodrigo.es.silva' target="_blank"><img src="images/static/footer-facebookicon.png" alt="facebook"/></a>
					<a style='padding-left:5px;padding-right:5px;' href='http://twitter.com/@RodrigoESSilva'   target="_blank"><img src="images/static/footer-twittericon.png"  alt="twitter"/></a>
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

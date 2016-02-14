<?include "globals.php"?>
<?include "includes/lib_common.php"?>
<?include "includes/lib_html.php"?>
<?php
$page = get_int('page', 1);

HTML_Header("Title");
HTML_Content_Title("Game Finder", "Sorry for copying your layout bigWham, but I'm a programmer, not a designer ;)");
HTML_Pagination($page, 10, 1234, "?page=", "top");
HTML_List_Header();
HTML_List_Item1();
HTML_List_Item2();
HTML_List_Item3();
HTML_List_Footer();
HTML_Pagination(1, 1, 1, "https://www.conquerclub.com/player.php?submit=Search&order=D&p1=MestreLion&p2=Yellow+Peril&page=", "bottom");
HTML_Footer();
?>
<?function HTML_List_Header() {?>
<table class="listing">
	<tr>
		<th>&nbsp;</th>
		<th>Game Type<br />Initial Troops<br />Play Order</th>
		<th>Map</th>
		<th>Spoils<br />Reinforcements<br />Special Gameplay</th>
		<th>Round Limit<br />Round Length<br />Round</th>
		<th>Players</th>
	</tr>
<?}?>
<?function HTML_List_Item1() {?>
	<tr class="odd2">
		<td colspan="7"><b>Tournament Game: <a href="">2016 [Jan] [CC6] PACK vs FISO</a> - FISO Set 1 - 12 hour fog rule</b></td>
	</tr>
	<tr class="odd">
		<td style='vertical-align:top;' align="center">
			<span class="gameno">16254463</span>
			<a class="gameno" href="">Enter Game</a>
		</td>
		<td style='vertical-align:top;'>
			Triples<br />
			Automatic<br />
			Sequential
		</td>
		<td style='vertical-align:top;'>
			Jamaica<br />
			<a href="images/maps/Jamaica3.L.jpg" rel="lightbox" title="Jamaica,75919"><img style="background-image:url(images/maps/Jamaica.thumb.png)" src="images/static/map_normal.png" width="50" height="34" class="thumbnail" alt="Jamaica" title="Jamaica" /></a>
		</td>
		<td style='vertical-align:top;'>
			No Spoils<br />
			Chained<br />
			Fog Trench
		</td>
		<td style='vertical-align:top;'>
			None<br />
			24 Hours<br />
			Round 11
		</td>
		<td style='vertical-align:top;'>
			<ul class="players">
				<li><span class="eliminated"><a class="rank p r11" title="Major kizkiz's Profile" href="">kizkiz</a> <a class="rating" title="Major kizkiz's Ratings" href="">4.9</a></span></li>
				<li><span class="eliminated"><a class="rank p r8" title="Sergeant 1st Class Bobby4254's Profile" href="">Bobby4254</a> <a class="rating" title="Sergeant 1st Class Bobby4254's Ratings" href="">4.9</a></span></li>
				<li><span class="eliminated"><a class="rank p r10" title="Captain Duke_Spirey's Profile" href="">Duke_Spirey</a> <a class="rating" title="Captain Duke_Spirey's Ratings" href="">4.8</a></span></li>
				<li><a class="rank p r6" title="Corporal 1st Class MyTurnToWin's Profile" href="">MyTurnToWin</a> <a class="rating" title="Corporal 1st Class MyTurnToWin's Ratings" href="">4.8</a></li>
				<li><a class="rank p r8" title="Sergeant 1st Class Yellow Peril's Profile" href="">Yellow Peril</a> <a class="rating" title="Sergeant 1st Class Yellow Peril's Ratings" href="">4.6</a></li>
				<li><a class="rank p r12" title="Colonel MestreLion's Profile" href="">MestreLion</a> <a class="rating" title="Colonel MestreLion's Ratings" href="">4.9</a></li>
			</ul>
		</td>
	</tr>
<?}?>
<?function HTML_List_Item2() {?>
	<tr class="even">
		<td style='vertical-align:top;' align="center">
			<span class="gameno">16198006</span>
			<a class="gameno" href="">Enter Game</a>
		</td>
		<td style='vertical-align:top;'>
			Quadruples<br />
			Automatic<br />
			Sequential
		</td>
		<td style='vertical-align:top;'>
			Route 66<br />
			<a href="images/maps/Route_66.L.jpg" rel="lightbox" title="Route 66,67910"><img style="background-image:url(images/maps/Route_66.thumb.png)" src="images/static/map_normal.png" width="50" height="34" class="thumbnail" alt="Route 66" title="Route 66" /></a>
		</td>
		<td style='vertical-align:top;'>
			No Spoils<br />
			Chained<br />
			Fog
		</td>
		<td style='vertical-align:top;'>
			None<br />
			24 Hours<br />
			Round 10
		</td>
		<td style='vertical-align:top;'>
			<ul class="players">
				<li><a class="rank p r11" title="Major Otnal's Profile" href="">Otnal</a> <a class="rating" title="Major Otnal's Ratings" href="">4.8</a></li>
				<li><a class="rank p r6" title="Corporal 1st Class ScaryTeded's Profile" href="">ScaryTeded</a> <a class="rating" title="Corporal 1st Class ScaryTeded's Ratings" href="">4.8</a></li>
				<li><a class="rank p r8" title="Sergeant 1st Class Jimmy V's Profile" href="">Jimmy V</a> <a class="rating" title="Sergeant 1st Class Jimmy V's Ratings" href="">4.9</a></li>
				<li><a class="rank p r12" title="Colonel MestreLion's Profile" href="">MestreLion</a> <a class="rating" title="Colonel MestreLion's Ratings" href="">4.9</a></li>
				<li><span class="eliminated"><a class="rank p r10" title="Captain BIG_John's Profile" href="">BIG_John</a> <a class="rating" title="Captain BIG_John's Ratings" href="">4.8</a></span></li>
				<li><span class="eliminated"><a class="rank p r8" title="Sergeant 1st Class Yellow Peril's Profile" href="">Yellow Peril</a> <a class="rating" title="Sergeant 1st Class Yellow Peril's Ratings" href="">4.6</a></span></li>
				<li><span class="eliminated"><a class="rank p r12" title="Colonel Captn B's Profile" href="">Captn B</a> <a class="rating" title="Colonel Captn B's Ratings" href="">4.9</a></span></li>
				<li><span class="eliminated"><a class="rank p r11" title="Major dyrtydog's Profile" href="">dyrtydog</a> <a class="rating" title="Major dyrtydog's Ratings" href="">4.6</a></span></li>
			</ul>
		</td>
	</tr>
<?}?>
<?function HTML_List_Item3() {?>
	<tr class="odd">
		<td style='vertical-align:top;' align="center">
			<span class="gameno">15435391</span>
			<a class="gameno" href="">Enter Game</a>
		</td>
		<td style='vertical-align:top;'>
			Standard<br />
			Automatic<br />
			Sequential
		</td>
		<td style='vertical-align:top;'>
			Classic<br />
			<a href="images/maps/Classic.L.jpg" rel="lightbox" title="Classic,97975"><img style="background-image:url(images/maps/Classic2.thumb.png)" src="images/static/map_normal.png" width="50" height="34" class="thumbnail" alt="Classic" title="Classic" /></a>
		</td>
		<td style='vertical-align:top;'>
			Escalating<br />
			Chained<br />
			No
		</td>
		<td style='vertical-align:top;'>
			50 Rounds<br />
			24 Hours<br />
			Round 9
		</td>
		<td style='vertical-align:top;'>
			<ul class="players">
				<li><a class="rank p r12" title="Colonel MestreLion's Profile" href="">MestreLion</a> <a class="rating" title="Colonel MestreLion's Ratings" href="">4.9</a></li>
				<li><span class="eliminated"><a class="rank p r8" title="Sergeant 1st Class Yellow Peril's Profile" href="">Yellow Peril</a> <a class="rating" title="Sergeant 1st Class Yellow Peril's Ratings" href="">4.6</a></span></li>
			</ul>
		</td>
	</tr>
<?}?>
<?function HTML_List_Footer() {?>
</table>
<?}?>

#!/bin/bash

if [[ -f common ]]; then
	source common
fi

if [[ "${GET[mode]}" == "matches" ]]; then
	urlcc="https://www.conquerclub.com"
	url="$urlcc/public.php?mode=showclans3"
	league="${GET[league]:-44}"  # Clan League 7 - Second Division
	clanid="${GET[clanid]}"
	post="search_clanleague=${league}&search_clan1=${clanid}&search_status=Active"
	wget -qO- --post-data "$post" -- "$url" |
	awk -v q="'" -v host="$urlcc" -v s='[ \n\t]*' '
		/<table class="listing">/ { ok=1 }
		ok { gsub("href" s "=" s q "/", "href=" q host "/"); print }
		ok && /<\/table>/ { exit }
	'
	exit
fi

htmltableparams=()
scoreboardparams=()

if [[ "${GET[clan]}" ]]; then
	htmltableparams+=(-v mark=2,"${GET[clan]}")
fi

if [[ "${GET[mode]}" == "ongoing" ]]; then
	scoreboardparams+=(--ongoing)
fi

league_scoreboard "${scoreboardparams[@]}" | htmltable "${htmltableparams[@]}"

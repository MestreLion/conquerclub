#!/bin/bash

if [[ -f common ]]; then
	source common
fi

htmltableparams=()

if [[ "${GET[clan]}" ]]; then
	htmltableparams+=(-v mark=2,"${GET[clan]}")
fi

printf "<h4>Finished matches only:</h4>\n"

league_scoreboard | htmltable "${htmltableparams[@]}"

printf "<h4>Including ongoing matches:</h4>\n"

league_scoreboard --ongoing | htmltable "${htmltableparams[@]}"
